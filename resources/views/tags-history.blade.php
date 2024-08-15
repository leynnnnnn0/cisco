<x-app-layout>
    <div class="flex h-full">
        <x-sidebar/>
        <div class="flex-1 flex flex-col gap-2 p-2">
            <section class="flex h-1/2 rounded-lg border border-gray-200 gap-2 p-2">
                <div class="flex-1 bg-white rounded-lg p-3">
                    <h1 class="text-lg">My Schedule</h1>

                </div>
                <div class="flex-1 bg-white rounded-lg p-3">
                    <h1 class="text-lg">My Adherence</h1>

                </div>
            </section>
            <section class="h-1/2 rounded-lg gap-2">
                <x-tags-history-table :$tags/>
            </section>
        </div>
    </div>
</x-app-layout>














