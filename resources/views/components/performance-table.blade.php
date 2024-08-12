@props(['users' => collect()])
<div class="border-b border-gray-300">
    <h1 class="font-light text-lg">Team Performance</h1>
</div>
<div x-data="userStatus" class="overflow-y-scroll">
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
            <template x-for="user in activeUsers" x-key="user.id">
                <tr>
                    <x-td>
                        <span x-text="user.name"></span>
                    </x-td>
                    <x-td x-bind:class="user.status === 'Ready' ? 'bg-green-500 text-white' :
                    'bg-red-500 text-white'">
                        <span x-text="user.status"></span>
                    </x-td>
                    <x-td>
                        <span x-data="activeUsers" x-text="timeInStatus(user.start_time)"></span>
                    </x-td>
                    <x-td>
                        <span x-text="user.start_time"></span>
                    </x-td>
                    <x-td>Unknown</x-td>
                </tr>
            </template>
        </tbody>
    </table>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('activeUsers', () => ({
            time: '0 seconds',
            getTimeInStatus(startTime) {
                const timeDifference = Date.now() - parseInt(startTime);
                const seconds = Math.floor(timeDifference / 1000);
                const minutes = Math.floor(seconds / 60);
                const hours = Math.floor(minutes / 60);
                this.time = `${hours} hours, ${minutes % 60} minutes, ${seconds % 60} seconds`;
            },
            timeInStatus(startTime){
                this.getTimeInStatus(startTime)
                setInterval(() => {this.getTimeInStatus(startTime)}, 1000)
                return this.time;
            }
        }))
    });
</script>
