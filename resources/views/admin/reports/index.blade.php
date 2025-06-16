<x-app-layout>
    <!-- Bagian Header -->
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <!-- Judul Halaman -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Laporan & Statistik Perpustakaan') }}
            </h2>
            
            <!-- Tombol Ekspor PDF -->
            <a href="{{ route('admin.reports.export.pdf') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-red-500 hover:to-red-400 transition-colors duration-200 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                </svg>
                Ekspor ke PDF
            </a>
        </div>
    </x-slot>

    <!-- Konten Utama -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grid Kartu Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Kartu Total Anggota -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Total Anggota</h3>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalMembers }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Kartu Total Judul Buku -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Total Judul Buku</h3>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalBooks }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Kartu Pinjaman Aktif -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Pinjaman Aktif</h3>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $activeBorrowings }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Kartu Denda Belum Dibayar -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Denda Belum Dibayar</h3>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($totalFines, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid Tabel Statistik -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Panel Buku Terpopuler -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-xl transition-all duration-300 hover:shadow-lg">
                    <div class="p-6">
                        <!-- Header Panel -->
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-semibold text-xl text-gray-900 dark:text-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                </svg>
                                Top 5 Buku Terpopuler
                            </h3>
                            <span class="text-xs px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                                {{ now()->format('d M Y') }}
                            </span>
                        </div>
                        
                        <!-- Tabel Buku Terpopuler -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th class="py-3 px-4 rounded-tl-lg">No</th>
                                        <th class="py-3 px-4">Judul Buku</th>
                                        <th class="py-3 px-4 rounded-tr-lg">Total Pinjam</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse ($popularBooks as $index => $book)
                                    <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors">
                                        <td class="py-4 px-4 font-medium text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-gray-200 dark:bg-gray-600 rounded-md flex items-center justify-center mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900 dark:text-white">{{ $book->title }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $book->author }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full text-xs font-medium">
                                                {{ $book->borrowings_count }} kali
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-6 text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="mt-2">Tidak ada data buku</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Panel Anggota Teraktif -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-xl transition-all duration-300 hover:shadow-lg">
                    <div class="p-6">
                        <!-- Header Panel -->
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-semibold text-xl text-gray-900 dark:text-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Top 5 Anggota Teraktif
                            </h3>
                            <span class="text-xs px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full">
                                {{ now()->format('d M Y') }}
                            </span>
                        </div>
                        
                        <!-- Tabel Anggota Teraktif -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th class="py-3 px-4 rounded-tl-lg">No</th>
                                        <th class="py-3 px-4">Nama Anggota</th>
                                        <th class="py-3 px-4 rounded-tr-lg">Total Pinjam</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse ($activeMembers as $index => $member)
                                    <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors">
                                        <td class="py-4 px-4 font-medium text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center mr-3 overflow-hidden">
                                                    @if($member->profile_photo_path)
                                                        <img src="{{ asset('storage/'.$member->profile_photo_path) }}" alt="{{ $member->name }}" class="h-full w-full object-cover">
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900 dark:text-white">{{ $member->name }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $member->member_id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full text-xs font-medium">
                                                {{ $member->borrowings_count }} kali
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-6 text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="mt-2">Tidak ada data anggota</p>
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
    </div>
</x-app-layout>