<!-- Sidebar-->
<section class="bg-black/90 lg:pl-10 lg:w-[300px] md:w-[200px] w-[100px] lg:py-12 lg:space-y-0 sm:px-auto sm:pt-5 sm:space-y-4">
    <x-sidebar-link
        href="/"
        :active="request()->is('/')"
                    icon="fa-solid fa-house"
    >Home</x-sidebar-link>
    <x-sidebar-link :active="request()->is('/call-history')"
                    icon="fa-solid fa-phone"
    >Call history</x-sidebar-link>
    <x-sidebar-link
        href="/tags-history"
        :active="request()->is('tags-history')"
                    icon="fa-solid fa-chart-simple"
    >Tags History</x-sidebar-link>
</section>
