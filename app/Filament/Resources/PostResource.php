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
use Filament\Forms\Components\ViewField;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Bài viết';
    protected static ?string $label = 'Bài viết';
    protected static ?string $title = 'Bài viết';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Tên bài viết')
                    ->required(),
                Forms\Components\Select::make('cat_post_id')
                    ->label('Chuyên mục')
                    ->relationship('cat_post', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\FileUpload::make('pdf')
                    ->label('File PDF')
                    ->disk('public')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(1024000)
                    ->required(false)
                    ->preserveFilenames()
                    ->directory('uploads/')
                    ->deleteUploadedFileUsing(function ($file) {
                        // Xóa file PDF khi xóa bài viết hoặc cập nhật file PDF
                        Storage::disk('public')
                            ->delete($file);
                    }),
                ViewField::make('pdf_buttons')
                    ->view('filament.forms.components.pdf-buttons')
                    ->visible(function ($get) {
                        return $get('pdf') !== null;
                    }),
                Forms\Components\RichEditor::make('content')
                    ->label('Nội dung')
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
                    ->default('not_hot'),
            ]);
    }

    public static function table(Table $table): Table
    {
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
                    ->formatStateUsing(fn(string $state): string => $state === 'hot' ? 'Tin nổi bật' : 'Không nổi bật')
                    ->color(
                        fn(string $state): string =>
                        $state === 'hot'
                            ? 'success' // màu xanh lá cho tin nổi bật
                            : 'gray' // màu xám cho tin không nổi bật
                    )
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('cat_post.name')
                    ->label('Chuyên mục'),
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
            ])
            ;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
