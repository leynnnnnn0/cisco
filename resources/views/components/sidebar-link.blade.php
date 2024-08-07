@props(['active' => false, 'icon'])
<div class="lg:hover:bg-blue-300  rounded-tl-lg rounded-bl-lg transition-colors duration-300 h-16 cursor-pointer w-full flex items-center lg:justify-start justify-center flex-row gap-3  lg:flex-row sm:flex-col {{ $active ? 'lg:bg-blue-500 bg-transparent' : '' }}">
    <i class="{{ $icon }} text-white text-2xl lg:bg-transparent p-2 rounded-full lg:p-2 {{ $active ? 'sm:bg-indigo-900' : '' }}"></i>
    <a {{ $attributes }} class="lg:flex cursor-pointer text-white text-lg font-bold flex sm:hidden">
        {{ $slot }}
    </a>
</div>
