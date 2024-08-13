@props(['users' => collect()])
<div x-data="userNewStatus" class="border-b border-gray-300">
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
                    <x-td>
                        {{$user->name}}
                    </x-td>
                    <x-td id="{{$user->id}}">
                        {{$user->statuses->first()->status ?? 'NOT READY'}}
                    </x-td>
                    <x-td>
                        Unknown
                    </x-td>
                    <x-td>
                        Unknown
                    </x-td>
                    <x-td>Unknown</x-td>
                </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('userNewStatus', () => ({
            init(){
                Echo.private('status')
                    .listen('StatusChange', e => {
                        document.getElementById(e.id).innerText = e.status;
                    })
            }
        }));
    });
</script>
