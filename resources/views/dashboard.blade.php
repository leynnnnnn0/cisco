<x-app-layout>
    <div x-data="userStatus" class="flex h-full">
        <x-sidebar/>
        <div class="flex-1 flex flex-col gap-2 p-2">
            <section class="flex flex-col h-1/2 rounded-lg border border-gray-200 gap-2 p-2">
               @if(Auth::user()->is_admin)
                    <x-performance-table :$users/>
                @endif
            </section>
            <section class="h-1/2 rounded-lg gap-2"></section>
        </div>

    </div>
</x-app-layout>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('userStatus', () => ({
            activeUsers: [],
            init(){
                Echo.private('status')
                    .listen('StatusChange', e => {
                        let item = this.activeUsers.find(obj => obj.id === e.id);
                        item.status = e.status;
                        item.start_time = e.start_time;
                    })

                Echo.join('room')
                    .here(users => {
                        this.activeUsers = users
                    })
            }
        }));
    });
</script>













{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
{{--            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                <div class="p-6 text-gray-900">--}}
{{--                    {{ __("You're logged in!") }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
