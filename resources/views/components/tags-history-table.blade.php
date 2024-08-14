@props(['tags'])
<div class="border-b border-gray-300">
    <h1 class="font-light text-lg">Tags History</h1>
    <input id="dateHistory" type="date" value="{{ date('Y-m-d') }}">
</div>
<div class="overflow-y-scroll">
    <table class="w-full border border-gray-200">
        <thead class="bg-black/10 p-4">
        <tr>
            <x-th>Status</x-th>
            <x-th>Tag Time</x-th>
        </tr>
        </thead>
        <tbody>
            <template x-data="userTagsHistory" x-for="date in history" x-key="date.id">
                <tr>
                    <x-td>
                        <span x-text="date.status"></span>
                    </x-td>
                    <x-td>
                        <span x-text="new Date(date.created_at).toLocaleString()"></span>
                    </x-td>
                </tr>
            </template>
        </tbody>
    </table>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('userTagsHistory', () => ({
            history: @json($tags),
            init(){
                const datePicker = document.getElementById('dateHistory');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                datePicker.addEventListener('change', (event) => {
                    fetch('/tags', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            date: event.target.value
                        })
                    }).then(async (result) =>  {
                        const data = await result.json();
                        this.history = data.data;
                    })
                        .catch(err => console.log(err));
                })
            }
        }))
    })
</script>
