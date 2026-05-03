{{-- Lokasi: resources/views/admin/pemasukan/meetings/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Meeting Requests</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage & track client meetings</p>
            </div>
            <button onclick="window.location.reload()" 
                    class="px-6 py-3 bg-[#5046e5] hover:bg-[#4338ca] rounded-2xl text-xs text-white uppercase tracking-widest font-bold transition-all shadow-lg shadow-indigo-500/30">
                <i class="fas fa-sync-alt mr-2"></i> Sync Data
            </button>
        </div>
    </x-slot>

    {{-- PEMBUNGKUS UTAMA ALPINE --}}
    <div x-data="meetingManager()" class="space-y-8 py-4 font-normal relative">
        
        {{-- KALENDER SECTION --}}
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2.5rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-48 h-48 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-widest mb-6 relative z-10"><i class="fas fa-calendar-alt text-indigo-500 mr-2"></i> Jadwal Pertemuan</h3>
            
            <div class="relative z-10 bg-white dark:bg-slate-900/50 p-4 rounded-3xl border border-slate-100 dark:border-slate-700/50">
                <div id="calendar" class="text-slate-700 dark:text-slate-300"></div>
            </div>
        </div>

        {{-- CONTROL PANEL (Search & Filters) --}}
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>
            
            <form action="{{ route('admin.pemasukan.meetings.index') }}" method="GET" class="relative z-10 flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama klien atau topik..." 
                           class="w-full pl-11 rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                </div>

                <div class="md:w-48">
                    <select name="type" onchange="this.form.submit()" 
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-600 dark:text-slate-300">
                        <option value="">Semua Tipe</option>
                        <option value="Online (Zoom / GMeet)" @selected(request('type') == 'Online (Zoom / GMeet)')>Online</option>
                        <option value="Offline (Tatap Muka)" @selected(request('type') == 'Offline (Tatap Muka)')>Offline</option>
                    </select>
                </div>

                <div class="md:w-48">
                    <select name="status" onchange="this.form.submit()" 
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-600 dark:text-slate-300">
                        <option value="">Semua Status</option>
                        <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                        <option value="scheduled" @selected(request('status') == 'scheduled')>Scheduled</option>
                        <option value="completed" @selected(request('status') == 'completed')>Completed</option>
                        <option value="canceled" @selected(request('status') == 'canceled')>Canceled</option>
                    </select>
                </div>

                @if(request()->hasAny(['search', 'type', 'status']) && (request('search') != '' || request('type') != '' || request('status') != ''))
                    <a href="{{ route('admin.pemasukan.meetings.index') }}" 
                       class="px-6 py-3 bg-slate-100 dark:bg-slate-700/50 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-500 dark:text-slate-300 rounded-2xl font-bold flex items-center justify-center transition-all" title="Clear Filters">
                        <i class="fas fa-undo"></i>
                    </a>
                @endif
            </form>
        </div>

        {{-- TABLE SECTION --}}
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-slate-700/50 overflow-hidden shadow-xl shadow-slate-200/20 dark:shadow-none">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-slate-400 uppercase tracking-widest text-[10px] border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                            <th class="p-6 font-bold">Jadwal</th>
                            <th class="p-6 font-bold">Klien & Kontak</th>
                            <th class="p-6 font-bold text-center">Tipe Meeting</th>
                            <th class="p-6 font-bold text-center">Status</th>
                            <th class="p-6 text-center font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                        @forelse ($meetings as $meeting)
                            @php
                                $startStr = \Carbon\Carbon::parse($meeting->meeting_date . ' ' . $meeting->meeting_time);
                                $endStr = $startStr->copy()->addHour(); 
                                $gcalStart = $startStr->format('Ymd\THis');
                                $gcalEnd = $endStr->format('Ymd\THis');
                                $gcalTitle = urlencode("Meeting: " . $meeting->name . " - TechnoG");
                                $gcalDetails = urlencode("Topik: " . $meeting->topic . "\nKontak: " . $meeting->contact);
                                $gcalLink = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$gcalTitle}&dates={$gcalStart}/{$gcalEnd}&details={$gcalDetails}";
                            @endphp
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-300 group">
                            <td class="p-6">
                                <div class="text-indigo-600 dark:text-indigo-400 font-bold text-sm">{{ \Carbon\Carbon::parse($meeting->meeting_date)->format('d M Y') }}</div>
                                <div class="text-slate-500 dark:text-slate-400 text-xs font-medium mt-1"><i class="far fa-clock mr-1"></i> {{ $meeting->meeting_time }} WIB</div>
                            </td>
                            <td class="p-6">
                                <div class="text-slate-900 dark:text-white font-bold text-sm">{{ $meeting->name }}</div>
                                <div class="text-slate-500 dark:text-slate-400 text-xs mt-1"><i class="fas fa-address-card mr-1 opacity-50"></i> {{ $meeting->contact }}</div>
                            </td>
                            
                            <td class="p-6 text-center">
                                @if(str_contains(strtolower($meeting->meeting_type), 'online'))
                                    <span class="px-3 py-1.5 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-blue-200/50 dark:border-blue-800/50 flex items-center justify-center w-max mx-auto">
                                        <i class="fas fa-video mr-1.5"></i> Online
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-200/50 dark:border-emerald-800/50 flex items-center justify-center w-max mx-auto">
                                        <i class="fas fa-coffee mr-1.5"></i> Offline
                                    </span>
                                @endif
                            </td>

                            <td class="p-6 text-center">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-200/50 dark:border-amber-800/50',
                                        'scheduled' => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-200/50 dark:border-emerald-800/50',
                                        'completed' => 'bg-slate-100 dark:bg-slate-500/10 text-slate-600 dark:text-slate-400 border-slate-200/50 dark:border-slate-700/50',
                                        'canceled' => 'bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-200/50 dark:border-rose-800/50',
                                    ];
                                    $colorClass = $statusColors[$meeting->status] ?? $statusColors['pending'];
                                @endphp
                                <span class="px-3 py-1.5 {{ $colorClass }} rounded-xl text-[10px] font-black uppercase tracking-widest border flex items-center justify-center w-max mx-auto">
                                    {{ $meeting->status }}
                                </span>
                            </td>

                            <td class="p-6 text-center">
                                <div class="flex justify-center space-x-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ $gcalLink }}" target="_blank" title="Add to Google Calendar"
                                       class="h-10 w-10 flex items-center justify-center bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 hover:border-blue-200 rounded-xl transition-all shadow-sm">
                                        <i class="fa-brands fa-google text-xs"></i>
                                    </a>
                                    
                                    <button @click="openEditModal(@js($meeting))" title="Update Status"
                                            class="h-10 px-3 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-indigo-100 hover:text-indigo-600 rounded-xl transition-colors shadow-sm font-bold text-xs uppercase tracking-wider">
                                        <i class="fas fa-edit mr-2 text-xs"></i> Update
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-24 text-center">
                                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 dark:border-slate-700">
                                    <i class="fas fa-calendar-times text-3xl text-slate-300 dark:text-slate-600"></i>
                                </div>
                                <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs">Belum ada permintaan meeting.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- AREA MODAL (SUDAH DIPISAH TEMPLATE-NYA)    --}}
        {{-- ========================================== --}}

        {{-- MODAL 1: UPDATE STATUS --}}
        <template x-teleport="body">
            <div x-show="isEditModalOpen" x-cloak class="fixed top-0 left-0 w-screen h-screen z-[9990] flex items-center justify-center p-4">
                
                {{-- Layer Backdrop Full Blur --}}
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[30px]"
                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
                     @click="isEditModalOpen = false"></div>

                {{-- Konten Modal --}}
                <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] shadow-2xl border border-white/10 z-10"
                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-8">
                    
                    <div class="p-8 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-transparent">
                        <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Update Status</h3>
                        <button @click="isEditModalOpen = false" class="text-slate-400 hover:text-rose-500 transition-colors">
                            <i class="fas fa-times fa-lg"></i>
                        </button>
                    </div>

                    <form :action="`{{ url('admin/pemasukan/meetings') }}/${editData.id}/status`" method="POST" class="p-8 space-y-6">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Klien</label>
                            <div class="text-sm font-bold text-slate-900 dark:text-white bg-slate-50 dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-700" x-text="editData.name"></div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2">Ubah Status Meeting</label>
                            <select name="status" x-model="editData.status" required
                                    class="w-full rounded-2xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-700 dark:text-slate-300 p-4">
                                <option value="pending">Pending</option>
                                <option value="scheduled">Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>

                        <div class="flex space-x-4 pt-4 border-t border-slate-100 dark:border-slate-700 mt-4">
                            <button type="button" @click="isEditModalOpen = false" 
                                    class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-2xl font-bold transition-colors">Batal</button>
                            <button type="submit" 
                                    class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl shadow-lg shadow-indigo-900/20 font-bold transition-colors">Simpan Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        {{-- MODAL 2: DETAIL EVENT KALENDER --}}
        <template x-teleport="body">
            <div x-show="isDetailModalOpen" x-cloak class="fixed top-0 left-0 w-screen h-screen z-[9990] flex items-center justify-center p-4">
                
                {{-- Layer Backdrop Full Blur --}}
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[30px]"
                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
                     @click="isDetailModalOpen = false"></div>

                {{-- Konten Modal --}}
                <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-white/10 z-10"
                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-8">
                    
                    <div class="p-8 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-transparent">
                        <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Detail Meeting</h3>
                        <button @click="isDetailModalOpen = false" class="text-slate-400 hover:text-rose-500 transition-colors">
                            <i class="fas fa-times fa-lg"></i>
                        </button>
                    </div>

                    <div class="p-8 space-y-6">
                        {{-- Klien Info --}}
                        <div class="bg-indigo-50 dark:bg-indigo-500/10 p-5 rounded-2xl border border-indigo-100 dark:border-indigo-500/20">
                            <label class="block text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-1">Nama Klien / Perusahaan</label>
                            <div class="text-lg font-black text-indigo-700 dark:text-indigo-300" x-text="detailData.title"></div>
                        </div>

                        {{-- Grid Detail --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-2xl border border-slate-100 dark:border-slate-700">
                                <i class="far fa-calendar-alt text-slate-400 mb-2 text-xl"></i>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Jadwal</label>
                                <div class="text-sm font-bold text-slate-700 dark:text-slate-300" x-text="detailData.start"></div>
                            </div>
                            
                            <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-2xl border border-slate-100 dark:border-slate-700">
                                <i class="fas fa-phone-alt text-slate-400 mb-2 text-xl"></i>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kontak</label>
                                <div class="text-sm font-bold text-slate-700 dark:text-slate-300 truncate" x-text="detailData.contact"></div>
                            </div>
                        </div>

                        {{-- Topik --}}
                        <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-2xl border border-slate-100 dark:border-slate-700">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Topik Diskusi</label>
                            <div class="text-sm text-slate-600 dark:text-slate-400 italic" x-text="`&quot;${detailData.topic}&quot;`"></div>
                        </div>

                        {{-- Status Badge --}}
                        <div class="flex items-center justify-between p-4 border border-slate-200 dark:border-slate-700 rounded-2xl">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Status Saat Ini:</span>
                            <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest border"
                                  :class="{
                                      'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-200/50': detailData.status === 'pending',
                                      'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-200/50': detailData.status === 'scheduled',
                                      'bg-slate-100 dark:bg-slate-500/10 text-slate-600 dark:text-slate-400 border-slate-200/50': detailData.status === 'completed',
                                      'bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-200/50': detailData.status === 'canceled'
                                  }" x-text="detailData.status">
                            </span>
                        </div>

                        <button type="button" @click="isDetailModalOpen = false" 
                                class="w-full py-4 mt-2 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-2xl font-bold transition-colors">Tutup</button>
                    </div>
                </div>
            </div>
        </template>

    </div> {{-- Penutup elemen div x-data="meetingManager()" --}}

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('meetingManager', () => ({
                isEditModalOpen: false,
                editData: { id: null, name: '', status: 'pending' },
                
                isDetailModalOpen: false,
                detailData: { title: '', start: '', contact: '', topic: '', status: '' },
                
                openEditModal(meeting) { 
                    this.editData = { ...meeting }; 
                    this.isEditModalOpen = true; 
                },

                openDetailModal(event) {
                    let dateObj = event.start;
                    let formattedDate = dateObj ? dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';
                    let formattedTime = dateObj ? dateObj.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) : '-';

                    this.detailData = {
                        title: event.title,
                        start: formattedDate + ' - ' + formattedTime + ' WIB',
                        contact: event.extendedProps.contact || '-',
                        topic: event.extendedProps.topic || 'Tidak ada topik spesifik yang ditulis.',
                        status: event.extendedProps.status || 'pending'
                    };
                    this.isDetailModalOpen = true;
                },

                init() {
                    this.$watch('isEditModalOpen', value => document.body.style.overflow = value ? 'hidden' : '');
                    this.$watch('isDetailModalOpen', value => document.body.style.overflow = value ? 'hidden' : '');

                    let calendarEl = document.getElementById('calendar');
                    if (calendarEl) {
                        let eventsData = @json($events ?? []);
                        let calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            themeSystem: 'standard',
                            height: 650, 
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            events: eventsData,
                            
                            eventContent: function(arg) {
                                let status = arg.event.extendedProps.status;
                                let bgColor = 'bg-slate-100 dark:bg-slate-700';
                                let textColor = 'text-slate-700 dark:text-slate-200';
                                let dotColor = 'bg-slate-400';
                                
                                if(status === 'pending') { 
                                    bgColor = 'bg-amber-50 dark:bg-amber-900/40 border-amber-200/50'; 
                                    textColor = 'text-amber-700 dark:text-amber-400';
                                    dotColor = 'bg-amber-500'; 
                                }
                                if(status === 'scheduled') { 
                                    bgColor = 'bg-emerald-50 dark:bg-emerald-900/40 border-emerald-200/50'; 
                                    textColor = 'text-emerald-700 dark:text-emerald-400';
                                    dotColor = 'bg-emerald-500'; 
                                }
                                if(status === 'canceled') { 
                                    bgColor = 'bg-rose-50 dark:bg-rose-900/40 border-rose-200/50'; 
                                    textColor = 'text-rose-700 dark:text-rose-400';
                                    dotColor = 'bg-rose-500'; 
                                }
                                
                                return {
                                    html: `<div class="flex items-center gap-1.5 p-1 w-full rounded ${bgColor} border border-slate-200/50 dark:border-slate-700/50 pointer-events-none">
                                               <div class="w-1.5 h-1.5 rounded-full ${dotColor} shrink-0"></div>
                                               <div class="text-[10px] font-bold ${textColor} truncate tracking-wide">${arg.timeText} ${arg.event.title}</div>
                                           </div>`
                                };
                            },
                            
                            eventClick: (info) => {
                                this.openDetailModal(info.event);
                            }
                        });
                        calendar.render();
                    }
                }
            }));
        });
    </script>
    @endpush
    
    <style>
        .fc-theme-standard .fc-scrollgrid { border-color: rgba(255,255,255,0.1); }
        .fc-theme-standard th { border-color: rgba(255,255,255,0.1) !important; padding: 15px 0; }
        .fc-theme-standard td { border-color: rgba(255,255,255,0.1) !important; }
        .fc-button-primary { background-color: #4f46e5 !important; border-color: #4f46e5 !important; border-radius: 1rem !important; text-transform: uppercase; font-size: 0.75rem !important; font-weight: bold !important; letter-spacing: 0.05em; padding: 0.5rem 1rem !important; transition: all 0.3s; }
        .fc-button-primary:hover { background-color: #4338ca !important; box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4); }
        .fc-button-active { background-color: #3730a3 !important; }
        .fc-toolbar-title { font-weight: 900 !important; font-size: 1.5rem !important; text-transform: uppercase; letter-spacing: 0.05em; }
        
        /* Reset agresif event kalender */
        .fc-event, .fc-daygrid-event, .fc-h-event, .fc-timegrid-event { 
            background: transparent !important; 
            border: none !important; 
            box-shadow: none !important; 
            cursor: pointer !important;
            margin-bottom: 2px !important;
        }
        .fc-event-main { padding: 0 !important; color: inherit !important; }
        .fc-event:hover { transform: scale(1.02); transition: transform 0.2s ease; }
        
        .dark .fc-daygrid-day-number { color: #cbd5e1; font-weight: bold; }
        .dark .fc-col-header-cell-cushion { color: #f8fafc; }
    </style>
</x-admin-layout>