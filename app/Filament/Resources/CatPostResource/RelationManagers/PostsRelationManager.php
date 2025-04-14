<?php

namespace App\Filament\Resources\CatPostResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Post;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static ?string $recordTitleAttribute = 'name';
    
    protected static ?string $title = 'Bài viết';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên bài viết')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d-m-Y H:i'),
                Tables\Columns\IconColumn::make('is_hot')
                    ->label('Tin hot')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn ($record) => '/admin/posts/'.$record->id.'/edit')
                    ->label('Xem bài viết')
                    ->icon('heroicon-m-eye')
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('move')
                    ->label('Chuyển sang chuyên mục khác')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->form([
                        Forms\Components\Select::make('cat_post_id')
                            ->label('Chọn chuyên mục')
                            ->options(function () {
                                return \App\Models\CatPost::where('id', '!=', $this->ownerRecord->id)
                                    ->pluck('name', 'id');
                            })
                            ->required()
                    ])
                    ->action(function (Post $record, array $data): void {
                        $record->update([
                            'cat_post_id' => $data['cat_post_id']
                        ]);
                    }),
            ])
            ->headerActions([
                Tables\Actions\Action::make('moveFromOther')
                    ->label('Thêm bài viết từ chuyên mục khác')
                    ->icon('heroicon-o-plus-circle')
                    ->form([
                        Forms\Components\Select::make('post_id')
                            ->label('Chọn bài viết')
                            ->options(function () {
                                return Post::where('cat_post_id', '!=', $this->ownerRecord->id)
                                    ->pluck('name', 'id');
                            })
                            ->required()
                            ->searchable()
                    ])
                    ->action(function (array $data): void {
                        Post::find($data['post_id'])->update([
                            'cat_post_id' => $this->ownerRecord->id
                        ]);
                    }),
            ]);
    }
}