<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicePostResource\Pages;
use App\Filament\Resources\ServicePostResource\RelationManagers;
use App\Models\ServicePost;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Malzariey\FilamentLexicalEditor\FilamentLexicalEditor;
use Malzariey\FilamentLexicalEditor\Enums\ToolbarItem;

class ServicePostResource extends Resource
{
    protected static ?string $model = ServicePost::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Bài viết dịch vụ';
    
    protected static ?string $modelLabel = 'Bài viết dịch vụ';
    
    // protected static ?string $navigationGroup = 'Quản lý dịch vụ';
    
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin bài viết')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Tiêu đề bài viết')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255)
                            ->placeholder('Nhập tiêu đề bài viết')
                            ->columnSpan(2),
                            
                        Forms\Components\Select::make('service_id')
                            ->label('Dịch vụ')
                            ->options(Service::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->columnSpan(2),
                            
                        FilamentLexicalEditor::make('content')
                            ->label('Nội dung bài viết')
                            ->required()
                            ->columnSpan(2)
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
                    ])->columns(2),
                    
                Forms\Components\Section::make('Hình ảnh và tài liệu')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Ảnh đại diện')
                            ->disk('public')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->directory('uploads')
                            ->maxSize(5120)
                            ->preserveFilenames()
                            ->helperText('Định dạng: jpg, png, webp. Kích thước tối đa: 5MB')
                            ->columnSpan(1),
                            
                        Forms\Components\FileUpload::make('pdf')
                            ->label('File PDF')
                            ->disk('public')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(10240)
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
                        Forms\Components\Select::make('show_image')
                            ->label('Hiển thị ảnh')
                            ->options([
                                'show' => 'Hiển thị',
                                'hide' => 'Ẩn'
                            ])
                            ->default('show')
                            ->columnSpan(1),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Ảnh')
                    ->disk('public')
                    ->circular()
                    ->visibility(fn ($record) => $record->show_image === 'show'),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Dịch vụ')
                    ->sortable(),
                    
                // Tables\Columns\TextColumn::make('created_at')
                //     ->label('Ngày tạo')
                //     ->date('d-m-Y')
                //     ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('show_image')
                    ->label('Hiển thị ảnh')
                    ->options([
                        'show' => 'Hiển thị',
                        'hide' => 'Ẩn'
                    ]),
                    
                Tables\Filters\SelectFilter::make('service_id')
                    ->label('Dịch vụ')
                    ->relationship('service', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_frontend')
                    ->label('Xem trang')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (ServicePost $record): string => route('servicePost', [
                        'serviceId' => $record->service_id,
                        'slug' => $record->slug,
                    ]))
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServicePosts::route('/'),
            'create' => Pages\CreateServicePost::route('/create'),
            'edit' => Pages\EditServicePost::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
