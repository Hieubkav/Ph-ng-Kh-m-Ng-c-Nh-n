<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatPostResource\Pages;
use App\Filament\Resources\CatPostResource\RelationManagers;
use App\Models\CatPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CatPostResource extends Resource
{
    protected static ?string $model = CatPost::class;
    protected static ?string $navigationLabel = 'Chuyên mục tin';
    protected static ?string $label = 'Chuyên mục tin';
    protected static ?string $title = 'Chuyên mục tin';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Tên chuyên mục')
                    ->required(),
                Forms\Components\Textarea::make('content')
                    ->label('Nội dung chuyên mục')
                    ->rows(3),
                Forms\Components\Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'show' => 'Hiển thị',
                        'hide' => 'Ẩn'
                    ])
                    ->default('show')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Tên danh mục')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('status')
                ->label('Trạng thái')
                ->badge()
                ->formatStateUsing(fn(string $state): string => $state === 'show' ? 'Hiển thị' : 'Ẩn')
                ->color(fn(string $state): string => $state === 'show' ? 'success' : 'danger')
                ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                ->label('Ngày tạo')
                ->date('d-m-Y'),
                Tables\Columns\TextColumn::make('posts_count')
                ->label('Số bài viết')
                ->counts('posts')
                ->sortable()
                ->alignCenter()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCatPosts::route('/'),
            'create' => Pages\CreateCatPost::route('/create'),
            'edit' => Pages\EditCatPost::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
