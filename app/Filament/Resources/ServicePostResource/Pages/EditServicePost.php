<?php

namespace App\Filament\Resources\ServicePostResource\Pages;

use App\Filament\Resources\ServicePostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServicePost extends EditRecord
{
    protected static string $resource = ServicePostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_frontend')
                ->label('Xem trang')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('servicePost', [
                    'serviceId' => $this->record->service_id,
                    'postId' => $this->record->id,
                ]))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }
}
