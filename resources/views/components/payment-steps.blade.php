@props(['step' => 1])

{{-- 
    Komponen Progress Bar dengan 4 Langkah untuk Alur Pembayaran.
    - Menerima satu prop: $step, untuk menentukan tahap saat ini.
    - Telah diterjemahkan ke Bahasa Inggris.
    - Telah diperbaiki untuk responsif (v2).
--}}

<div class="max-w-5xl mx-auto mb-12">
    {{-- 
        --- PERBAIKAN RESPONSIVE v2 ---
        1. Di HP (default): 'overflow-x-auto' agar bisa di-scroll ke samping.
        2. Di Desktop (md:): 'overflow-visible' untuk mematikan scroll.
    --}}
    <div class="overflow-x-auto pb-4 md:overflow-visible">
        {{-- 
            1. Di HP (default): 'min-w-[500px]' agar tidak "gepeng".
            2. Di Desktop (md:): 'min-w-full' agar melebar penuh.
        --}}
        <div class="flex items-center min-w-[500px] md:min-w-full">
            {{-- Step 1: Summary --}}
            <div class="flex items-center relative {{ $step >= 1 ? 'text-indigo-600' : 'text-gray-500' }}">
                <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 flex items-center justify-center {{ $step >= 1 ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white border-gray-300' }}">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase transition-colors duration-500 {{ $step >= 1 ? 'text-indigo-600' : 'text-gray-500' }}">1. Summary</div>
            </div>
            <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $step > 1 ? 'border-indigo-600' : 'border-gray-300' }}"></div>
            
            {{-- Step 2: Payment --}}
            <div class="flex items-center relative {{ $step >= 2 ? 'text-indigo-600' : 'text-gray-500' }}">
                <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 flex items-center justify-center {{ $step >= 2 ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white border-gray-300' }}">
                   <i class="fas fa-credit-card"></i>
                </div>
                <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase transition-colors duration-500 {{ $step >= 2 ? 'text-indigo-600' : 'text-gray-500' }}">2. Payment</div>
            </div>
            <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $step > 2 ? 'border-indigo-600' : 'border-gray-300' }}"></div>

            {{-- Step 3: Confirmation --}}
            <div class="flex items-center relative {{ $step >= 3 ? 'text-indigo-600' : 'text-gray-500' }}">
                <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 flex items-center justify-center {{ $step >= 3 ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white border-gray-300' }}">
                   <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase transition-colors duration-500 {{ $step >= 3 ? 'text-indigo-600' : 'text-gray-500' }}">3. Confirmation</div>
            </div>
            <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $step > 3 ? 'border-indigo-600' : 'border-gray-300' }}"></div>

            {{-- Step 4: Complete --}}
            <div class="flex items-center relative {{ $step >= 4 ? 'text-indigo-600' : 'text-gray-500' }}">
                <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 flex items-center justify-center {{ $step >= 4 ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white border-gray-300' }}">
                   <i class="fas fa-flag-checkered"></i>
                </div>
                <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase transition-colors duration-500 {{ $step >= 4 ? 'text-indigo-600' : 'text-gray-500' }}">4. Complete</div>
            </div>
        </div>
    </div>
</div>