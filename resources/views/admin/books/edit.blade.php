<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Buku: ') . $book->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="title" :value="__('Judul')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $book->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <x-input-label for="author" :value="__('Penulis')" />
                                <x-text-input id="author" class="block mt-1 w-full" type="text" name="author" :value="old('author', $book->author)" required />
                                <x-input-error :messages="$errors->get('author')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="publisher" :value="__('Penerbit')" />
                                <x-text-input id="publisher" class="block mt-1 w-full" type="text" name="publisher" :value="old('publisher', $book->publisher)" required />
                                <x-input-error :messages="$errors->get('publisher')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <x-input-label for="publication_year" :value="__('Tahun Terbit')" />
                                <x-text-input id="publication_year" class="block mt-1 w-full" type="number" name="publication_year" :value="old('publication_year', $book->publication_year)" required />
                                <x-input-error :messages="$errors->get('publication_year')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="isbn" :value="__('ISBN')" />
                                <x-text-input id="isbn" class="block mt-1 w-full" type="text" name="isbn" :value="old('isbn', $book->isbn)" required />
                                <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="stock_quantity" :value="__('Jumlah Stok')" />
                            <x-text-input id="stock_quantity" class="block mt-1 w-full" type="number" name="stock_quantity" :value="old('stock_quantity', $book->stock_quantity)" required />
                            <x-input-error :messages="$errors->get('stock_quantity')" class="mt-2" />
                        </div>
                        
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $book->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="cover_image" :value="__('Ganti Sampul Buku (Opsional)')" />
                            @if ($book->cover_image_path)
                                <img src="{{ asset('storage/' . $book->cover_image_path) }}" alt="Current Cover" class="h-24 w-auto object-cover mt-2 mb-2 rounded">
                            @endif
                            <input id="cover_image" name="cover_image" type="file" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.books.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                Batal
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>