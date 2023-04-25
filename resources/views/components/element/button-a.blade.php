@props([
'href' => '',
'theme' => 'primary',
])
@php
if (!function_exists('getThemeClassForButtonA')){
function getThemeClassForButtonA($theme){
return match ($theme) {
'primary' => 'bg-blue-500 hover:bg-blue-600 text-white forcus:ring-blue-500',
'secondary' => 'bg-red-500 hover:bg-red-600 text-white forcus:ring-red-500',
default => '',
};
}
}
@endphp
<a href="{{ $href }}"
    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 {{ getThemeClassForButtonA($theme) }}">
    {{ $slot }}
</a>