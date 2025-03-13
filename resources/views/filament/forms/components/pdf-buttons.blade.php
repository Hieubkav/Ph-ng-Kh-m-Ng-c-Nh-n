@php
    $record = $getRecord();
    $pdfPath = $record->pdf ?? null;
@endphp

@if($pdfPath)
    <div class="flex space-x-2 mt-2">
        <a href="{{ asset('storage/' . $pdfPath) }}" target="_blank" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">
            Xem PDF
        </a>
        <a href="{{ asset('storage/' . $pdfPath) }}" download class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-success-600 hover:bg-success-500 focus:bg-success-700 focus:ring-offset-success-700">
            Tải xuống
        </a>
    </div>
@endif
