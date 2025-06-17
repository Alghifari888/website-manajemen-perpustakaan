<div class="mb-6 border-b border-gray-200 dark:border-gray-700">
    <nav class="flex space-x-4" aria-label="Tabs">
        <a href="{{ route('member.account.profile') }}" class="{{ request()->routeIs('member.account.profile') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Profil Saya
        </a>
        <a href="{{ route('member.account.history') }}" class="{{ request()->routeIs('member.account.history') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Riwayat Peminjaman
        </a>
        <a href="{{ route('member.account.fines') }}" class="{{ request()->routeIs('member.account.fines') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Denda Saya
        </a>
    </nav>
</div>