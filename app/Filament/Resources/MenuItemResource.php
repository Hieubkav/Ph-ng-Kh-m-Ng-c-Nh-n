<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Models\MenuItem;
use App\Models\CatPost;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';
    
    protected static ?string $navigationLabel = 'Menu động';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('parent_id')
                    ->label('Menu cha')
                    ->relationship('parent', 'label')
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('label')
                    ->required()
                    ->maxLength(255)
                    ->label('Tên hiển thị'),

                Forms\Components\Select::make('type')
                    ->options([
                        'link' => 'Link tùy chỉnh',
                        'cat' => 'Danh mục',
                        'post' => 'Bài viết',
                    ])
                    ->required()
                    ->live()
                    ->default('link')
                    ->label('Loại menu'),

                Forms\Components\TextInput::make('link')
                    ->required()
                    ->maxLength(255)
                    ->label('URL')
                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'link'),

                Forms\Components\Select::make('cat_id')
                    ->label('Chọn danh mục')
                    ->options(CatPost::query()->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'cat'),

                Forms\Components\Select::make('post_id')
                    ->label('Chọn bài viết')
                    ->options(Post::query()->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'post'),

                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->label('Thứ tự'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('indent_label')
                    ->label('Tên')
                    ->getStateUsing(function (MenuItem $record): string {
                        $indent = str_repeat('— ', $record->level());
                        return $indent . $record->label;
                    })
                    ->searchable(query: function ($query, $search) {
                        return $query->where('label', 'like', "%{$search}%");
                    }),
                Tables\Columns\TextColumn::make('parent.label')
                    ->label('Menu cha')   
                    ->placeholder('Menu gốc')
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'link' => 'Link tùy chỉnh',
                        'cat' => 'Danh mục',
                        'post' => 'Bài viết',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('url')
                    ->getStateUsing(fn (MenuItem $record): string => $record->getUrl())
                    ->label('URL'),
                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->label('Thứ tự')
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
