{{-- Lokasi: resources/views/client/payment/manual.blade.php (English Version) --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment Confirmation for Order #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <x-payment-steps :step="2" />

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
                <div class="lg:col-span-3 bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">Payment Instructions</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Please transfer the exact amount of:</p>
                            <p class="font-bold text-3xl text-indigo-600">$ {{ number_format($amountToPay, 2, '.', ',') }}</p>
                        </div>
                        <div class="border-t"></div>
                        <div>
                             <p class="text-sm text-gray-600 mb-2">To the following bank account:</p>
                             <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                 <p class="font-semibold text-gray-800">Bank ABC</p>
                                 <p class="text-lg font-mono text-gray-700 my-1">1234567890</p>
                                 <p class="text-sm text-gray-500">c/o TechnoG Solutions</p>
                             </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Important</h4>
                            <ul class="list-disc list-inside space-y-1 text-xs text-gray-500">
                                <li>Ensure the transfer amount is exact to the last digit.</li>
                                <li>Save your transfer receipt for upload.</li>
                                <li>Payment verification will be done by our team within 1x24 working hours.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-2xl" x-data="{ imagePreview: null }">
                    <form action="{{ route('client.payment.store', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="amount" value="{{ $amountToPay }}">
                        
                        <div class="p-6 border-b border-gray-200">
                             <h3 class="text-lg font-bold text-gray-900">Confirm Your Payment</h3>
                        </div>
                        <div class="p-6">
                            <label for="payment_proof" class="block font-medium text-sm text-gray-700 mb-2">Upload Transfer Receipt</label>
                            
                            <label for="payment_proof" class="mt-1 flex justify-center items-center w-full h-48 px-6 border-2 border-dashed rounded-lg cursor-pointer border-gray-300 hover:border-indigo-500 transition-colors bg-gray-50 hover:bg-indigo-50">
                                <div x-show="!imagePreview" class="text-center">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-gray-400"></i>
                                    <p class="mt-2 text-sm text-gray-600">Click to select a file</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG (max. 2MB)</p>
                                </div>
                                <img x-show="imagePreview" :src="imagePreview" class="max-h-44 rounded object-contain">
                            </label>

                            <input @change="imagePreview = URL.createObjectURL($event.target.files[0])" type="file" name="payment_proof" id="payment_proof" class="hidden" required>
                            <x-input-error :messages="$errors->get('payment_proof')" class="mt-2" />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div class="p-6 bg-gray-50 flex items-center justify-between">
                            @if ($order->payment_type == 'dp' && $order->status == 'Diproses')
                                <a href="{{ route('client.payment.settlement', $order->id) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                                    &larr; Back
                                </a>
                            @else
                                <a href="{{ route('client.payment.choose', $order->id) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                                    &larr; Back
                                </a>
                            @endif
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                                Confirm Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.app-footer')
</x-app-layout>