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
use App\Filament\Resources\ServiceResource\RelationManagers\ServicePostsRelationManager;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';
    protected static ?string $navigationLabel = 'Chuyên mục dịch vụ';
    protected static ?string $label = 'Chuyên mục dịch vụ';
    protected static ?string $title = 'Chuyên mục dịch vụ';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Tên dịch vụ'),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('image')
                            ->label('Chọn Icon dịch vụ')
                            ->options([
                                '1' => '🔬 Kính hiển vi - Xét nghiệm',
                                '2' => '💉 Kim tiêm - Tiêm chủng/Vaccine',
                                '3' => '🧪 Bình thí nghiệm - Hóa sinh/Xét nghiệm chuyên sâu', 
                                '4' => '📋 Clipboard y tế - Khám sức khỏe định kỳ',
                                '5' => '👂 Tai & Checklist - Tai Mũi Họng',
                                '6' => '🩺 Ống nghe - Khám tổng quát',
                            ])
                            ->required()
                            ->reactive()
                            ->helperText('Chọn một trong 6 icon y khoa có sẵn. Mỗi icon đã được thiết kế phù hợp với từng loại dịch vụ')
                            ->columnSpan(1),
                        Forms\Components\Placeholder::make('icon_preview')
                            ->label('Xem trước Icon')
                            ->content(function ($get) {
                                $iconNumber = $get('image');
                                if ($iconNumber && $iconNumber >= 1 && $iconNumber <= 6) {
                                    $iconNames = [
                                        '1' => 'Kính hiển vi',
                                        '2' => 'Kim tiêm & Vaccine',
                                        '3' => 'Bình thí nghiệm',
                                        '4' => 'Clipboard y tế',
                                        '5' => 'Tai Mũi Họng',
                                        '6' => 'Ống nghe'
                                    ];
                                    return new \Illuminate\Support\HtmlString(
                                        '<div class="text-center">
                                            <div class="flex items-center justify-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-lg mb-2">
                                                <img src="/images/service_icon/' . $iconNumber . '.webp" 
                                                     alt="' . $iconNames[$iconNumber] . '" 
                                                     class="w-24 h-24 object-contain">
                                            </div>
                                            <p class="text-sm text-gray-600 font-medium">' . $iconNames[$iconNumber] . '</p>
                                        </div>'
                                    );
                                }
                                return new \Illuminate\Support\HtmlString(
                                    '<div class="flex items-center justify-center p-8 bg-gray-50 rounded-lg text-gray-400">
                                        <span>Chọn icon để xem trước</span>
                                    </div>'
                                );
                            })
                            ->columnSpan(1)
                    ]),
                Forms\Components\TextInput::make('order_service')
                    ->label('Thứ tự hiển thị')
                    ->numeric()
                    ->default(0)
                    ->helperText('Giá trị càng nhỏ thì sẽ được hiển thị trước (mặc định là 0)'),
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
                Tables\Columns\ViewColumn::make('image')
                    ->label('Icon dịch vụ')
                    ->view('filament.tables.columns.service-icon'),
                Tables\Columns\TextColumn::make('order_service')
                    ->label('Thứ tự hiển thị')
                    ->sortable(),
                Tables\Columns\TextColumn::make('servicePosts_count')
                    ->label('Số bài viết')
                    ->getStateUsing(function ($record) {
                        return $record->servicePosts()->count();
                    })
                    ->sortable(),
            ])
            ->defaultSort('order_service')
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
            ServicePostsRelationManager::class,
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
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
