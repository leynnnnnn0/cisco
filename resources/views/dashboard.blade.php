<x-app-layout>
    <div class="flex h-full">
        <x-sidebar/>
        <div class="flex-1 flex flex-col gap-2 p-2">
            <section class="flex flex-col h-1/2 rounded-lg border border-gray-200 gap-2 p-2">
                <div class="border-b border-gray-300">
                    <h1 class="font-light text-lg">Team Performance</h1>
                </div>
                <div class="overflow-y-scroll">
                    <table class="w-full border border-gray-200">
                        <thead class="bg-black/10 p-4">
                        <tr>
                            <x-th>Agent</x-th>
                            <x-th>Status</x-th>
                            <x-th>Time in Status</x-th>
                            <x-th>Extension</x-th>
                            <x-th>Actions</x-th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <x-td>{{ $user->name }}</x-td>
                                <x-td>Unknown</x-td>
                                <x-td>Unknown</x-td>
                                <x-td>Unknown</x-td>
                                <x-td>Unknown</x-td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="h-1/2 rounded-lg gap-2"></section>
        </div>

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
