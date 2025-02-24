<?php

namespace App\Filament\Resources\CatPostResource\Pages;

use App\Filament\Resources\CatPostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatPosts extends ListRecords
{
    protected static string $resource = CatPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
