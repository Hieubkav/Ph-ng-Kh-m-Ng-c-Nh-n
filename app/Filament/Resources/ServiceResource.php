<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';
    protected static ?string $navigationLabel = 'Dịch vụ';
    protected static ?string $label = 'Dịch vụ';
    protected static ?string $title = 'Dịch vụ';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Tên dịch vụ'),
                Forms\Components\FileUpload::make('image')
                    ->label('Ảnh dịch vụ')
                    ->disk('public')
                    ->directory('uploads/')
                    ->deleteUploadedFileUsing(function ($file) {
                        // Xóa file ảnh khi xóa bài viết hoặc cập nhật ảnh bài viết
                        Storage::disk('public')
                            ->delete($file);
                    })
                    ->image()
                    ->required()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                        '3:4',
                        '9:16',
                    ])
                    ->helperText(fn () => new \Illuminate\Support\HtmlString(
                        'Chỉ chấp nhận các định dạng: <span >jpg, jpeg, png, webp, svg</span>. ' .
                        'Nếu bạn có file ảnh khác (tif, tiff, heic...), vui lòng chuyển đổi sang PNG tại: ' .
                        '<a  style="color:red" href="https://convertio.co/vn/png-converter/" target="_blank">convertio.co</a>'
                    )),
                Forms\Components\RichEditor::make('description')
                ->label('Mô tả')
                ->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên dịch vụ')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Ảnh dịch vụ'),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
