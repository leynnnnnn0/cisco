@props(['users'])
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
        <tbody x-data="usersStatus" >
            <template x-for="user in users" x-key="user.id">
                <tr>
                    <x-td>
                        <span x-text="user.name"></span>
                    </x-td>
                    <x-td x-bind:class="user.statuses.length > 0 ? tagColor(user.statuses[0].status) : tagColor('NOT READY')">
                        <span x-text="user.statuses.length > 0 ? user.statuses[0].status : 'NOT READY'"></span>
                    </x-td>
                    <x-td>
                        <span x-text="user.statuses.length > 0 ? getTimeInStatus(user.statuses[0].created_at) : getTimeInStatus(new Date().toISOString())"></span>
                    </x-td>
                    <x-td></x-td>
                    <x-td></x-td>
                </tr>
            </template>


        </tbody>
    </table>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('usersStatus', () => ({
            users: [],
            timeInStatus: '',
            tagColor(status) {
                switch(status){
                    case 'READY':
                        return 'bg-green-500 text-white';
                    case 'MEETING':
                        return 'bg-blue-500 text-white';
                    case 'BREAK' || 'LUNCH':
                        return 'bg-yellow-500 text-white';
                    default:
                        return 'bg-red-500 text-white'
                }
            },
            getTimeInStatus(time) {
                this.getTimeDifference(time)
                setInterval(() => {
                    this.getTimeDifference(time)
                }, 1000);
                return this.timeInStatus

            },
            getTimeDifference(time){
                const timestamp1 = time;
                const timestamp2 = new Date().toISOString();

                const date1 = new Date(timestamp1);
                const date2 = new Date(timestamp2);

                const differenceInMilliseconds = date2 - date1;

                const differenceInSeconds = differenceInMilliseconds / 1000;

                const hours = Math.floor(differenceInSeconds / 3600);
                const minutes = Math.floor((differenceInSeconds % 3600) / 60);
                const seconds = Math.floor(differenceInSeconds % 60);

                this.timeInStatus = [
                    hours.toString().padStart(2, '0'),
                    minutes.toString().padStart(2, '0'),
                    seconds.toString().padStart(2, '0')
                ].join(':');
            },
            init(){
                this.users = @json($users);
                console.log(this.users)
                Echo.private('status')
                    .listen('StatusChange', e => {
                        this.users = this.users.map(user => {
                            if(user.id === e.id){
                                if(user.statuses.length > 0){
                                    user.statuses[0].created_at = e.start_time;
                                    user.statuses[0].status = e.status;
                                }else {
                                    user.statuses[0] = {
                                        created_at: e.start_time,
                                        status: e.status
                                    }
                                }
                            }
                            return user;
                        })
                        console.log(this.users)
                    })
            }
        }));
    });
</script>
