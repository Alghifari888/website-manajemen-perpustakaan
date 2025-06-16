<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end mb-6">
                        <a href="{{ route('admin.books.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Tambah Buku Baru
                        </a>
                    </div>

                   
                    {{-- ==>BLOK FORM PENCARIAN & FILTER DI SINI <== --}}
                   
                    <form method="GET" action="{{ route('admin.books.index') }}" class="mb-6">
                        <div class="flex flex-col md:flex-row gap-4">
                            {{-- Input Pencarian --}}
                            <div class="flex-grow">
                                <x-input-label for="search" :value="__('Cari Judul / Penulis')" class="sr-only"/>
                                <x-text-input id="search" name="search" type="text" class="block w-full"
                                              placeholder="Cari berdasarkan judul atau penulis..."
                                              :value="request('search')" />
                            </div>
                            
                            {{-- Dropdown Kategori --}}
                            <div>
                                <x-input-label for="category_id" :value="__('Filter Kategori')" class="sr-only"/>
                                <select name="category_id" id="category_id" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex items-center">
                                <x-primary-button type="submit">
                                    Cari
                                </x-primary-button>
                                <a href="{{ route('admin.books.index') }}" class="ms-3 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>





                    @if (session('success'))
                        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Sampul</th>
                                    <th scope="col" class="py-3 px-6">Judul</th>
                                    <th scope="col" class="py-3 px-6">Penulis</th>
                                    <th scope="col" class="py-3 px-6">Kategori</th>
                                    <th scope="col" class="py-3 px-6">Stok</th>
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($books as $book)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="py-4 px-6">
                                            @if($book->cover_image_path)
                                                <img src="{{ asset('storage/' . $book->cover_image_path) }}" alt="{{ $book->title }}" class="h-16 w-auto object-cover">
                                            @else
                                                <span class="text-xs italic">No Image</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $book->title }}</td>
                                        <td class="py-4 px-6">{{ $book->author }}</td>
                                        <td class="py-4 px-6">{{ $book->category->name }}</td>
                                        <td class="py-4 px-6">{{ $book->available_quantity }}/{{ $book->stock_quantity }}</td>
                                        <td class="py-4 px-6">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.books.edit', $book) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="6" class="py-4 px-6 text-center">
                                            Tidak ada data buku ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>