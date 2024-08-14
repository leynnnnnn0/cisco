<div class="border-b border-gray-300">
    <h1 class="font-light text-lg">Tags History</h1>
    <input id="dateHistory" type="date" value="{{ date('Y-m-d') }}">
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
            <template x-data="userTagsHistory">
                <tr>
                    <x-td></x-td>
                    <x-td></x-td>
                    <x-td></x-td>
                    <x-td></x-td>
                    <x-td></x-td>
                </tr>
            </template>
        </tbody>
    </table>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('userTagsHistory', () => ({
            history: [],
            init(){
                const datePicker = document.getElementById('dateHistory');
                datePicker.addEventListener('change', (event) => {
                    console.log(event.target.value)
                    fetch('/tags', {
                        method: 'GET',
                    }).then(result => console.log(result.json()))
                        .catch(err => console.log(err));

                })
                Echo.private('history')
                    .listen('HistoryRequest', e => {
                        console.log(e);
                    });
            }
        }))
    })
</script>
