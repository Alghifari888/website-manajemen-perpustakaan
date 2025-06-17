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
                                    <th scope="col" class="py-3 px-6">Terkait Peminjaman Buku</th>
                                    <th scope="col" class="py-3 px-6">Jumlah Denda</th>
                                    <th scope="col" class="py-3 px-6">Alasan</th>
                                    <th scope="col" class="py-3 px-6">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($fines as $fine)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $fine->borrowing->book->title }}</td>
                                        <td class="py-4 px-6">Rp {{ number_format($fine->amount, 0, ',', '.') }}</td>
                                        <td class="py-4 px-6">{{ $fine->reason }}</td>
                                        <td class="py-4 px-6">
                                            @php
                                                $status = $fine->status;
                                                $statusClasses = [
                                                    'belum_dibayar' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                                    'lunas' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                                ];
                                            @endphp
                                            <span class="px-2 py-1 font-semibold leading-tight text-xs rounded-full {{ $statusClasses[$status] ?? '' }}">
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                     <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="4" class="py-4 px-6 text-center">
                                            Anda tidak memiliki denda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">
                        {{ $fines->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>