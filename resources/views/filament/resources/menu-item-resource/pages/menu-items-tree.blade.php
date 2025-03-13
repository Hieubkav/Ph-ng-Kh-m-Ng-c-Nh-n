@php
    use SolutionForest\FilamentTree\Support\Utils;
@endphp

<div class="tree-container">
    @if ($records->count())
        <ul class="tree-root">
            @foreach($records as $record)
                <x-filament-tree::tree-item
                    :record="$record"
                    :resource="$resource"
                    :relationship="$relationship"
                >
                    <div class="flex items-center space-x-2">
                        <span>{{ $record->label }}</span>
                        <span class="text-sm text-gray-500">
                            @switch($record->type)
                                @case('link')
                                    (Link: {{ $record->link }})
                                    @break
                                @case('cat')
                                    (Danh mục: {{ $record->cat_post?->name ?? 'N/A' }})
                                    @break
                                @case('post')
                                    (Bài viết: {{ $record->post?->name ?? 'N/A' }})
                                    @break
                            @endswitch
                        </span>
                    </div>
                </x-filament-tree::tree-item>
            @endforeach
        </ul>
    @else
        <div class="p-4 text-center text-gray-500">
            Chưa có menu nào được tạo
        </div>
    @endif
</div>

@pushOnce('styles')
<style>
    .tree-container {
        padding: 1rem;
    }
    .tree-root {
        list-style: none;
        padding: 0;
    }
</style>
@endPushOnce