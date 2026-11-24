@extends('layouts.app')

@section('title', 'Daftar Akun — PadelHub Indonesia')

@section('content')
<div class="max-w-md mx-auto px-6 py-14 sm:py-20">
    <div class="bg-[#132B28] border border-white/10 rounded-2xl p-7 sm:p-9 shadow-xl">
        <div class="mb-7">
            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#C8EE5A]">Member Baru</span>
            <h1 class="text-2xl font-bold text-white mt-1.5">Buat Akun PadelHub</h1>
            <p class="text-sm text-[#93ABA6] mt-1">Daftar dalam satu langkah untuk mempermudah pengisian data reservasi.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-950/50 border border-red-400/40 text-red-200 p-4 rounded-xl text-sm" role="alert">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Nama Lengkap</label>
                <span id="reg-name-hint" class="field-hint">Nama akan otomatis dipakai saat memesan lapangan.</span>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    enterkeyhint="next"
                    aria-describedby="reg-name-hint"
                    data-error="reg-name-error"
                    placeholder="Nama lengkap Anda"
                    class="club-input"
                >
                <div id="reg-name-error" class="field-error">
                    <span role="img" aria-label="Error">!</span> Nama lengkap wajib diisi.
                </div>
            </div>

            <div>
                <label for="email" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Email</label>
                <span id="reg-email-hint" class="field-hint">Format: anda@contoh.com</span>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    spellcheck="false"
                    enterkeyhint="next"
                    aria-describedby="reg-email-hint"
                    data-error="reg-email-error"
                    placeholder="nama@email.com"
                    class="club-input"
                >
                <div id="reg-email-error" class="field-error">
                    <span role="img" aria-label="Error">!</span> Masukkan alamat email yang valid.
                </div>
            </div>

            <div>
                <label for="password" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Password</label>
                <span id="reg-password-hint" class="field-hint">Minimal 8 karakter.</span>
                <div class="input-group relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        minlength="8"
                        autocomplete="new-password"
                        enterkeyhint="next"
                        aria-describedby="reg-password-hint"
                        data-error="reg-password-error"
                        placeholder="Minimal 8 karakter"
                        class="club-input pr-16"
                    >
                    <button
                        type="button"
                        data-toggle-password="password"
                        aria-pressed="false"
                        aria-controls="password"
                        class="absolute inset-y-1.5 right-1.5 px-3 rounded-lg text-xs font-semibold text-[#C3D2CF] hover:text-white hover:bg-white/10 transition cursor-pointer"
                    >
                        Lihat
                    </button>
                </div>
                <div id="reg-password-error" class="field-error">
                    <span role="img" aria-label="Error">!</span> Password harus terdiri dari minimal 8 karakter.
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Konfirmasi Password</label>
                <div class="input-group relative">
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        minlength="8"
                        autocomplete="new-password"
                        enterkeyhint="done"
                        data-error="reg-confirm-error"
                        placeholder="Ulangi password"
                        class="club-input pr-16"
                    >
                    <button
                        type="button"
                        data-toggle-password="password_confirmation"
                        aria-pressed="false"
                        aria-controls="password_confirmation"
                        class="absolute inset-y-1.5 right-1.5 px-3 rounded-lg text-xs font-semibold text-[#C3D2CF] hover:text-white hover:bg-white/10 transition cursor-pointer"
                    >
                        Lihat
                    </button>
                </div>
                <div id="reg-confirm-error" class="field-error">
                    <span role="img" aria-label="Error">!</span> Ulangi password minimal 8 karakter.
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-full bg-white text-[#0D211F] hover:bg-[#C8EE5A] font-bold text-sm transition cursor-pointer">
                Buat Akun
            </button>
        </form>

        <div class="mt-7 pt-5 border-t border-white/10 text-center text-sm text-[#93ABA6]">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-white hover:text-[#C8EE5A] font-semibold underline underline-offset-4 ml-1">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection
