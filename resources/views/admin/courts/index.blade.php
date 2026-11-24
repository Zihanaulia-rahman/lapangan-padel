@extends('layouts.app')

@section('title', 'Daftar Arena — Admin PadelHub')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 lg:py-12">
    @include('admin._nav', ['eyebrow' => 'Admin Panel', 'heading' => 'Manajemen Arena Padel'])

    @if(session('success'))
        <div class="mb-6 bg-emerald-950/45 border border-emerald-400/40 text-emerald-200 px-5 py-3.5 rounded-xl text-sm" role="status">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#132B28] border border-white/10 rounded-2xl shadow-xl overflow-hidden">
        <div tabindex="0" role="region" aria-labelledby="courts-table-caption" class="table-wrapper">
            <table class="data-table text-sm text-[#C3D2CF]">
                <caption id="courts-table-caption" class="visually-hidden">Daftar lapangan padel yang tersedia</caption>
                <thead>
                    <tr class="text-[#93ABA6] text-xs uppercase tracking-wider">
                        <th class="p-4 sm:p-5 text-left">Arena</th>
                        <th class="p-4 sm:p-5 text-left">Tipe</th>
                        <th class="p-4 sm:p-5 text-left">Tarif / Jam</th>
                        <th class="p-4 sm:p-5 text-left">Deskripsi</th>
                        <th class="p-4 sm:p-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($courts as $court)
                        <tr>
                            <th scope="row" class="p-4 sm:p-5 text-left align-middle">
                                <div class="flex items-center gap-3.5">
                                    <img
                                        src="{{ $court->display_image_url }}"
                                        alt="{{ $court->name }}"
                                        width="128"
                                        height="80"
                                        loading="lazy"
                                        decoding="async"
                                        class="w-16 h-11 object-cover rounded-lg border border-white/10 shrink-0 bg-[#091917]"
                                    >
                                    <span class="font-bold text-white">{{ $court->name }}</span>
                                </div>
                            </th>
                            <td data-label="Tipe" class="p-4 sm:p-5 align-middle">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold border border-white/15 bg-[#091917] text-[#C8EE5A]">
                                    {{ $court->type }}
                                </span>
                            </td>
                            <td data-label="Tarif / Jam" class="p-4 sm:p-5 font-semibold text-white font-mono-tabular whitespace-nowrap align-middle">
                                Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}
                            </td>
                            <td data-label="Deskripsi" class="p-4 sm:p-5 text-xs text-[#93ABA6] max-w-xs align-middle">
                                <span class="text-right sm:text-left">{{ \Illuminate\Support\Str::limit($court->description, 90) }}</span>
                            </td>
                            <td data-label="Aksi" class="p-4 sm:p-5 sm:text-center align-middle">
                                <div class="inline-flex flex-wrap items-center justify-end sm:justify-center gap-2">
                                    <a href="{{ route('admin.courts.show', $court->id) }}" class="px-3 py-1.5 rounded-lg border border-white/15 hover:border-white/40 text-xs font-medium text-[#C3D2CF] hover:text-white transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.courts.edit', $court->id) }}" class="px-3 py-1.5 rounded-lg border border-[#C8EE5A]/40 bg-[#C8EE5A]/10 text-[#C8EE5A] hover:bg-[#C8EE5A] hover:text-[#0D211F] text-xs font-semibold transition">
                                        Edit
                                    </a>
                                    <button
                                        type="button"
                                        data-delete-court-url="{{ route('admin.courts.destroy', $court->id) }}"
                                        data-delete-court-name="{{ $court->name }}"
                                        class="px-3 py-1.5 rounded-lg border border-red-400/35 bg-red-950/35 text-red-200 hover:bg-red-500 hover:text-white text-xs font-semibold transition cursor-pointer"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-[#93ABA6]">
                                Belum ada arena padel terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($courts->hasPages())
            <div class="p-5 border-t border-white/10">
                {{ $courts->links() }}
            </div>
        @endif
    </div>
</div>

@include('admin._delete_dialog')
@endsection
