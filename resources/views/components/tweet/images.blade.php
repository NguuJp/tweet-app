@props([
'images' => [],
])

@if (count($images) > 0)
<div class="px-2" x-data="{}">
    <div class="flex justify-center -mx-2">
        @foreach ($images as $image)
        <div class="w-1/4 px-2 mt-5">
            <div class="bg-gray-400">
                <a @click="$dispatch('img-modal', { imgModalSrc:'{{ asset('storage/images/' . $image->name) }}' })"
                    class="cursor-pointer">
                    <img src="{{ asset('storage/images/' . $image->name) }}">
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@once
<div x-data="{ imgModal : false, imgModalSrc : '' }">
    <div @img-modal.window="imgModal = true; imgModalSrc = $event.detail.imgModalSrc" x-cloak x-show="imgModal"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform"
        x-transition:enter-end="opacity-100 transform" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transfrom" x-transition:leave-end="opacity-0 transform"
        x-on:click.away="imgModalSrc = ''"
        class="p-2 fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center bg-black bg-opacity-75">
        <div @click.away="imgModal = ''" class="flex flex-col max-w-3xl max-h-full overflow-auto">
            <div class="z-50 text-white">
                <button @click="imgModal = ''" class="float-right pt-2 pr-2 outline-none focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-2">
                <img class="object-contain h-1/2-screen" :alt="imgModalSrc" :src="imgModalSrc">
            </div>
        </div>
    </div>
</div>
@push('css')
<style>
    [x-cloak] {
        display: none !important;
    }
</style>

@endpush
@endonce