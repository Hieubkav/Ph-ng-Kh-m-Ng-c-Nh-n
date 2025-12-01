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
use Malzariey\FilamentLexicalEditor\FilamentLexicalEditor;
use Malzariey\FilamentLexicalEditor\Enums\ToolbarItem;

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
                Forms\Components\Section::make('Thông tin cơ bản')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Tên bài viết')
                            ->required()
                            ->columnSpan('full'),
                            
                        Forms\Components\Select::make('cat_post_id')
                            ->label('Chuyên mục')
                            ->relationship('cat_post', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(1),
                            
                        Forms\Components\Hidden::make('user_id')
                            ->default(fn() => Auth::id()),
                    ])->columns(2),

                Forms\Components\Section::make('Nội dung')
                    ->schema([
                        FilamentLexicalEditor::make('content')
                            ->label('Nội dung')
                            ->required()
                            ->columnSpanFull()
                            ->enabledToolbars([
                                ToolbarItem::UNDO,
                                ToolbarItem::REDO,
                                ToolbarItem::DIVIDER,
                                ToolbarItem::NORMAL,
                                ToolbarItem::H1,
                                ToolbarItem::H2,
                                ToolbarItem::H3,
                                ToolbarItem::DIVIDER,
                                ToolbarItem::BOLD,
                                ToolbarItem::ITALIC,
                                ToolbarItem::UNDERLINE,
                                ToolbarItem::STRIKETHROUGH,
                                ToolbarItem::DIVIDER,
                                ToolbarItem::FONT_FAMILY,
                                ToolbarItem::FONT_SIZE,
                                ToolbarItem::DIVIDER,
                                ToolbarItem::TEXT_COLOR,
                                ToolbarItem::BACKGROUND_COLOR,
                                ToolbarItem::DIVIDER,
                                ToolbarItem::LEFT,
                                ToolbarItem::CENTER,
                                ToolbarItem::RIGHT,
                                ToolbarItem::JUSTIFY,
                                ToolbarItem::DIVIDER,
                                ToolbarItem::BULLET,
                                ToolbarItem::NUMBERED,
                                ToolbarItem::QUOTE,
                                ToolbarItem::DIVIDER,
                                ToolbarItem::INDENT,
                                ToolbarItem::OUTDENT,
                                ToolbarItem::DIVIDER,
                                ToolbarItem::HR,
                                ToolbarItem::IMAGE,
                                ToolbarItem::CLEAR,
                            ])
                            ->helperText('💡 Lưu ý: Để căn lề (trái/giữa/phải/đều) cho một cụm chữ, bạn cần XUỐNG DÒNG (Enter) trước và sau cụm chữ đó. Editor đã có sẵn các font: Arial, Georgia, Impact, Tahoma, Times New Roman, Verdana.'),
                    ]),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Ảnh bài viết')
                            ->disk('public')
                            ->directory('uploads/')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                            ->columnSpan(1)
                            ->helperText(fn () => new \Illuminate\Support\HtmlString(
                                'Chỉ chấp nhận các định dạng: <span >jpg, jpeg, png, webp, svg</span>. ' .
                                'Nếu bạn có file ảnh khác (tif, tiff, heic...), vui lòng chuyển đổi sang PNG tại: ' .
                                '<a  style="color:red" href="https://convertio.co/vn/png-converter/" target="_blank">convertio.co</a>'
                            ))
                            ->preserveFilenames()
                            ->maxSize(5120),
                            
                        Forms\Components\FileUpload::make('pdf')
                            ->label('File PDF')
                            ->disk('public')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(1024000)
                            ->preserveFilenames()
                            ->directory('uploads/')
                            ->columnSpan(1),
                            
                        ViewField::make('pdf_buttons')
                            ->view('filament.forms.components.pdf-buttons')
                            ->visible(fn ($get) => $get('pdf') !== null)
                            ->columnSpan(2),
                    ])->columns(2),

                Forms\Components\Section::make('Tùy chọn hiển thị')
                    ->schema([
                        Forms\Components\Select::make('is_hot')
                            ->label('Tin tức nổi bật')
                            ->options([
                                'hot' => 'Tin nổi bật',
                                'not_hot' => 'Không nổi bật'
                            ])
                            ->default('not_hot')
                            ->columnSpan(1),
                            
                        Forms\Components\Select::make('show_image')
                            ->label('Hiển thị ảnh')
                            ->options([
                                'show' => 'Hiển thị',
                                'hide' => 'Ẩn'
                            ])
                            ->default('show')
                            ->columnSpan(1),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Ảnh')
                    ->circular()
                    ->visibility(fn ($record) => $record->show_image === 'show'),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('cat_post.name')
                    ->label('Chuyên mục')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('is_hot')
                    ->label('Tin nổi bật')
                    ->formatStateUsing(fn(string $state): string => $state === 'hot' ? 'Tin nổi bật' : 'Không nổi bật')
                    ->color(fn(string $state): string => $state === 'hot' ? 'success' : 'gray')
                    ->alignCenter(),
                    
                // Tables\Columns\TextColumn::make('created_at')
                //     ->label('Ngày tạo')
                //     ->date('d-m-Y')
                //     ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_hot')
                    ->label('Tin nổi bật')
                    ->options([
                        'hot' => 'Tin nổi bật',
                        'not_hot' => 'Không nổi bật'
                    ]),
                    
                Tables\Filters\SelectFilter::make('show_image')
                    ->label('Hiển thị ảnh')
                    ->options([
                        'show' => 'Hiển thị',
                        'hide' => 'Ẩn'
                    ]),
                    
                Tables\Filters\SelectFilter::make('cat_post_id')
                    ->label('Chuyên mục')
                    ->relationship('cat_post', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_frontend')
                    ->label('Xem trang')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Post $record): string => route('post', $record->slug))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
