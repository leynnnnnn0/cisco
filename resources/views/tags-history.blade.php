<x-app-layout>
    <div class="flex h-full">
        <x-sidebar/>
        <div class="flex-1 flex flex-col gap-2 p-2">
            <section class="flex h-1/2 rounded-lg border border-gray-200 gap-2 p-2">
                <div class="flex flex-col gap-3 flex-1 bg-white rounded-lg p-3">
                    <h1 class="text-lg">My Schedule</h1>
                    <strong>Start Time: <span>{{ $schedule->start_time }}</span></strong>
                    <strong>First Break:  <span>{{ $schedule->first_break }}</span></strong>
                    <strong>Lunch: <span>{{ $schedule->lunch }}</span></strong>
                    <strong>Second Break: <span>{{ $schedule->second_break }}</span></strong>
                    <strong>End Of Shift: <span>{{ $schedule->end_time }}</span></strong>
                </div>
                <div x-data="adherence" class="flex-1 bg-white rounded-lg p-3">
                    <h1 class="text-lg">My Adherence</h1>
                    <h1 class="text-green-500 font-bold text-2xl" x-text="adherence.toFixed(2)"></h1>
                </div>
            </section>
            <section class="h-1/2 rounded-lg gap-2">
                <x-tags-history-table :$tags/>
            </section>
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('adherence', () => ({
            adherence: 100,
            tags: [],
            totalScheduledTime: 540,
            timeInAdherence: 0,
            minutes: 0,
            getAdherence(){
              this.adherence = (this.timeInAdherence / this.totalScheduledTime) * 100;
            },
            calculateAdherence(tagTime, schedule){
                const difference = tagTime - schedule;
                this.minutes += Math.abs(Math.floor((difference % 3600000) / 60000));
                this.timeInAdherence = this.totalScheduledTime - this.minutes;
            },
            getNonAdherenceTime(tag, scheduledMinutes){
                const nonAdherenceMinutes = Math.abs(parseInt(tag.duration.split(':')[1]) - scheduledMinutes);
                this.minutes += nonAdherenceMinutes;
            },
            async init() {
                this.tags = await @json($tags);
                let numberOfBreaks = 0;
                let numberOfRun = 0;
                this.tags.map(tag => {
                    const tagTime = new Date(tag.created_at);
                    if(numberOfRun === 0){
                        const start_time = new Date('{{ date('Y-m-d') . ' ' . $schedule->start_time }}')
                        this.calculateAdherence(tagTime, start_time);
                        numberOfRun++;
                        return;
                    }
                    if(tag.status === 'BREAK' && numberOfBreaks === 0 && tag.duration !== 'N/A'){
                        this.getNonAdherenceTime(tag, 15)
                        const first_break = new Date('{{ date('Y-m-d') . ' ' . $schedule->first_break }}')
                        this.calculateAdherence(tagTime, first_break);
                        numberOfBreaks++;
                        return;
                    }
                    if(tag.status === 'LUNCH' && tag.duration !== 'N/A'){
                        this.getNonAdherenceTime(tag, 60)
                        const lunch = new Date('{{ date('Y-m-d') . ' ' . $schedule->lunch }}')
                        this.calculateAdherence(tagTime, lunch);
                        return;
                    }
                    if(tag.status === 'BREAK' && numberOfBreaks === 1 && tag.duration !== 'N/A'){
                        this.getNonAdherenceTime(tag, 15)
                        const second_break = new Date('{{ date('Y-m-d') . ' ' . $schedule->second_break }}')
                        this.calculateAdherence(tagTime, second_break);
                        numberOfBreaks++;
                        return;
                    }
                    if(tag.status === 'END OF SHIFT' && numberOfBreaks === 1){
                        const end_of_shift = new Date('{{ date('Y-m-d') . ' ' . $schedule->end_of_shift }}')
                        this.calculateAdherence(tagTime, end_of_shift);
                    }
                    console.log(this.minutes)
                })
                this.getAdherence();
            }
        }));
    })
</script>














