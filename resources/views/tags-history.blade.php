<x-app-layout>
    <div class="flex h-full">
        <x-sidebar/>
        <div class="flex-1 flex flex-col gap-2 p-2">
            <section class="flex flex-col h-1/2 rounded-lg border border-gray-200 gap-2 p-2">
                <x-tags-history-table :$tags/>
            </section>
            <section class="h-1/2 rounded-lg gap-2">

            </section>
        </div>
    </div>
</x-app-layout>














