<x-app-layout>
    <div class="flex h-full">
        <x-sidebar/>
        <div class="flex-1 flex flex-col gap-2 p-2">
            <h1 class="font-light text-lg">Payroll</h1>
            <table class="w-full border border-gray-200">
                <thead class="bg-black/10 p-4">
                <tr>
                    <x-th>Name</x-th>
                    <x-th>From</x-th>
                    <x-th>To</x-th>
                    <x-th>Total Hours Worked</x-th>
                    <x-th>Net Salary</x-th>
                    <x-th>Status</x-th>
                </tr>
                </thead>
                <tbody>
                    @foreach($summary as $key => $time)
                        <tr>
                            <x-td>{{ $time['username'] }}</x-td>
                            <x-td>August 1, 2024</x-td>
                            <x-td>August 15, 2024</x-td>
                            <x-td>{{ $time['totalHoursWorked'] }}</x-td>
                            <x-td>${{ $time['totalEarnings'] }}</x-td>
                            <x-td>Pending</x-td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-center mt-5">
                <a href="/generate-pdf" class="hover:bg-opacity-75 transition-colors duration-300 bg-blue-500 px-5 py-2 rounded-lg text-white font-bold">Process Payroll</a>
            </div>
        </div>
    </div>
</x-app-layout>














