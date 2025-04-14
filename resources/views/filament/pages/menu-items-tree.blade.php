<x-filament::page>
    <div class="space-y-6">
        <div
            wire:sortable
            wire:end.stop="reorder($event.target.sortable.toArray())"
            class="space-y-2"
        >
            @foreach ($this->records as $record)
                <div
                    wire:key="menu-item-{{ $record->id }}"
                    wire:sortable.item="{{ $record->id }}"
                    class="bg-white rounded-lg shadow"
                >
                    <div class="flex items-center gap-4 p-4">
                        <div
                            wire:sortable.handle
                            class="flex items-center gap-1 cursor-move"
                        >
                            <x-heroicon-o-bars-3 class="w-4 h-4 text-gray-400" />
                            @php
                                $icon = $this->getTreeRecordIcon($record);
                            @endphp
                            @if ($icon)
                                <x-dynamic-component
                                    :component="$icon"
                                    class="w-4 h-4"
                                />
                            @endif
                        </div>

                        <div class="flex-1 text-sm">
                            {{ $this->getTreeRecordTitle($record) }}
                        </div>

                        <div class="flex items-center gap-2">
                            @foreach ($this->getTreeActions() as $action)
                                {{ $action }}
                            @endforeach
                        </div>
                    </div>

                    @if ($record->children->count())
                        <div
                            wire:sortable.item-group="{{ $record->id }}"
                            class="pl-8 pr-4 pb-4 space-y-2"
                        >
                            @foreach ($record->children as $child)
                                <div
                                    wire:key="menu-item-{{ $child->id }}"
                                    wire:sortable.item="{{ $child->id }}"
                                    class="bg-gray-50 rounded-lg shadow-sm"
                                >
                                    <div class="flex items-center gap-4 p-3">
                                        <div
                                            wire:sortable.handle
                                            class="flex items-center gap-1 cursor-move"
                                        >
                                            <x-heroicon-o-bars-3 class="w-4 h-4 text-gray-400" />
                                            @php
                                                $icon = $this->getTreeRecordIcon($child);
                                            @endphp
                                            @if ($icon)
                                                <x-dynamic-component
                                                    :component="$icon"
                                                    class="w-4 h-4"
                                                />
                                            @endif
                                        </div>

                                        <div class="flex-1 text-sm">
                                            {{ $this->getTreeRecordTitle($child) }}
                                        </div>

                                        <div class="flex items-center gap-2">
                                            @foreach ($this->getTreeActions() as $action)
                                                {{ $action }}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-filament::page>