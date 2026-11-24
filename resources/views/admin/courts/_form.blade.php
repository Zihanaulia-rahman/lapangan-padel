@if ($errors->any())
    <div class="mb-6 bg-red-950/50 border border-red-400/40 text-red-200 p-4 rounded-xl text-sm" role="alert">
        <p class="font-semibold mb-1">Mohon periksa kembali input Anda:</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">
    <div>
        <label for="name" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Nama Lapangan / Arena</label>
        <span id="court-name-hint" class="field-hint">Contoh: Padel Court 1 - Panoramic Center</span>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $court->name ?? '') }}"
            required
            aria-describedby="court-name-hint"
            data-error="court-name-error"
            placeholder="Padel Court 1 - Panoramic Center"
            class="club-input"
        >
        <div id="court-name-error" class="field-error">
            <span role="img" aria-label="Error">!</span> Nama lapangan wajib diisi.
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label for="type" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Tipe Lapangan</label>
            <span id="court-type-hint" class="field-hint">Pilih kategori konstruksi arena.</span>
            <select
                id="type"
                name="type"
                required
                aria-describedby="court-type-hint"
                data-error="court-type-error"
                class="club-input"
            >
                <option value="">-- Pilih Tipe --</option>
                @foreach(['Panoramic', 'Indoor', 'Outdoor'] as $typeOption)
                    <option value="{{ $typeOption }}" {{ old('type', $court->type ?? '') === $typeOption ? 'selected' : '' }}>
                        {{ $typeOption }}
                    </option>
                @endforeach
            </select>
            <div id="court-type-error" class="field-error">
                <span role="img" aria-label="Error">!</span> Tipe lapangan wajib dipilih.
            </div>
        </div>

        <div>
            <label for="price_per_hour" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Tarif Per Jam (Rp)</label>
            <span id="court-price-hint" class="field-hint">Masukkan angka rupiah tanpa titik/koma.</span>
            <input
                type="number"
                id="price_per_hour"
                name="price_per_hour"
                min="0"
                step="1000"
                value="{{ old('price_per_hour', $court->price_per_hour ?? '') }}"
                required
                inputmode="numeric"
                aria-describedby="court-price-hint"
                data-error="court-price-error"
                placeholder="350000"
                class="club-input font-mono-tabular"
            >
            <div id="court-price-error" class="field-error">
                <span role="img" aria-label="Error">!</span> Tarif sewa per jam harus bernilai 0 atau lebih.
            </div>
        </div>
    </div>

    <div>
        <label for="description" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Deskripsi Fasilitas</label>
        <span id="court-desc-hint" class="field-hint">Jelaskan jenis rumput, kaca, pencahayaan, atau fasilitas tambahan.</span>
        <textarea
            id="description"
            name="description"
            rows="4"
            required
            aria-describedby="court-desc-hint"
            data-error="court-desc-error"
            placeholder="Spesifikasi arena padel..."
            class="club-input"
        >{{ old('description', $court->description ?? '') }}</textarea>
        <div id="court-desc-error" class="field-error">
            <span role="img" aria-label="Error">!</span> Deskripsi fasilitas wajib diisi.
        </div>
    </div>

    <div>
        <label for="image" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Foto Arena (Opsional)</label>
        <span id="court-image-hint" class="field-hint">Format JPEG, PNG, JPG, atau WEBP maksimal 2 MB.</span>
        @if(isset($court) && $court->image)
            <div class="mb-3 flex items-center gap-4 bg-[#091917] border border-white/10 p-3 rounded-xl">
                <img src="{{ asset('storage/' . $court->image) }}" alt="{{ $court->name }}" class="w-24 h-16 object-cover rounded-lg border border-white/10">
                <div class="text-xs text-[#93ABA6]">
                    <span class="text-white font-semibold block">Foto tersimpan saat ini</span>
                    Unggah file baru jika ingin menggantinya.
                </div>
            </div>
        @endif
        <input
            type="file"
            id="image"
            name="image"
            accept="image/jpeg,image/png,image/jpg,image/webp"
            aria-describedby="court-image-hint"
            class="club-input file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-white file:text-[#0D211F] hover:file:bg-[#C8EE5A] file:cursor-pointer"
        >
    </div>

    <div class="pt-4 border-t border-white/10 flex flex-wrap items-center gap-3">
        <button type="submit" class="px-7 py-3 rounded-full bg-white text-[#0D211F] hover:bg-[#C8EE5A] font-bold text-xs uppercase tracking-wider transition cursor-pointer">
            {{ $submitLabel ?? 'Simpan Arena' }}
        </button>
        <a href="{{ route('admin.courts.index') }}" class="px-6 py-3 rounded-full border border-white/20 hover:border-white/50 text-[#C3D2CF] hover:text-white text-xs font-semibold uppercase tracking-wider transition">
            Batal
        </a>
    </div>
</div>
