<?php

namespace App\Filament\Resources\ServiceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\ViewField;

class ServicePostsRelationManager extends RelationManager
{
    protected static string $relationship = 'servicePosts';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Bài viết dịch vụ';

    protected static ?string $label = 'Bài viết dịch vụ';

    protected static ?string $modelLabel = 'Bài viết dịch vụ';

    public function form(Form $form): Form
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
                            
                        Forms\Components\RichEditor::make('content')
                            ->label('Nội dung bài viết')
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('uploads')
                            ->columnSpan(2),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Hình ảnh và tài liệu')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Ảnh đại diện')
                            ->disk('public')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->directory('uploads')
                            ->maxSize(2048)
                            ->helperText('Định dạng: jpg, png, webp. Kích thước tối đa: 2MB')
                            ->columnSpan(1),
                            
                        Forms\Components\FileUpload::make('pdf')
                            ->label('File PDF')
                            ->disk('public')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(10240)
                            ->preserveFilenames()
                            ->directory('uploads/')
                            ->deleteUploadedFileUsing(function ($file) {
                                Storage::disk('public')->delete($file);
                            })
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                    
                Tables\Columns\ImageColumn::make('image')
                    ->label('Ảnh')
                    ->disk('public')
                    ->circular()
                    ->visibility(fn ($record) => $record->show_image === 'show'),
                    
                Tables\Columns\IconColumn::make('show_image')
                    ->label('Hiển thị ảnh')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->date('d-m-Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('show_image')
                    ->label('Hiển thị ảnh')
                    ->options([
                        'show' => 'Hiển thị',
                        'hide' => 'Ẩn'
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
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
}