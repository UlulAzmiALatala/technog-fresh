<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Testimonial Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- =================================================================== --}}
            {{-- Blok notifikasi statis di bawah ini sudah dihapus.              --}}
            {{-- =================================================================== --}}

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Review</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Featured</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($testimonials as $testimonial)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $testimonial->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $testimonial->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                @endfor
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm text-gray-700 max-w-md">{{ Str::limit($testimonial->content, 100) }}</p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <form action="{{ route('admin.founder.testimonials.update', $testimonial->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" 
                                                        title="Click to toggle status"
                                                        @class([
                                                            'px-4 py-2 text-xs font-semibold rounded-full transition-colors',
                                                            'bg-green-100 text-green-800 hover:bg-green-200' => $testimonial->is_featured,
                                                            'bg-gray-100 text-gray-800 hover:bg-gray-200' => !$testimonial->is_featured,
                                                        ])>
                                                    {{ $testimonial->is_featured ? 'Featured' : 'Feature It' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                            No client testimonials found yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

