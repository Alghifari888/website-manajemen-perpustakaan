<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end mb-6">
                        <a href="{{ route('admin.members.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Tambah Anggota
                        </a>
                    </div>

                    <form method="GET" action="{{ route('admin.members.index') }}" class="mb-6">
                        <div class="flex gap-4">
                            <div class="flex-grow">
                                <x-text-input id="search" name="search" type="text" class="block w-full"
                                              placeholder="Cari berdasarkan nama atau email..."
                                              :value="request('search')" />
                            </div>
                            <x-primary-button type="submit">Cari</x-primary-button>
                            <a href="{{ route('admin.members.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">Reset</a>
                        </div>
                    </form>

                    @include('partials.flash-messages')

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Foto</th>
                                    <th scope="col" class="py-3 px-6">Nama</th>
                                    <th scope="col" class="py-3 px-6">Email</th>
                                    <th scope="col" class="py-3 px-6">No. Telepon</th>
                                    <th scope="col" class="py-3 px-6">Alamat</th>
                                    <th scope="col" class="py-3 px-6">NIS/NIM</th>
                                    <th scope="col" class="py-3 px-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($members as $member)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="py-4 px-6">
                                            <img src="{{ $member->profile?->profile_photo_path ? asset('storage/' . $member->profile->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=random' }}" alt="{{ $member->name }}" class="h-10 w-10 rounded-full object-cover">
                                        </td>
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $member->name }}</td>
                                        <td class="py-4 px-6">{{ $member->email }}</td>
                                        <td class="py-4 px-6">{{ $member->profile?->phone_number ?? '-' }}</td>
                                        <td class="py-4 px-6">{{ Str::limit($member->profile?->address, 30) ?? '-' }}</td>
                                        <td class="py-4 px-6">{{ $member->profile?->nis_nim ?? '-' }}</td>
                                        <td class="py-4 px-6">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.members.edit', $member) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                <form action="{{ route('admin.members.destroy', $member) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="7" class="py-4 px-6 text-center">
                                            Tidak ada data anggota ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">
                        {{ $members->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>