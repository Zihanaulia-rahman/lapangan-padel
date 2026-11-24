@extends('layouts.app')

@section('title', 'PadelHub Indonesia — Main Padel, Kapan Saja')

@section('content')
@if(session('success'))
    <div class="max-w-7xl mx-auto px-6 pt-6" role="status">
        <div class="bg-emerald-950/45 border border-emerald-400/40 text-emerald-200 px-5 py-3.5 rounded-xl text-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-300 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

<!-- Hero Section -->
<section class="relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 pt-10 pb-16 lg:pt-16 lg:pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            <div class="lg:col-span-6 space-y-6">
                <div class="inline-flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.2em] text-[#C8EE5A]">
                    <span class="w-6 h-px bg-[#C8EE5A]" aria-hidden="true"></span>
                    <span>Reservasi Arena Padel</span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-[4rem] font-extrabold tracking-tight text-white leading-[1.06]">
                    Main Padel,<br>
                    Kapan Saja.
                </h1>
                <p class="text-base sm:text-lg text-[#C3D2CF] max-w-xl leading-relaxed">
                    Pesan lapangan mudah &amp; cepat. Pilih tipe arena panoramik, indoor, atau outdoor sesuai waktu bermain Anda.
                </p>
                <div class="pt-2 flex flex-col items-start gap-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('booking.create') }}" class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full bg-white text-[#0D211F] hover:bg-[#C8EE5A] font-bold text-sm transition shadow-sm">
                            <span>Pesan Sekarang</span>
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 10h12m0 0l-4-4m4 4l-4 4"/>
                            </svg>
                        </a>
                        <a href="#lapangan" class="inline-flex items-center gap-2 px-5 py-3.5 rounded-full border border-white/20 hover:border-white/50 text-sm font-medium text-white transition">
                            <span>Lihat Daftar Lapangan</span>
                        </a>
                    </div>
                    @guest
                        <a href="{{ route('booking.create') }}" class="text-xs sm:text-sm text-[#93ABA6] hover:text-white underline underline-offset-4 transition">
                            Lanjutkan sebagai Tamu (tanpa perlu login)
                        </a>
                    @endguest
                </div>
            </div>

            <div class="lg:col-span-6 relative">
                <!-- Subtle curved contour lines echoing court markings -->
                <svg class="hidden sm:block absolute -inset-6 w-[calc(100%+3rem)] h-[calc(100%+3rem)] pointer-events-none text-white/[0.06]" viewBox="0 0 600 450" fill="none" aria-hidden="true">
                    <path d="M-30 390 C 90 360, 140 240, 260 210 C 380 180, 480 90, 620 60" stroke="currentColor" stroke-width="1"/>
                    <path d="M-30 415 C 100 385, 160 265, 280 235 C 400 205, 495 115, 620 85" stroke="currentColor" stroke-width="1"/>
                    <path d="M-30 440 C 110 410, 180 290, 300 260 C 420 230, 510 140, 620 110" stroke="currentColor" stroke-width="1"/>
                </svg>

                <div class="hero-photo-frame relative shadow-2xl">
                    <img
                        src="{{ asset('images/hero-padel.svg') }}"
                        alt="Ilustrasi arsitektural lapangan padel berstandar turnamen di PadelHub Indonesia"
                        width="1200"
                        height="900"
                        fetchpriority="high"
                        decoding="async"
                        class="w-full h-auto block object-cover"
                    >
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Katalog Lapangan Section -->
<section id="lapangan" class="border-t border-white/10 bg-[#0A1B19]">
    <div class="max-w-7xl mx-auto px-6 py-16 lg:py-20">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#C8EE5A]">Pilihan Arena</span>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-white mt-2">
                    Daftar Lapangan Tersedia
                </h2>
                <p class="text-sm text-[#93ABA6] mt-1.5">
                    Pilih arena sesuai preferensi permainan dan lanjutkan ke pengisian jadwal.
                </p>
            </div>

            @if($courts->isNotEmpty())
                <div class="flex flex-wrap items-center gap-2" role="group" aria-label="Filter tipe lapangan">
                    @foreach(['all' => 'Semua', 'Panoramic' => 'Panoramic', 'Indoor' => 'Indoor', 'Outdoor' => 'Outdoor'] as $filterKey => $filterLabel)
                        <button
                            type="button"
                            data-court-filter="{{ $filterKey }}"
                            aria-pressed="{{ $filterKey === 'all' ? 'true' : 'false' }}"
                            class="court-filter-btn px-4 py-1.5 rounded-full text-xs font-semibold border transition cursor-pointer {{ $filterKey === 'all' ? 'bg-white text-[#0D211F] border-white' : 'bg-transparent text-[#C3D2CF] border-white/15 hover:border-white/40' }}"
                        >
                            {{ $filterLabel }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="courts-grid">
            @forelse($courts as $court)
                @php
                    $typeStyles = [
                        'Panoramic' => 'bg-[#0D211F]/90 text-[#C8EE5A] border-[#C8EE5A]/35',
                        'Indoor'    => 'bg-[#0D211F]/90 text-sky-200 border-sky-300/30',
                        'Outdoor'   => 'bg-[#0D211F]/90 text-emerald-200 border-emerald-300/30',
                    ];
                @endphp
                <article
                    data-court-card
                    data-court-type="{{ $court->type }}"
                    class="bg-[#132B28] border border-white/10 hover:border-white/25 rounded-2xl overflow-hidden flex flex-col transition"
                >
                    <div class="relative aspect-[16/10] bg-[#091917] overflow-hidden">
                        <img
                            src="{{ $court->display_image_url }}"
                            alt="{{ $court->name }}"
                            width="960"
                            height="600"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover"
                        >
                        <span class="absolute top-3.5 left-3.5 px-3 py-1 rounded-full text-[11px] font-semibold border backdrop-blur-sm {{ $typeStyles[$court->type] ?? 'bg-[#0D211F]/90 text-white border-white/20' }}">
                            {{ $court->type }}
                        </span>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between gap-6">
                        <div>
                            <h3 class="text-lg font-bold text-white leading-snug">
                                {{ $court->name }}
                            </h3>
                            <p class="text-sm text-[#93ABA6] mt-2 leading-relaxed">
                                {{ $court->description }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-white/10 flex items-center justify-between gap-4">
                            <div>
                                <span class="text-[11px] uppercase tracking-wider text-[#93ABA6] block">Tarif Sewa</span>
                                <span class="text-lg font-bold text-white font-mono-tabular">
                                    Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}
                                    <span class="text-xs font-sans font-normal text-[#93ABA6]">/ jam</span>
                                </span>
                            </div>
                            <a
                                href="{{ route('booking.create', ['court_id' => $court->id]) }}"
                                class="px-4 py-2.5 rounded-full bg-white text-[#0D211F] hover:bg-[#C8EE5A] text-xs font-bold transition whitespace-nowrap"
                            >
                                Pesan Lapangan
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full bg-[#132B28] border border-white/10 rounded-2xl p-10 text-center text-[#93ABA6] text-sm">
                    Belum ada data lapangan yang terdaftar saat ini.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Cara Reservasi & Info Operasional -->
<section id="tentang" class="border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-16 lg:py-20 grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        <div class="lg:col-span-7">
            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#C8EE5A]">Alur Pemesanan</span>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-white mt-2 mb-8">
                Tiga Langkah Mengunci Jadwal
            </h2>
            <div class="divide-y divide-white/10 border-y border-white/10">
                <div class="py-5 flex items-start gap-5">
                    <span class="font-mono-tabular text-sm font-semibold text-[#C8EE5A] pt-0.5">01</span>
                    <div>
                        <h3 class="text-base font-semibold text-white">Pilih Arena &amp; Tanggal</h3>
                        <p class="text-sm text-[#93ABA6] mt-1">Tentukan lapangan Panoramic, Indoor, atau Outdoor beserta tanggal dan jam mulai (06:00–22:00 WIB).</p>
                    </div>
                </div>
                <div class="py-5 flex items-start gap-5">
                    <span class="font-mono-tabular text-sm font-semibold text-[#C8EE5A] pt-0.5">02</span>
                    <div>
                        <h3 class="text-base font-semibold text-white">Isi Data Pemesan</h3>
                        <p class="text-sm text-[#93ABA6] mt-1">Masukkan nama lengkap dan nomor telepon aktif. Pelanggan dapat memesan langsung tanpa wajib membuat akun.</p>
                    </div>
                </div>
                <div class="py-5 flex items-start gap-5">
                    <span class="font-mono-tabular text-sm font-semibold text-[#C8EE5A] pt-0.5">03</span>
                    <div>
                        <h3 class="text-base font-semibold text-white">Terima Kode Booking</h3>
                        <p class="text-sm text-[#93ABA6] mt-1">Sistem langsung menerbitkan bukti reservasi beserta kode transaksi <span class="font-mono-tabular text-white">#PRV</span> untuk verifikasi pembayaran.</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="kontak" class="lg:col-span-5 bg-[#132B28] border border-white/10 rounded-2xl p-6 sm:p-8">
            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#C8EE5A]">Info Klub</span>
            <h2 class="text-xl font-bold text-white mt-2 mb-6">Ketentuan &amp; Operasional</h2>
            <dl class="space-y-4 text-sm">
                <div class="flex items-center justify-between gap-4 pb-3.5 border-b border-white/10">
                    <dt class="text-[#93ABA6]">Jam Operasional</dt>
                    <dd class="font-mono-tabular font-semibold text-white">06:00 – 22:00 WIB</dd>
                </div>
                <div class="flex items-center justify-between gap-4 pb-3.5 border-b border-white/10">
                    <dt class="text-[#93ABA6]">Durasi Per Sesi</dt>
                    <dd class="font-mono-tabular font-semibold text-white">1 – 8 Jam</dd>
                </div>
                <div class="flex items-center justify-between gap-4 pb-3.5 border-b border-white/10">
                    <dt class="text-[#93ABA6]">Status Awal</dt>
                    <dd class="font-semibold text-amber-300">Pending (Menunggu Verifikasi)</dd>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <dt class="text-[#93ABA6]">Total Arena Aktif</dt>
                    <dd class="font-mono-tabular font-semibold text-white">{{ $courts->count() }} Lapangan</dd>
                </div>
            </dl>
            <div class="mt-7 pt-5 border-t border-white/10">
                <a href="{{ route('booking.create') }}" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-full bg-white text-[#0D211F] hover:bg-[#C8EE5A] font-bold text-sm transition">
                    Buat Reservasi Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterButtons = document.querySelectorAll('[data-court-filter]');
        const cards = document.querySelectorAll('[data-court-card]');
        if (!filterButtons.length || !cards.length) return;

        filterButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                const selected = btn.getAttribute('data-court-filter');

                filterButtons.forEach((b) => {
                    const active = b === btn;
                    b.setAttribute('aria-pressed', active ? 'true' : 'false');
                    b.classList.toggle('bg-white', active);
                    b.classList.toggle('text-[#0D211F]', active);
                    b.classList.toggle('border-white', active);
                    b.classList.toggle('bg-transparent', !active);
                    b.classList.toggle('text-[#C3D2CF]', !active);
                    b.classList.toggle('border-white/15', !active);
                });

                cards.forEach((card) => {
                    const match = selected === 'all' || card.getAttribute('data-court-type') === selected;
                    card.hidden = !match;
                });
            });
        });
    });
</script>
@endsection
