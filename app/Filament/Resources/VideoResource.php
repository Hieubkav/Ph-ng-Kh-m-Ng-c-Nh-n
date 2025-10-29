<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-play-circle';
    protected static ?string $navigationLabel = 'Video YouTube';
    protected static ?string $label = 'Video YouTube';
    protected static ?string $title = 'Video YouTube';
    protected static ?int $navigationSort = 6;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin video')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Tên video')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('youtube_url')
                            ->label('Đường dẫn YouTube')
                            ->required()
                            ->url()
                            ->helperText('Dán URL của video YouTube, hệ thống sẽ tự lấy ảnh và mã nhúng.'),
                        Forms\Components\TextInput::make('display_order')
                            ->label('Thứ tự hiển thị')
                            ->numeric()
                            ->default(0)
                            ->helperText('Số nhỏ hơn sẽ xuất hiện trước trong danh sách.'),
                        Forms\Components\Toggle::make('is_hot')
                            ->label('Hiển thị nổi bật (to)')
                            ->helperText('Đánh dấu video làm nổi bật ở khung lớn bên trái.'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Kích hoạt')
                            ->default(true),
                        Forms\Components\ViewField::make('video_preview')
                            ->label('Xem trước')
                            ->view('filament.forms.components.video-preview')
                            ->visible(fn ($record) => filled($record?->embed_url)),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Tên video')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('display_order')
                    ->label('Thứ tự')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_hot')
                    ->label('Nổi bật')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Kích hoạt')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->defaultSort('display_order')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
