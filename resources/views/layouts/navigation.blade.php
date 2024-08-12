<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div x-data="userCurrentStatus" class="w-full px-5">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-3 border-r border-black/5 pr-10">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                    <span class="text-xl">Cisco Finesse</span>
                </div>

                <div
                    class="flex items-center gap-3 p-2 border-x border-black/10 w-72">
                    <!-- Phone Icon -->
                    <div x-bind:class="status === 'Ready' ? 'border-green-600' : 'border-red-600'"
                         class="h-12 w-12 rounded-full border-2 flex items-center">
                        <i class="fa-solid fa-phone text-2xl text-gray-500 p-2"></i>
                    </div>
                    <!-- State -->
                    <div class="flex flex-1 flex-col gap-1">
                        <span class="font-light text-md" x-text="status"></span>
                        <span x-text="time" class="font-light text-xs text-gray-400"></span>
                    </div>
                    <!-- Drop down -->
                    <div>
                        <div @click="show = !show" class="ms-1 cursor-pointer" @click.outside="show = false">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div x-show="show" class="relative">
                            <div class="absolute overflow-hidden right-0 mt-7 rounded-lg bg-white w-72" @click="show = false">
                                <x-dropdown-link  @click="updateStatus('Ready')" :status="true" :ready="true">
                                    Ready
                                </x-dropdown-link>
                                <x-dropdown-link @click="updateStatus('Break')" :status="true">
                                    Break
                                </x-dropdown-link>
                                <x-dropdown-link @click="updateStatus('Lunch')" :status="true">
                                    Lunch
                                </x-dropdown-link>
                                <x-dropdown-link @click="updateStatus('Personal Time')" :status="true">
                                    Personal Time
                                </x-dropdown-link>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

        </div>
    </div>
</nav>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('userCurrentStatus', () => ({
            name: 'nathaniel',
            isReady: true,
            status: 'Not Ready',
            show: false,
            time: '0 seconds',
            startingTime: 0,
            previousStartingTime: 0,
            previousStatus: '',
            init() {
                // When the user open the application it starts with the status of not ready
                if(!localStorage.getItem('previousStatus'))
                {
                    localStorage.setItem('previousStatus', this.status);
                }else {
                    this.status = localStorage.getItem('previousStatus')
                }
                // If the user change the status we want to store it on local storage
                this.previousStartingTime = localStorage.getItem('previousStartingTime');
                this.startingTime = this.previousStartingTime ? parseInt(this.previousStartingTime) : Date.now();
                if (!this.previousStartingTime) {
                    localStorage.setItem('previousStartingTime', this.startingTime);
                }
                this.updateTime();
                setInterval(() => this.updateTime(), 1000);
            },
            updateTime() {
                const timeDifference = Date.now() - this.startingTime;
                const seconds = Math.floor(timeDifference / 1000);
                const minutes = Math.floor(seconds / 60);
                const hours = Math.floor(minutes / 60);
                this.time = `${hours} hours, ${minutes % 60} minutes, ${seconds % 60} seconds`;
            },
            resetTimer() {
                this.startingTime = Date.now();
                localStorage.setItem('previousStartingTime', this.startingTime);
                this.updateTime();
            },
            async updateStatus(status){
                localStorage.setItem('previousStatus', status)
                this.status = status
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                await fetch('/change-status/123', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                       status: this.status
                    })
                }).then(result => console.log(result.json()))
                    .catch(err => console.log(err))
                this.resetTimer()
            }
        }));
    });
</script>

