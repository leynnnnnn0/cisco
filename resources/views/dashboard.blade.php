<x-app-layout>
    <div class="flex h-full">
        <!-- Sidebar-->
        <section class="bg-black/90 lg:pl-10 lg:w-[300px] md:w-[200px] w-[100px] lg:py-12 lg:space-y-0 sm:px-auto sm:pt-5 sm:space-y-4">
            <x-sidebar-link :active="request()->is('/')"
                            icon="fa-solid fa-house"
            >Home</x-sidebar-link>
            <x-sidebar-link :active="request()->is('/call-history')"
                            icon="fa-solid fa-phone"
            >Call history</x-sidebar-link>
            <x-sidebar-link :active="request()->is('/my-statistics')"
                            icon="fa-solid fa-chart-simple"
            >My statistics</x-sidebar-link>
        </section>
    </div>
</x-app-layout>












{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
{{--            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                <div class="p-6 text-gray-900">--}}
{{--                    {{ __("You're logged in!") }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
