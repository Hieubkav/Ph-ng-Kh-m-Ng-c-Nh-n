<div
    wire:key="tree-item-{{ $record->id }}"
    wire:sortable.item="{{ $record->id }}"
    @class([
        'pl-4 relative',
        'mt-2' => $level > 0,
    ])
>
    <div class="flex items-center gap-2 p-2 bg-white border border-gray-300 rounded-lg shadow-sm">
        <div wire:sortable.handle class="flex items-center gap-2 cursor-move">
            <x-heroicon-o-bars-3 class="w-4 h-4 text-gray-400"/>
            
            @if($record->type === 'link')
                <x-heroicon-o-link class="w-4 h-4 text-blue-500"/>
            @elseif($record->type === 'category')
                <x-heroicon-o-folder class="w-4 h-4 text-yellow-500"/>
            @elseif($record->type === 'page')
                <x-heroicon-o-document class="w-4 h-4 text-green-500"/>
            @else
                <x-heroicon-o-menu class="w-4 h-4 text-gray-500"/>
            @endif
        </div>

        <div class="flex-1 text-sm">
            {{ $record->label }}
            
            @if($record->type === 'link')
                <span class="text-xs text-gray-500">({{ $record->link }})</span>
            @endif
        </div>

        <div class="flex items-center gap-2">
            {{ $this->renderTreeActions($record) }}
        </div>
    </div>

    @if($record->children->count() > 0)
        <div
            wire:sortable.item-group="{{ $record->id }}"
            @class([
                'pl-4',
                'mt-2' => $level > 0,
            ])
        >
            @foreach($record->children as $child)
                @include('filament.pages.menu-items-tree.item', [
                    'record' => $child,
                    'records' => $child->children,
                    'level' => $level + 1,
                ])
            @endforeach
        </div>
    @endif
</div>