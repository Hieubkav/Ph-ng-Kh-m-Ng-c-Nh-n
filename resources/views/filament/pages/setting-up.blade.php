<x-filament-panels::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-6">
            Lưu cài đặt
        </x-filament::button>
    </form>
</x-filament-panels::page>
