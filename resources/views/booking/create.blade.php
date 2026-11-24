@extends('layouts.app')

@section('title', 'Reservasi Lapangan — PadelHub Indonesia')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 lg:py-14">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#C8EE5A]">Form Pemesanan</span>
            <h1 class="text-3xl font-bold tracking-tight text-white mt-1.5">Reservasi Lapangan Padel</h1>
            <p class="text-sm text-[#93ABA6] mt-1.5">Pilih arena, tanggal bermain, dan durasi sesi untuk mengunci jadwal Anda.</p>
        </div>
        <a href="{{ route('home') }}#lapangan" class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/15 hover:border-white/40 text-xs font-semibold text-[#C3D2CF] hover:text-white transition self-start sm:self-auto">
            &larr; Kembali ke Lapangan
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-950/50 border border-red-400/40 text-red-200 p-4 rounded-xl text-sm" role="alert">
            <p class="font-semibold mb-1">Mohon periksa kembali data pemesanan Anda:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-7 bg-[#132B28] border border-white/10 rounded-2xl p-6 sm:p-8 shadow-xl">
            <form action="{{ route('booking.store') }}" method="POST" class="space-y-6" id="booking-form">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="customer_name" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Nama Pemesan</label>
                        <span id="booking-name-hint" class="field-hint">Nama untuk identifikasi saat check-in.</span>
                        <input
                            type="text"
                            id="customer_name"
                            name="customer_name"
                            value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                            required
                            autocomplete="name"
                            enterkeyhint="next"
                            aria-describedby="booking-name-hint"
                            data-error="booking-name-error"
                            placeholder="Nama lengkap pemesan"
                            class="club-input"
                        >
                        <div id="booking-name-error" class="field-error">
                            <span role="img" aria-label="Error">!</span> Nama pemesan wajib diisi.
                        </div>
                    </div>

                    <div>
                        <label for="customer_phone" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Nomor WhatsApp / Telepon</label>
                        <span id="booking-phone-hint" class="field-hint">Contoh: 081234567890</span>
                        <input
                            type="tel"
                            id="customer_phone"
                            name="customer_phone"
                            value="{{ old('customer_phone') }}"
                            required
                            maxlength="20"
                            inputmode="tel"
                            autocomplete="tel"
                            enterkeyhint="next"
                            aria-describedby="booking-phone-hint"
                            data-error="booking-phone-error"
                            placeholder="0812xxxxxxxx"
                            class="club-input"
                        >
                        <div id="booking-phone-error" class="field-error">
                            <span role="img" aria-label="Error">!</span> Nomor WhatsApp / telepon wajib diisi.
                        </div>
                    </div>
                </div>

                <div>
                    <label for="court_id" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Pilih Lapangan</label>
                    <span id="booking-court-hint" class="field-hint">Menampilkan arena beserta tarif sewa per jam.</span>
                    <select
                        id="court_id"
                        name="court_id"
                        required
                        aria-describedby="booking-court-hint"
                        data-error="booking-court-error"
                        class="club-input"
                    >
                        <option value="">-- Pilih Arena Padel --</option>
                        @foreach($courts as $court)
                            <option
                                value="{{ $court->id }}"
                                data-name="{{ $court->name }}"
                                data-type="{{ $court->type }}"
                                data-price="{{ $court->price_per_hour }}"
                                data-image="{{ $court->display_image_url }}"
                                {{ (string) old('court_id', $selectedCourtId) === (string) $court->id ? 'selected' : '' }}
                            >
                                {{ $court->name }} ({{ $court->type }}) — Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}/jam
                            </option>
                        @endforeach
                    </select>
                    <div id="booking-court-error" class="field-error">
                        <span role="img" aria-label="Error">!</span> Silakan pilih salah satu lapangan.
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label for="booking_date" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Tanggal Main</label>
                        <span id="booking-date-hint" class="field-hint">Minimal hari ini.</span>
                        <input
                            type="date"
                            id="booking_date"
                            name="booking_date"
                            min="{{ date('Y-m-d') }}"
                            value="{{ old('booking_date', date('Y-m-d')) }}"
                            required
                            aria-describedby="booking-date-hint"
                            data-error="booking-date-error"
                            class="club-input"
                        >
                        <div id="booking-date-error" class="field-error">
                            <span role="img" aria-label="Error">!</span> Pilih tanggal minimal hari ini.
                        </div>
                    </div>

                    <div>
                        <label for="start_time" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Jam Mulai</label>
                        <span id="booking-time-hint" class="field-hint">Sesi 06:00–22:00 WIB</span>
                        <select
                            id="start_time"
                            name="start_time"
                            required
                            aria-describedby="booking-time-hint"
                            class="club-input"
                        >
                            @for ($hour = 6; $hour <= 22; $hour++)
                                @php $slot = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                                <option value="{{ $slot }}" {{ old('start_time', '08:00') === $slot ? 'selected' : '' }}>
                                    {{ $slot }} WIB
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label for="duration_hours" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Durasi</label>
                        <span id="booking-duration-hint" class="field-hint">Maksimal 8 jam.</span>
                        <select
                            id="duration_hours"
                            name="duration_hours"
                            required
                            aria-describedby="booking-duration-hint"
                            class="club-input"
                        >
                            @for ($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ (int) old('duration_hours', 1) === $i ? 'selected' : '' }}>
                                    {{ $i }} Jam
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 rounded-full bg-white text-[#0D211F] hover:bg-[#C8EE5A] font-bold text-sm transition cursor-pointer">
                        Ajukan Reservasi
                    </button>
                </div>
            </form>
        </div>

        <!-- Ringkasan Estimasi Real-time -->
        <aside class="lg:col-span-5 bg-[#132B28] border border-white/10 rounded-2xl overflow-hidden shadow-xl lg:sticky lg:top-24" aria-label="Ringkasan Reservasi">
            <div class="aspect-[16/10] bg-[#091917] relative overflow-hidden border-b border-white/10">
                <img
                    id="summary-court-image"
                    src="{{ asset('images/hero-padel.svg') }}"
                    alt="Pratinjau arena padel terpilih"
                    width="960"
                    height="600"
                    class="w-full h-full object-cover"
                >
                <span id="summary-court-type" class="hidden absolute top-3.5 left-3.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-[#0D211F]/90 text-[#C8EE5A] border border-[#C8EE5A]/35"></span>
            </div>

            <div class="p-6 space-y-5">
                <div>
                    <span class="text-[11px] uppercase tracking-[0.2em] text-[#93ABA6] font-semibold">Ringkasan Jadwal</span>
                    <h2 id="summary-court-name" class="text-lg font-bold text-white mt-1">Pilih lapangan terlebih dahulu</h2>
                </div>

                <dl class="space-y-3 text-sm border-y border-white/10 py-4">
                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-[#93ABA6]">Tanggal</dt>
                        <dd id="summary-date" class="font-mono-tabular text-white font-medium">-</dd>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-[#93ABA6]">Waktu Main</dt>
                        <dd id="summary-time" class="font-mono-tabular text-white font-medium">-</dd>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-[#93ABA6]">Rincian Tarif</dt>
                        <dd id="price-breakdown" class="font-mono-tabular text-[#C3D2CF] text-xs">-</dd>
                    </div>
                </dl>

                <div class="flex items-baseline justify-between gap-4">
                    <span class="text-xs uppercase tracking-wider text-[#93ABA6] font-semibold">Total Biaya</span>
                    <span id="total-price-display" class="text-2xl font-extrabold text-[#C8EE5A] font-mono-tabular">Rp 0</span>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const courtSelect = document.getElementById('court_id');
        const dateInput = document.getElementById('booking_date');
        const timeSelect = document.getElementById('start_time');
        const durationSelect = document.getElementById('duration_hours');

        const totalDisplay = document.getElementById('total-price-display');
        const breakdown = document.getElementById('price-breakdown');
        const summaryName = document.getElementById('summary-court-name');
        const summaryType = document.getElementById('summary-court-type');
        const summaryImage = document.getElementById('summary-court-image');
        const summaryDate = document.getElementById('summary-date');
        const summaryTime = document.getElementById('summary-time');

        const defaultHeroImg = @json(asset('images/hero-padel.svg'));

        function formatRupiah(amount) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        }

        function updateSummary() {
            const option = courtSelect.options[courtSelect.selectedIndex];
            const price = parseInt(option?.dataset?.price || 0, 10);
            const duration = parseInt(durationSelect.value || 1, 10);
            const startTime = timeSelect.value || '08:00';
            const startHour = parseInt(startTime.split(':')[0] || 8, 10);
            const endHour = startHour + duration;
            const endFormatted = String(endHour).padStart(2, '0') + ':00';

            summaryDate.textContent = dateInput.value || '-';
            summaryTime.textContent = `${startTime} – ${endFormatted} WIB (${duration} Jam)`;

            if (price > 0) {
                summaryName.textContent = option.dataset.name;
                summaryType.textContent = option.dataset.type;
                summaryType.classList.remove('hidden');
                summaryImage.src = option.dataset.image || defaultHeroImg;
                summaryImage.alt = option.dataset.name;
                breakdown.textContent = `${formatRupiah(price)} × ${duration} jam`;
                totalDisplay.textContent = formatRupiah(price * duration);
            } else {
                summaryName.textContent = 'Pilih lapangan terlebih dahulu';
                summaryType.classList.add('hidden');
                summaryImage.src = defaultHeroImg;
                breakdown.textContent = 'Pilih lapangan untuk melihat tarif';
                totalDisplay.textContent = 'Rp 0';
            }
        }

        [courtSelect, dateInput, timeSelect, durationSelect].forEach((el) => {
            el.addEventListener('change', updateSummary);
        });

        updateSummary();
    });
</script>
@endsection
