<?php

namespace App\Filament\Resources\MenuItemResource\Widgets;

use App\Models\MenuItem;
use SolutionForest\FilamentTree\Widgets\Tree as BaseWidget;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class MenuItemTree extends BaseWidget
{
    protected static string $model = MenuItem::class;

    protected static int $maxDepth = 2;

    protected ?string $treeTitle = 'Menu Động';

    protected bool $enableTreeTitle = true;

    protected bool $enableReorder = true;

    protected bool $enableCollapse = true;

    protected bool $enableDragAndDrop = true;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('label'),
        ];
    }
    
    protected function hasDeleteAction(): bool
    {
        return true;
    }

    protected function hasEditAction(): bool
    {
        return true;
    }

    protected function hasViewAction(): bool
    {
        return false;
    }

    public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    {
        return null;
    }

    public function getTreeQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return static::getModel()::query()
            ->with(['children' => function ($query) {
                $query->orderBy('order');
            }])
            ->whereNull('parent_id')
            ->orderBy('order');
    }

    public function getRecordKey(?\Illuminate\Database\Eloquent\Model $record): string
    {
        return (string) $record?->id;
    }

    public function getParentKey(?\Illuminate\Database\Eloquent\Model $record): ?string
    {
        return $record?->parent_id ? (string) $record->parent_id : null;
    }

    public function getRecordTitle(?\Illuminate\Database\Eloquent\Model $record): string
    {
        return $record?->label ?? '';
    }

    public function getChildrenByParentKey(?string $parentKey = null): \Illuminate\Support\Collection
    {
        if ($parentKey === null) {
            return $this->getTreeQuery()->get();
        }

        return static::getModel()::query()
            ->where('parent_id', $parentKey)
            ->orderBy('order')
            ->get();
    }
    
    public function updateTree(?array $tree = null): array
    {
        if ($tree) {
            $items = [];
            $this->flattenTree($tree, $items);
            
            foreach ($items as $item) {
                /** @var \App\Models\MenuItem|null */
                $record = static::getModel()::find($item['id']);
                if ($record) {
                    $record->parent_id = $item['parent_id'];
                    $record->order = $item['order'];
                    $record->saveQuietly();
                }
            }

            Notification::make()
                ->success()
                ->title('Đã lưu thay đổi thành công')
                ->send();
        }
        
        return ['success' => true];
    }

    private function flattenTree(array $tree, array &$result, $parentId = null): void
    {
        foreach ($tree as $index => $node) {
            $result[] = [
                'id' => $node['id'],
                'parent_id' => $parentId,
                'order' => $index
            ];

            if (isset($node['children']) && !empty($node['children'])) {
                $this->flattenTree($node['children'], $result, $node['id']);
            }
        }
    }
}