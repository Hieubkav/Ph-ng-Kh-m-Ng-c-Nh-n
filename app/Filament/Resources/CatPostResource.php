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
    protected static ?string $label = 'Danh Mục Bài Viết';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Tên danh mục')
                    ->required(),
                Forms\Components\Textarea::make('content')
                    ->label('Nội dung')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Tên danh mục')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                ->label('Ngày tạo')
                ->date('d-m-Y')
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
            //
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
}
