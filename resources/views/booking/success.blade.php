@extends('layouts.app')

@section('title', 'Bukti Reservasi #PRV-' . $booking->id . ' — PadelHub Indonesia')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-12 sm:py-16">
    @php
        $statusStyles = [
            'Pending' => 'bg-amber-500/15 text-amber-300 border-amber-400/35',
            'Lunas'   => 'bg-emerald-500/15 text-emerald-300 border-emerald-400/35',
            'Batal'   => 'bg-red-500/15 text-red-300 border-red-400/35',
        ];
    @endphp

    <div class="bg-[#132B28] border border-white/10 rounded-2xl overflow-hidden shadow-xl">
        <div class="p-7 sm:p-9 border-b border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.18em] text-[#C8EE5A]">
                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                    </svg>
                    <span>Booking Recorded</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white mt-2">Reservasi Berhasil Diajukan</h1>
                <p class="text-sm text-[#93ABA6] mt-1">
                    Simpan kode transaksi di bawah ini untuk konfirmasi kedatangan di resepsionis.
                </p>
            </div>
            <span class="px-3.5 py-1.5 rounded-full text-xs font-semibold border self-start sm:self-center {{ $statusStyles[$booking->status] ?? 'bg-white/10 text-white border-white/20' }}">
                {{ $booking->status }}
            </span>
        </div>

        <div class="p-7 sm:p-9 space-y-6">
            <div class="bg-[#091917] border border-white/10 rounded-xl p-5 flex items-center justify-between gap-4">
                <span class="text-xs uppercase tracking-wider text-[#93ABA6] font-semibold">Kode Booking</span>
                <span class="text-xl font-bold text-[#C8EE5A] font-mono-tabular">#PRV-{{ $booking->id }}</span>
            </div>

            <dl class="space-y-3.5 text-sm">
                <div class="flex justify-between gap-4 pb-3 border-b border-white/10">
                    <dt class="text-[#93ABA6]">Nama Pemesan</dt>
                    <dd class="font-semibold text-white text-right">{{ $booking->customer_name }}</dd>
                </div>
                <div class="flex justify-between gap-4 pb-3 border-b border-white/10">
                    <dt class="text-[#93ABA6]">No. Telepon</dt>
                    <dd class="font-mono-tabular text-white text-right">{{ $booking->customer_phone }}</dd>
                </div>
                <div class="flex justify-between gap-4 pb-3 border-b border-white/10">
                    <dt class="text-[#93ABA6]">Tanggal Main</dt>
                    <dd class="font-mono-tabular text-white text-right">{{ $booking->booking_date }}</dd>
                </div>
                @foreach($booking->details as $detail)
                    <div class="flex justify-between gap-4 pb-3 border-b border-white/10">
                        <dt class="text-[#93ABA6]">Arena &amp; Sesi</dt>
                        <dd class="text-right">
                            <span class="font-semibold text-white block">{{ $detail->court->name ?? 'Lapangan Dihapus' }}</span>
                            <span class="text-xs text-[#93ABA6] font-mono-tabular">{{ $detail->start_time }} ({{ $detail->duration_hours }} Jam)</span>
                        </dd>
                    </div>
                @endforeach
                <div class="flex items-baseline justify-between gap-4 pt-1">
                    <dt class="text-[#93ABA6] font-semibold">Total Biaya</dt>
                    <dd class="text-xl font-extrabold text-[#C8EE5A] font-mono-tabular">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </dd>
                </div>
            </dl>

            <div class="pt-4 flex flex-wrap items-center gap-3">
                <a href="{{ route('home') }}" class="px-5 py-2.5 rounded-full border border-white/20 hover:border-white/50 text-xs font-semibold text-white transition">
                    Kembali ke Beranda
                </a>
                <a href="{{ route('booking.create') }}" class="px-5 py-2.5 rounded-full bg-white text-[#0D211F] hover:bg-[#C8EE5A] text-xs font-bold transition">
                    Pesan Lagi
                </a>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.bookings.index') }}" class="px-5 py-2.5 rounded-full bg-[#C8EE5A] text-[#0D211F] hover:opacity-90 text-xs font-bold transition ml-auto">
                            Kelola Booking
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
