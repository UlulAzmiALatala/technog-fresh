<x-public>

    <x-slot name="scripts">
        <script src="https://kit.fontawesome.com/c151b27f34.js" crossorigin="anonymous"></script>
    </x-slot>

    <x-slot name="title">
        {{ $service->name }} - TechnoG Solutions
    </x-slot>

    {{-- Global State untuk Alpine.js (Modal Order) --}}
    <div x-data="{ orderModalOpen: false }">
        
        {{-- HERO SECTION --}}
        <x-slot name="hero">
            <section class="relative text-white overflow-hidden min-h-[60vh] flex flex-col justify-end pb-20 pt-48">
                <div class="absolute inset-0">
                    <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://placehold.co/1600x900/CCD3D8/334155?text=TechnoG+Service' }}" 
                         alt="{{ $service->name }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/80 to-slate-900/40 backdrop-blur-sm"></div>
                </div>
                
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff0f_1px,transparent_1px),linear-gradient(to_bottom,#ffffff0f_1px,transparent_1px)] bg-[size:40px_40px] opacity-30"></div>

                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10">
                    <div x-data="{}" x-init="$nextTick(() => { $el.querySelectorAll('.fade-in-item').forEach((item, index) => setTimeout(() => item.classList.add('in-view'), index * 150)) })">
                        
                        <div class="fade-in-item flex flex-wrap items-center gap-3 mb-6">
                            <a href="{{ route('public.services') }}" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-xs font-bold text-white transition-colors">
                                <i class="fa-solid fa-arrow-left"></i> All Services
                            </a>
                            <span class="px-4 py-1.5 rounded-full bg-indigo-500/20 backdrop-blur-md border border-indigo-500/30 text-xs font-black uppercase tracking-widest text-indigo-300">
                                {{ $service->category->name ?? 'Enterprise Category' }}
                            </span>
                            <span class="px-4 py-1.5 rounded-full bg-cyan-500/20 backdrop-blur-md border border-cyan-500/30 text-xs font-black uppercase tracking-widest text-cyan-300">
                                <i class="fa-solid fa-layer-group mr-1"></i> {{ $service->project_type ?? 'Digital Solution' }}
                            </span>
                        </div>

                        <h1 class="fade-in-item text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white mb-6 drop-shadow-lg">
                            {{ $service->name }}
                        </h1>
                        
                        <div class="fade-in-item flex items-center gap-6 text-slate-300 font-medium">
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-clock text-indigo-400"></i>
                                <span>Estimated Time: <strong class="text-white">{{ $service->estimated_duration }} {{ $service->duration_unit }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </x-slot>

        {{-- MAIN CONTENT --}}
        <section class="py-20 bg-[#fafcff] relative">
            <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:24px_24px] opacity-80 pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col lg:flex-row gap-12 xl:gap-16 items-start">
                    
                    {{-- LEFT COLUMN: Details & Description --}}
                    <div class="w-full lg:w-2/3">
                        <div class="bg-white rounded-[3rem] p-8 sm:p-12 shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-slate-100">
                            
                            <h2 class="text-2xl font-black text-slate-900 mb-6 flex items-center gap-3">
                                <span class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                                    <i class="fa-solid fa-align-left"></i>
                                </span>
                                Overview
                            </h2>
                            
                            <div class="prose prose-lg prose-indigo max-w-none text-slate-600 leading-relaxed">
                                @if($service->description)
                                    {!! nl2br(e($service->description)) !!}
                                @else
                                    <p class="text-slate-400 italic">Comprehensive details for this enterprise solution are currently being documented by our lead engineers. However, the service is fully operational and available for order.</p>
                                @endif
                            </div>

                            <hr class="my-12 border-slate-100">

                            <h2 class="text-2xl font-black text-slate-900 mb-8 flex items-center gap-3">
                                <span class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                                    <i class="fa-solid fa-list-check"></i>
                                </span>
                                Key Deliverables
                            </h2>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                @if($service->features)
                                    @foreach(explode("\n", $service->features) as $feature)
                                        @if(trim($feature))
                                            <div class="flex items-start gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-100 hover:border-indigo-100 hover:bg-white hover:shadow-md transition-all group">
                                                <div class="w-10 h-10 shrink-0 rounded-full bg-white shadow-sm flex items-center justify-center text-emerald-500 group-hover:scale-110 group-hover:bg-emerald-50 transition-all">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                                <p class="text-sm font-bold text-slate-700 mt-0.5">{{ trim(str_replace('-', '', $feature)) }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-span-full p-6 bg-slate-50 rounded-2xl border border-slate-100 text-slate-500 text-sm font-medium">
                                        <i class="fa-solid fa-circle-info mr-2"></i> Deliverables will be custom-tailored during the consultation phase.
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                    {{-- RIGHT COLUMN: Sticky Pricing & Action Card --}}
                    <div class="w-full lg:w-1/3 sticky top-32">
                        <div class="bg-gradient-to-b from-slate-900 to-indigo-950 rounded-[3rem] p-1 shadow-[0_20px_50px_rgba(79,70,229,0.2)] relative overflow-hidden group">
                            
                            {{-- Holographic overlay --}}
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.1),transparent_50%)] z-0"></div>
                            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/30 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
                            
                            <div class="bg-slate-900/80 backdrop-blur-2xl rounded-[2.8rem] p-8 sm:p-10 relative z-10 border border-white/10 h-full flex flex-col">
                                
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-300 mb-4">Investment Scale</p>
                                
                                <div class="flex items-baseline gap-2 mb-8">
                                    <span class="text-3xl font-black text-white/50">$</span>
                                    <span class="text-5xl font-black text-white tracking-tighter">{{ number_format($service->price ?? 0, 0, '.', ',') }}</span>
                                </div>

                                <div class="space-y-4 mb-10">
                                    <div class="flex items-center gap-3 text-slate-300 text-sm font-medium bg-white/5 p-3 rounded-xl border border-white/5">
                                        <i class="fa-solid fa-shield-halved text-emerald-400"></i> Enterprise-grade security
                                    </div>
                                    <div class="flex items-center gap-3 text-slate-300 text-sm font-medium bg-white/5 p-3 rounded-xl border border-white/5">
                                        <i class="fa-solid fa-headset text-cyan-400"></i> Priority technical support
                                    </div>
                                </div>

                                <button type="button" 
                                        @click="orderModalOpen = true"
                                        class="w-full py-5 px-6 text-center font-black text-sm uppercase tracking-widest rounded-2xl text-white shadow-[0_10px_20px_rgba(79,70,229,0.3)] hover:shadow-[0_15px_30px_rgba(79,70,229,0.5)] transform hover:-translate-y-1 transition-all duration-300 flex justify-center items-center gap-3 border border-indigo-400/50 bg-[linear-gradient(110deg,#4f46e5,45%,#818cf8,55%,#4f46e5)] bg-[length:200%_100%] hover:animate-[gradient-x_2s_linear_infinite]">
                                    Request Order <i class="fa-solid fa-bolt"></i>
                                </button>
                                
                                <p class="text-center text-xs text-slate-400 font-medium mt-6">
                                    No immediate payment required. <br>Our team will contact you for a technical review.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ======================================================== --}}
        {{-- SMART ORDER POP-UP MODAL (Dari Layar Detail) --}}
        {{-- ======================================================== --}}
        <div x-show="orderModalOpen" style="display: none;" class="fixed inset-0 z-[150] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <div x-show="orderModalOpen" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-slate-900/70 backdrop-blur-md transition-opacity" @click="orderModalOpen = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div x-show="orderModalOpen"
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-[0_30px_80px_rgba(0,0,0,0.3)] transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-100 relative">
                    
                    <button @click="orderModalOpen = false" class="absolute top-4 right-4 w-10 h-10 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white rounded-full flex items-center justify-center transition-colors z-20">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>

                    <div class="bg-gradient-to-br from-indigo-900 to-slate-900 px-6 py-10 text-center relative overflow-hidden border-b border-indigo-500/30">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.1),transparent_50%)]"></div>
                        <h3 class="text-3xl font-black text-white relative z-10" id="modal-title">Initiate Project</h3>
                        <p class="text-indigo-200 text-sm mt-3 font-medium relative z-10">You are requesting the deployment of:</p>
                        <div class="mt-4 py-3 px-6 bg-white/10 backdrop-blur-md rounded-2xl inline-block border border-white/20 shadow-inner relative z-10">
                            <span class="text-cyan-300 font-black tracking-wide text-lg">{{ $service->name }}</span>
                        </div>
                    </div>
                    
                    <div class="px-6 py-8 bg-[#fafcff]">
                        <form action="{{ route('public.services.request-order') }}" method="POST" class="space-y-5">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Full Name</label>
                                <input type="text" name="name" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all bg-white shadow-sm" placeholder="e.g. John Doe">
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Email Address</label>
                                    <input type="email" name="email" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all bg-white shadow-sm" placeholder="john@company.com">
                                </div>
                                <div>
                                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">WhatsApp Number</label>
                                    <input type="text" name="phone" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all bg-white shadow-sm" placeholder="+62 812...">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Project Requirements</label>
                                <textarea name="message" rows="4" required class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all bg-white shadow-sm resize-none" placeholder="Briefly describe your current infrastructure or goals..."></textarea>
                            </div>
                            
                            <button type="submit" class="w-full mt-4 py-5 px-6 text-center font-black text-sm uppercase tracking-widest rounded-2xl text-white shadow-[0_10px_30px_rgba(79,70,229,0.3)] hover:shadow-[0_20px_40px_rgba(79,70,229,0.5)] transform hover:-translate-y-1 transition-all duration-300 flex justify-center items-center gap-3 border border-indigo-400/50 bg-[linear-gradient(110deg,#4f46e5,45%,#818cf8,55%,#4f46e5)] bg-[length:200%_100%] hover:animate-[gradient-x_2s_linear_infinite]">
                                Submit Request <i class="fa-solid fa-paper-plane ml-1"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- FLOATING TOAST NOTIFICATION --}}
    @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 6000)"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-10"
             x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-10"
             class="fixed bottom-10 right-4 sm:right-10 z-[200] max-w-md w-full bg-white/90 backdrop-blur-xl border border-white shadow-[0_20px_50px_rgba(0,0,0,0.15)] rounded-[1.5rem] p-5 flex items-start gap-4">
            <div class="flex-shrink-0 mt-0.5">
                <div class="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center border border-emerald-100">
                    <i class="fa-solid fa-check text-xl text-emerald-500 drop-shadow-sm"></i>
                </div>
            </div>
            <div class="flex-1 pt-1">
                <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Request Received</h4>
                <p class="text-sm text-slate-800 font-bold leading-relaxed">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition-colors pt-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
    @endif

    <style>
        .fade-in-item { opacity: 0; transform: translateY(20px); transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .fade-in-item.in-view { opacity: 1; transform: translateY(0); }
        @keyframes gradient-x { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
        .animate-gradient-x { animation: gradient-x 3s ease infinite; }
    </style>
</x-public>