<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorResource\Pages;
use App\Filament\Resources\DoctorResource\RelationManagers;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Bác sĩ';
    protected static ?string $label = 'Bác sĩ';
    protected static ?string $title = 'Bác sĩ';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Tên bác sĩ')
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->label('Mô tả bác sĩ')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->label('Ảnh bác sĩ')
                    ->disk('public')
                    ->directory('uploads/')
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
                    ))
                    ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Ảnh bác sĩ'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Mô tả bác sĩ')
                    ->limit(50),
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
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
