@if(is_numeric($getState()) && $getState() >= 1 && $getState() <= 6)
    <div class="flex items-center justify-center">
        <img src="{{ asset('images/service_icon/' . $getState() . '.webp') }}" 
             alt="Service Icon {{ $getState() }}" 
             class="w-10 h-10 object-contain">
    </div>
@else
    <div class="flex items-center justify-center">
        <span class="text-gray-400">Không có icon</span>
    </div>
@endif
