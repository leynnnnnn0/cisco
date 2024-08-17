<x-app-layout>
    <div class="flex h-full">
        <x-sidebar/>
        <div class="flex-1 flex flex-col gap-2 p-2">
            <div class="flex justify-between">
                <h1 class="font-light text-lg">Tags History</h1>
                <button class="bg-green-500 text-white font-bold rounded-lg px-3 py-1 hover:bg-opacity-50 transition-duration duration-300">Export Excel</button>
            </div>
            <div class="flex gap-3">
                <section class="flex flex-col gap-2">
                    <strong>Filter by Name</strong>
                    <select name="employeeName" id="employeeName">
                        @foreach($names as $id => $name)
                            <option value="">{{ $name }}</option>
                        @endforeach
                    </select>
                </section>
                <section class="flex flex-col gap-2">
                    <strong>Filter by Date</strong>
                    <div class="flex gap-2">
                        <div class="flex items-center gap-2">
                            <strong>From</strong>
                            <input type="date">
                        </div>
                        <div class="flex items-center gap-2">
                            <strong>To</strong>
                            <input type="date">
                        </div>
                    </div>
                </section>
            </div>
            <table class="w-full border border-gray-200">
                <thead class="bg-black/10 p-4">
                <tr>
                    <x-th>Employee Name</x-th>
                    <x-th>Status</x-th>
                    <x-th>Tag Time</x-th>
                    <x-th>Duration</x-th>
                </tr>
                </thead>
                <tbody>
                    @foreach($status as $tag)
                        <tr>
                            <x-td>{{ $tag->user->name }}</x-td>
                            <x-td>{{ $tag->status }}</x-td>
                            <x-td>{{ $tag->created_at }}</x-td>
                            <x-td>{{ $tag->duration }}</x-td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $status->links() }}
        </div>
    </div>
</x-app-layout>














