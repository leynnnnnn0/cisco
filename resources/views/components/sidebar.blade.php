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
    @if(Auth::user()->is_admin === 1)
        <x-sidebar-link :active="request()->is('employees-tag')"
                        href="/employees-tag"
                        icon="fa-solid fa-tag"
        >Employees Tag</x-sidebar-link>
        <x-sidebar-link :active="request()->is('payroll')"
                        href="/payroll"
                        icon="fa-solid fa-money-bill"
        >Payroll</x-sidebar-link>
    @endif
</section>
