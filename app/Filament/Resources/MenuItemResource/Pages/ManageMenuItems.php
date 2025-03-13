<?php

namespace App\Filament\Resources\MenuItemResource\Pages;

use App\Filament\Resources\MenuItemResource;
use SolutionForest\FilamentTree\Pages\TreePage;

class ManageMenuItems extends TreePage
{
    protected static string $resource = MenuItemResource::class;

    protected function getTreeContent(): ?string
    {
        return view('filament.resources.menu-item-resource.pages.menu-items-tree')
            ->with([
                'records' => $this->getRecords(),
                'resource' => static::getResource(),
                'relationship' => null,
            ])
            ->render();
    }
}