<x-app-layout>
    <div x-data="employeesTagTable" class="flex h-full">
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
                        <option value="all" selected>All</option>
                        @foreach($names as $id => $name)
                            <option value="{{$id}}">{{ $name }}</option>
                        @endforeach
                    </select>
                </section>
                <section class="flex flex-col gap-2">
                    <strong>Filter by Date</strong>
                    <div class="flex gap-2">
                        <div class="flex items-center gap-2">
                            <strong>From</strong>
                            <input id="filterFrom" type="date">
                        </div>
                        <div class="flex items-center gap-2">
                            <strong>To</strong>
                            <input id="filterTo" type="date">
                        </div>
                        <button x-bind:disabled="isDisabled" @click="search" class="ml-5 px-6 bg-gray-300 py-1 rounded-lg border border-gray-300 font-bold hover:bg-gray-50 transition-duration duration-300">Search</button>
                    </div>
                </section>
            </div>
            <div class="overflow-y-scroll">
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
                    <template x-for="status in data.data">
                        <tr>
                            <x-td x-text="status.user.name"></x-td>
                            <x-td x-text="status.status"></x-td>
                            <x-td x-text="new Date(status.created_at).toLocaleString()"></x-td>
                            <x-td></x-td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
            {{ $status->links() }}
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('employeesTagTable', () => ({
            data: @json($status),
            isDisabled: false,
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            filterName: document.getElementById('employeeName'),
            filterFrom: document.getElementById('filterFrom'),
            filterTo: document.getElementById('filterTo'),
            search(){
                if(this.filterName){
                    fetch('/request-user-tags', {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": this.csrfToken
                        },
                        body: JSON.stringify({
                            id: this.filterName.value,
                            from: this.filterFrom.value,
                            to: this.filterTo.value
                        })
                    }).then(async result => {
                        const data = await result.json();
                        this.data = data.status;
                        console.log(data)
                    }).catch(err => console.log(err));
                }
            },
            init(){
            }
        }));
    })
</script>














