@props(['ready' => false, 'status' => false])
<a {{ $attributes->merge(['class' => 'cursor-pointer block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out']) }}>
    @if($status)
        <i class="fa-solid fa-circle mr-2 {{ $ready ? 'text-green-500' : 'text-red-500' }}"></i>
    @endif
    {{ $slot }}</a>
