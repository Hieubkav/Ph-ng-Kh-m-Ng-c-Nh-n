<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    
    protected static ?string $navigationLabel = 'Lịch Khám';

    protected static ?string $modelLabel = 'lịch khám';

    protected static ?string $pluralModelLabel = 'lịch khám';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(fn() => Auth::id()),
                    
                Forms\Components\TextInput::make('title')
                    ->label('Tiêu đề')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\RichEditor::make('description')
                    ->label('Mô tả')
                    ->required()
                    ->columnSpanFull(),
                    
                Forms\Components\FileUpload::make('url_thumbnail')
                    ->label('Hình ảnh')
                    ->image()
                    ->imageEditor()
                    ->directory('schedules')
                    ->required()
                    ->columnSpanFull()
                    ->helperText(fn () => new \Illuminate\Support\HtmlString(
                        'Chỉ chấp nhận các định dạng: <span >jpg, jpeg, png, webp, svg</span>. ' .
                        'Nếu bạn có file ảnh khác (tif, tiff, heic...), vui lòng chuyển đổi sang PNG tại: ' .
                        '<a  style="color:red" href="https://convertio.co/vn/png-converter/" target="_blank">convertio.co</a>'
                    )),
                    
                Forms\Components\Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'hidden' => 'Ẩn',
                        'show' => 'Hiển thị',
                    ])
                    ->default('hidden')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state) {
                        if ($state === 'show') {
                            Schedule::where('id', '!=', request()->route('record'))
                                ->update(['status' => 'hidden']);
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('url_thumbnail')
                    ->label('Hình ảnh')
                    ->square(),
                    
                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('description')
                    ->label('Mô tả')
                    ->limit(50)
                    ->html(),
                    
                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'hidden' => 'Ẩn',
                        'show' => 'Hiển thị',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'hidden' => 'danger',
                        'show' => 'success',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'hidden' => 'Ẩn',
                        'show' => 'Hiển thị',
                    ]),
            ])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('created_at', 'desc');
    }
}