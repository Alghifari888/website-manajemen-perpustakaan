<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Akun Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @include('member.account.partials.sub-nav')

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Judul Buku</th>
                                    <th scope="col" class="py-3 px-6">Tgl Pinjam</th>
                                    <th scope="col" class="py-3 px-6">Jatuh Tempo</th>
                                    <th scope="col" class="py-3 px-6">Tgl Kembali</th>
                                    <th scope="col" class="py-3 px-6">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($borrowings as $borrowing)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $borrowing->book->title }}</td>
                                        <td class="py-4 px-6">{{ $borrowing->borrowed_at->format('d M Y') }}</td>
                                        <td class="py-4 px-6">{{ $borrowing->due_at->format('d M Y') }}</td>
                                        <td class="py-4 px-6">{{ $borrowing->returned_at ? $borrowing->returned_at->format('d M Y') : '-' }}</td>
                                        <td class="py-4 px-6">
                                             @php
                                                $status = $borrowing->status;
                                                $isOverdue = \Carbon\Carbon::now()->greaterThan($borrowing->due_at) && $status == 'dipinjam';
                                                if ($isOverdue) { $status = 'terlambat'; }
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
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="5" class="py-4 px-6 text-center">
                                            Anda belum pernah meminjam buku.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">
                        {{ $borrowings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>