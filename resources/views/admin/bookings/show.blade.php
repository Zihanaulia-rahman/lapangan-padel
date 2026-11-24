@extends('layouts.app')

@section('title', 'Detail Transaksi #PRV-' . $booking->id . ' — Admin PadelHub')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 lg:py-12">
    @include('admin._nav', ['eyebrow' => 'Detail Transaksi', 'heading' => 'Booking #PRV-' . $booking->id])

    @if(session('success'))
        <div class="mb-6 bg-emerald-950/45 border border-emerald-400/40 text-emerald-200 px-5 py-3.5 rounded-xl text-sm" role="status">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#132B28] border border-white/10 rounded-2xl p-6 sm:p-8 shadow-xl space-y-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-white/10">
            <div>
                <span class="text-xs uppercase tracking-wider text-[#93ABA6] block">Nama Pemesan</span>
                <p class="text-white font-semibold text-lg mt-1">{{ $booking->customer_name }}</p>
            </div>
            <div>
                <span class="text-xs uppercase tracking-wider text-[#93ABA6] block">Nomor Telepon</span>
                <p class="text-white font-mono-tabular text-lg mt-1">{{ $booking->customer_phone }}</p>
            </div>
            <div>
                <span class="text-xs uppercase tracking-wider text-[#93ABA6] block">Tanggal Main</span>
                <p class="text-white font-mono-tabular mt-1">{{ $booking->booking_date }}</p>
            </div>
            <div>
                <label for="detail-status" class="text-xs uppercase tracking-wider text-[#93ABA6] block mb-2">Status Pembayaran</label>
                <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST" class="inline-flex items-center gap-3">
                    @csrf
                    @method('PATCH')
                    <select
                        id="detail-status"
                        name="status"
                        onchange="this.form.submit()"
                        class="bg-[#081715] border border-white/15 rounded-xl px-4 py-2 text-xs font-semibold text-white focus:outline-none focus:border-[#C8EE5A]"
                    >
                        <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Lunas" {{ $booking->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Batal" {{ $booking->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </form>
            </div>
        </div>

        <div>
            <h2 class="text-lg font-bold text-white mb-4">Rincian Arena &amp; Jadwal</h2>
            <div class="space-y-3">
                @foreach($booking->details as $detail)
                    <div class="bg-[#091917] border border-white/10 rounded-xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <div class="font-semibold text-white">{{ $detail->court->name ?? 'Lapangan Dihapus' }}</div>
                            <div class="text-xs text-[#93ABA6] font-mono-tabular mt-1">
                                Tipe: {{ $detail->court->type ?? '-' }} | Mulai: {{ $detail->start_time }} | Durasi: {{ $detail->duration_hours }} Jam
                            </div>
                        </div>
                        <div class="text-[#C8EE5A] font-bold font-mono-tabular">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="pt-6 border-t border-white/10 flex items-baseline justify-between gap-4">
            <span class="text-xs uppercase tracking-wider text-[#93ABA6] font-semibold">Total Pembayaran</span>
            <span class="text-2xl font-extrabold text-[#C8EE5A] font-mono-tabular">
                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
            </span>
        </div>
    </div>
</div>
@endsection
