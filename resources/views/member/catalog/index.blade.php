<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Katalog Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('member.catalog.index') }}">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-grow">
                                <x-text-input id="search" name="search" type="text" class="block w-full"
                                              placeholder="Cari buku berdasarkan judul atau penulis..."
                                              :value="request('search')" />
                            </div>
                            <div>
                                <select name="category_id" id="category_id" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center">
                                <x-primary-button type="submit">Cari</x-primary-button>
                                <a href="{{ route('member.catalog.index') }}" class="ms-3 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($books as $book)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                        <img src="{{ $book->cover_image_path ? asset('storage/' . $book->cover_image_path) : 'https://ui-avatars.com/api/?name='.urlencode($book->title).'&background=random&size=256' }}" alt="Cover Buku {{ $book->title }}" class="w-full h-64 object-cover">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex-grow flex flex-col">
                            <h3 class="font-semibold text-lg">{{ Str::limit($book->title, 40) }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $book->author }}</p>
                            <div class="mt-auto">
                                <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">{{ $book->category->name }}</span>
                                <div class="mt-4 flex justify-between items-center">
                                    @if ($book->available_quantity > 0)
                                        <span class="text-sm font-bold text-green-600 dark:text-green-400">Tersedia: {{ $book->available_quantity }}</span>
                                    @else
                                        <span class="text-sm font-bold text-red-600 dark:text-red-400">Stok Habis</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4 text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400 text-lg">Tidak ada buku yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $books->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>