<?php

namespace App\Filament\Resources\CatPostResource\Pages;

use App\Filament\Resources\CatPostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatPost extends EditRecord
{
    protected static string $resource = CatPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
