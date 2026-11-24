<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 mb-8 pb-6 border-b border-white/10">
    <div>
        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#C8EE5A]">{{ $eyebrow ?? 'Panel Admin' }}</span>
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white mt-1.5">{{ $heading }}</h1>
    </div>

    <div class="flex flex-wrap items-center gap-2.5">
        <a
            href="{{ route('admin.bookings.index') }}"
            @if(request()->routeIs('admin.bookings.*')) aria-current="page" @endif
            class="px-4 py-2 rounded-full text-xs font-semibold border transition {{ request()->routeIs('admin.bookings.*') ? 'bg-white text-[#0D211F] border-white' : 'bg-[#132B28] text-[#C3D2CF] border-white/15 hover:border-white/40 hover:text-white' }}"
        >
            Manajemen Reservasi
        </a>

        <a
            href="{{ route('admin.courts.index') }}"
            @if(request()->routeIs('admin.courts.index', 'admin.courts.show', 'admin.courts.edit')) aria-current="page" @endif
            class="px-4 py-2 rounded-full text-xs font-semibold border transition {{ request()->routeIs('admin.courts.index', 'admin.courts.show', 'admin.courts.edit') ? 'bg-white text-[#0D211F] border-white' : 'bg-[#132B28] text-[#C3D2CF] border-white/15 hover:border-white/40 hover:text-white' }}"
        >
            Daftar Arena
        </a>

        <a
            href="{{ route('admin.courts.create') }}"
            @if(request()->routeIs('admin.courts.create')) aria-current="page" @endif
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold transition {{ request()->routeIs('admin.courts.create') ? 'bg-[#C8EE5A] text-[#0D211F]' : 'bg-[#C8EE5A]/15 text-[#C8EE5A] border border-[#C8EE5A]/40 hover:bg-[#C8EE5A] hover:text-[#0D211F]' }}"
        >
            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
            </svg>
            <span>Tambah Arena</span>
        </a>

        <a href="{{ route('home') }}" class="px-4 py-2 rounded-full border border-white/15 hover:border-white/40 text-xs font-medium text-[#93ABA6] hover:text-white transition">
            &larr; Kembali ke Beranda
        </a>
    </div>
</div>
