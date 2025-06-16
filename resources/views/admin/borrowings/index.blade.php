<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaksi Peminjaman & Pengembalian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end mb-6">
                        <a href="{{ route('admin.borrowings.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            + Catat Peminjaman
                        </a>
                    </div>

                    <form method="GET" action="{{ route('admin.borrowings.index') }}" class="mb-6">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-grow">
                                <x-text-input id="search" name="search" type="text" class="block w-full"
                                              placeholder="Cari nama peminjam / judul buku..."
                                              :value="request('search')" />
                            </div>
                            
                            <div>
                                <select name="status" id="status" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">Semua Status</option>
                                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                </select>
                            </div>

                            <div class="flex items-center">
                                <x-primary-button type="submit">Cari</x-primary-button>
                                <a href="{{ route('admin.borrowings.index') }}" class="ms-3 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">Reset</a>
                            </div>
                        </div>
                    </form>

                    @include('partials.flash-messages')

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Judul Buku</th>
                                    <th scope="col" class="py-3 px-6">Peminjam</th>
                                    <th scope="col" class="py-3 px-6">Tgl Pinjam</th>
                                    <th scope="col" class="py-3 px-6">Jatuh Tempo</th>
                                    <th scope="col" class="py-3 px-6">Tgl Kembali</th>
                                    <th scope="col" class="py-3 px-6">Status</th>
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($borrowings as $borrowing)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $borrowing->book->title }}</td>
                                        <td class="py-4 px-6">{{ $borrowing->user->name }}</td>
                                        <td class="py-4 px-6">{{ $borrowing->borrowed_at->format('d-m-Y') }}</td>
                                        <td class="py-4 px-6">{{ $borrowing->due_at->format('d-m-Y') }}</td>
                                        <td class="py-4 px-6">{{ $borrowing->returned_at ? $borrowing->returned_at->format('d-m-Y') : '-' }}</td>
                                        <td class="py-4 px-6">
                                            @php
                                                $status = $borrowing->status;
                                                $isOverdue = \Carbon\Carbon::now()->greaterThan($borrowing->due_at) && $status == 'dipinjam';
                                                
                                                if ($isOverdue) {
                                                    $status = 'terlambat';
                                                }

                                                $statusClasses = [
                                                    'dipinjam' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                                    'terlambat' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                                    'dikembalikan' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                                ];
                                            @endphp
                                            <span class="px-2 py-1 font-semibold leading-tight text-xs rounded-full {{ $statusClasses[$status] ?? '' }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            @if($borrowing->status === 'dipinjam' || ($isOverdue && $borrowing->status !== 'dikembalikan'))
                                                <form action="{{ route('admin.borrowings.return', $borrowing) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian buku ini?');">
                                                    @csrf
                                                    <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Kembalikan</button>
                                                </form>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="7" class="py-4 px-6 text-center">
                                            Belum ada data transaksi yang sesuai.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">
                        {{ $borrowings->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>