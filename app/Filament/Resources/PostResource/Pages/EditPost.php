<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_frontend')
                ->label('Xem trang')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('post', $this->record->id))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }
}
