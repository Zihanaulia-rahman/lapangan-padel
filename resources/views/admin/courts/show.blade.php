@extends('layouts.app')

@section('title', $court->name . ' — Admin PadelHub')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 lg:py-12">
    @include('admin._nav', ['eyebrow' => 'Detail Arena', 'heading' => $court->name])

    <div class="bg-[#132B28] border border-white/10 rounded-2xl overflow-hidden shadow-xl">
        <div class="aspect-[16/9] max-h-80 w-full bg-[#091917] overflow-hidden border-b border-white/10">
            <img
                src="{{ $court->display_image_url }}"
                alt="{{ $court->name }}"
                width="960"
                height="600"
                class="w-full h-full object-cover"
            >
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-white/10">
                <div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold border border-white/15 bg-[#091917] text-[#C8EE5A]">
                        {{ $court->type }}
                    </span>
                    <h2 class="text-2xl font-bold text-white mt-3">{{ $court->name }}</h2>
                </div>
                <div class="text-left sm:text-right">
                    <span class="text-xs uppercase tracking-wider text-[#93ABA6] block">Tarif Sewa</span>
                    <span class="text-2xl font-extrabold text-[#C8EE5A] font-mono-tabular">
                        Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}
                        <span class="text-xs font-sans font-normal text-[#93ABA6]">/ jam</span>
                    </span>
                </div>
            </div>

            <div>
                <span class="text-xs uppercase tracking-wider text-[#93ABA6] block mb-2">Deskripsi</span>
                <p class="text-[#C3D2CF] text-sm leading-relaxed">{{ $court->description }}</p>
            </div>

            <div class="pt-5 border-t border-white/10 flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.courts.edit', $court->id) }}" class="px-6 py-2.5 rounded-full bg-white text-[#0D211F] hover:bg-[#C8EE5A] text-xs font-bold uppercase tracking-wider transition">
                    Edit Arena
                </a>
                <button
                    type="button"
                    data-delete-court-url="{{ route('admin.courts.destroy', $court->id) }}"
                    data-delete-court-name="{{ $court->name }}"
                    class="px-6 py-2.5 rounded-full border border-red-400/35 bg-red-950/35 text-red-200 hover:bg-red-500 hover:text-white text-xs font-semibold uppercase tracking-wider transition cursor-pointer"
                >
                    Hapus Arena
                </button>
            </div>
        </div>
    </div>
</div>

@include('admin._delete_dialog')
@endsection
