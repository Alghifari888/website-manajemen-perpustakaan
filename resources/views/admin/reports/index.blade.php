<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Laporan & Statistik') }}
            </h2>
            <a href="{{ route('admin.reports.export.pdf') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                Ekspor ke PDF
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                {{-- Kartu Statistik --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm"><h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Total Anggota</h3><p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalMembers }}</p></div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm"><h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Total Judul Buku</h3><p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalBooks }}</p></div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm"><h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Pinjaman Aktif</h3><p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $activeBorrowings }}</p></div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm"><h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Denda Belum Dibayar</h3><p class="text-3xl font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($totalFines, 0, ',', '.') }}</p></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Tabel Buku Terpopuler --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg mb-4 text-gray-900 dark:text-gray-100">Top 5 Buku Terpopuler</h3>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"><tr><th class="py-3 px-6">Judul Buku</th><th class="py-3 px-6">Total Pinjam</th></tr></thead>
                            <tbody>
                                @forelse ($popularBooks as $book)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="py-4 px-6 font-medium text-gray-900 dark:text-white">{{ $book->title }}</td>
                                    <td class="py-4 px-6">{{ $book->borrowings_count }} kali</td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="text-center py-4">Tidak ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Tabel Anggota Teraktif --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg mb-4 text-gray-900 dark:text-gray-100">Top 5 Anggota Teraktif</h3>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"><tr><th class="py-3 px-6">Nama Anggota</th><th class="py-3 px-6">Total Pinjam</th></tr></thead>
                            <tbody>
                                @forelse ($activeMembers as $member)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="py-4 px-6 font-medium text-gray-900 dark:text-white">{{ $member->name }}</td>
                                    <td class="py-4 px-6">{{ $member->borrowings_count }} kali</td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="text-center py-4">Tidak ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>