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

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <img src="{{ $user->profile?->profile_photo_path ? asset('storage/' . $user->profile->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random&size=256' }}" alt="{{ $user->name }}" class="h-40 w-40 rounded-full object-cover mx-auto">
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <h3 class="text-gray-500 dark:text-gray-400">Nama Lengkap</h3>
                                <p>{{ $user->name }}</p>
                            </div>
                             <div>
                                <h3 class="text-gray-500 dark:text-gray-400">Email</h3>
                                <p>{{ $user->email }}</p>
                            </div>
                             <div>
                                <h3 class="text-gray-500 dark:text-gray-400">NIS / NIM</h3>
                                <p>{{ $user->profile?->nis_nim ?? '-' }}</p>
                            </div>
                             <div>
                                <h3 class="text-gray-500 dark:text-gray-400">Nomor Telepon</h3>
                                <p>{{ $user->profile?->phone_number ?? '-' }}</p>
                            </div>
                             <div>
                                <h3 class="text-gray-500 dark:text-gray-400">Alamat</h3>
                                <p>{{ $user->profile?->address ?? '-' }}</p>
                            </div>
                            <div class="pt-2">
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">Ubah Profil</a>
                            </div>
                        </div>
                    </div>

                    <hr class="my-8 border-gray-200 dark:border-gray-700">
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 dark:bg-blue-900/50 p-6 rounded-lg">
                             <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-300">Pinjaman Aktif</h3>
                             <p class="text-3xl font-bold text-blue-900 dark:text-blue-200">{{ $stats['active_borrowings'] }} Buku</p>
                        </div>
                         <div class="bg-red-50 dark:bg-red-900/50 p-6 rounded-lg">
                             <h3 class="text-lg font-semibold text-red-800 dark:text-red-300">Denda Belum Dibayar</h3>
                             <p class="text-3xl font-bold text-red-900 dark:text-red-200">Rp {{ number_format($stats['total_fines'], 0, ',', '.') }}</p>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>