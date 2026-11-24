@extends('layouts.app')

@section('title', 'Manajemen Reservasi — Admin PadelHub')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 lg:py-12">
    @include('admin._nav', ['eyebrow' => 'Admin Panel', 'heading' => 'Manajemen Reservasi'])

    @if(session('success'))
        <div class="mb-6 bg-emerald-950/45 border border-emerald-400/40 text-emerald-200 px-5 py-3.5 rounded-xl text-sm" role="status">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#132B28] border border-white/10 rounded-2xl shadow-xl overflow-hidden">
        <div tabindex="0" role="region" aria-labelledby="bookings-table-caption" class="table-wrapper">
            <table class="data-table text-sm text-[#C3D2CF]">
                <caption id="bookings-table-caption" class="visually-hidden">Daftar transaksi reservasi lapangan padel</caption>
                <thead>
                    <tr class="text-[#93ABA6] text-xs uppercase tracking-wider">
                        <th class="p-4 sm:p-5 text-left">ID / Pemesan</th>
                        <th class="p-4 sm:p-5 text-left">Lapangan &amp; Jadwal</th>
                        <th class="p-4 sm:p-5 text-left">Total Harga</th>
                        <th class="p-4 sm:p-5 text-left">Status</th>
                        <th class="p-4 sm:p-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($bookings as $booking)
                        @php
                            $statusClasses = [
                                'Pending' => 'bg-amber-500/15 text-amber-300 border-amber-400/35',
                                'Lunas'   => 'bg-emerald-500/15 text-emerald-300 border-emerald-400/35',
                                'Batal'   => 'bg-red-500/15 text-red-300 border-red-400/35',
                            ];
                        @endphp
                        <tr>
                            <th scope="row" class="p-4 sm:p-5 text-left align-top">
                                <div class="font-bold text-white">
                                    <span class="font-mono-tabular text-[#C8EE5A]">#{{ $booking->id }}</span> — {{ $booking->customer_name }}
                                </div>
                                <div class="text-xs text-[#93ABA6] font-mono-tabular mt-0.5 font-normal">{{ $booking->customer_phone }}</div>
                            </th>
                            <td data-label="Lapangan &amp; Jadwal" class="p-4 sm:p-5 align-top">
                                <div class="text-right sm:text-left">
                                    @foreach($booking->details as $detail)
                                        <div class="font-medium text-white">{{ $detail->court->name ?? 'Lapangan Dihapus' }}</div>
                                        <div class="text-xs text-[#93ABA6] font-mono-tabular mt-0.5">
                                            {{ $booking->booking_date }} | {{ $detail->start_time }} ({{ $detail->duration_hours }} Jam)
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td data-label="Total Harga" class="p-4 sm:p-5 font-semibold text-white font-mono-tabular whitespace-nowrap align-top">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </td>
                            <td data-label="Status" class="p-4 sm:p-5 align-top">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold border {{ $statusClasses[$booking->status] ?? 'bg-white/10 text-white border-white/20' }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td data-label="Aksi" class="p-4 sm:p-5 sm:text-center align-top">
                                <div class="inline-flex flex-wrap items-center justify-end sm:justify-center gap-2">
                                    <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST" class="inline-flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        <label for="status-{{ $booking->id }}" class="visually-hidden">Ubah status booking #{{ $booking->id }}</label>
                                        <select
                                            id="status-{{ $booking->id }}"
                                            name="status"
                                            onchange="this.form.submit()"
                                            class="bg-[#081715] border border-white/15 rounded-lg px-3 py-1.5 text-xs text-white focus:outline-none focus:border-[#C8EE5A]"
                                        >
                                            <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Lunas" {{ $booking->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                            <option value="Batal" {{ $booking->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                    </form>

                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="px-3 py-1.5 rounded-lg border border-white/15 hover:border-[#C8EE5A]/60 text-xs font-semibold text-[#C3D2CF] hover:text-white transition">
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-[#93ABA6]">
                                Belum ada data riwayat pemesanan lapangan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="p-5 border-t border-white/10">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
