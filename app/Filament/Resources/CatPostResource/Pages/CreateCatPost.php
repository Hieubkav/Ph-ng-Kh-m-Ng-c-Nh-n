<?php

namespace App\Filament\Resources\CatPostResource\Pages;

use App\Filament\Resources\CatPostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCatPost extends CreateRecord
{
    protected static string $resource = CatPostResource::class;
}
