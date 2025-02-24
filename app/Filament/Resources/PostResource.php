<?php

    namespace App\Filament\Resources;

    use App\Filament\Resources\PostResource\Pages;
    use App\Filament\Resources\PostResource\RelationManagers;
    use App\Models\Post;
    use Filament\Forms;
    use Filament\Forms\Form;
    use Filament\Resources\Resource;
    use Filament\Tables;
    use Filament\Tables\Table;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;

    class PostResource extends Resource {
        protected static ?string $model = Post::class;

        protected static ?string $navigationIcon = 'heroicon-o-document-text';
        protected static ?string $label = 'Bài viết';
        protected static ?int $navigationSort = 1;

        public static function form(Form $form): Form {
            return $form
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Tên danh mục')
                        ->required(),
                    Forms\Components\Select::make('cat_post_id')
                        ->label('Danh mục')
                        ->relationship('cat_post', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\RichEditor::make('content')
                        ->label('Nội dung')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('image')
                        ->label('Ảnh bài viết')
                        ->disk('public')
                        ->directory('uploads/')
                        ->deleteUploadedFileUsing(function ($file) {
                            // Xóa file ảnh khi xóa bài viết hoặc cập nhật ảnh bài viết
                            Storage::disk('public')
                                ->delete($file);
                        })
                        ->image()
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                            '3:4',
                            '9:16',
                        ]),
                    Forms\Components\Hidden::make('user_id')
                        ->default(fn() => Auth::id()),
                    Forms\Components\Select::make('is_hot')
                        ->label('Tin tức nổi bật')
                        ->options([
                            'hot' => 'Tin nổi bật',
                            'not_hot' => 'Không nổi bật'
                        ])
                        ->required()
                ]);
        }

        public static function table(Table $table): Table {
            return $table
                ->columns([
                    Tables\Columns\TextColumn::make('name')
                        ->label('Tiêu đề')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\ImageColumn::make('image')
                        ->label('Ảnh'),
                    Tables\Columns\TextColumn::make('is_hot')
                        ->label('Tin nổi bật')
                        ->formatStateUsing(fn (string $state): string => $state === 'hot' ? 'Tin nổi bật' : 'Không nổi bật')
                        ->color(fn (string $state): string =>
                            $state === 'hot'
                                ? 'success' // màu xanh lá cho tin nổi bật
                                : 'gray' // màu xám cho tin không nổi bật
                        )
                        ->alignCenter(),
                    Tables\Columns\TextColumn::make('cat_post.name')
                        ->label('Danh mục'),
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

        public static function getRelations(): array {
            return [
                //
            ];
        }

        public static function getNavigationBadge(): ?string {
            return static::getModel()::count();
        }

        public static function getPages(): array {
            return [
                'index' => Pages\ListPosts::route('/'),
                'create' => Pages\CreatePost::route('/create'),
                'edit' => Pages\EditPost::route('/{record}/edit'),
            ];
        }
    }
