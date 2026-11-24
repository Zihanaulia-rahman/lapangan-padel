@extends('layouts.app')

@section('title', 'Masuk — PadelHub Indonesia')

@section('content')
<div class="max-w-md mx-auto px-6 py-14 sm:py-20">
    <div class="bg-[#132B28] border border-white/10 rounded-2xl p-7 sm:p-9 shadow-xl">
        <div class="mb-7">
            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-[#C8EE5A]">Akses Akun</span>
            <h1 class="text-2xl font-bold text-white mt-1.5">Masuk ke PadelHub</h1>
            <p class="text-sm text-[#93ABA6] mt-1">Gunakan akun member atau admin untuk mengelola reservasi.</p>
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

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Email</label>
                <span id="login-email-hint" class="field-hint">Contoh: nama@email.com</span>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    spellcheck="false"
                    enterkeyhint="next"
                    aria-describedby="login-email-hint"
                    data-error="login-email-error"
                    placeholder="nama@email.com"
                    class="club-input"
                >
                <div id="login-email-error" class="field-error">
                    <span role="img" aria-label="Error">!</span> Masukkan alamat email yang valid (contoh: nama@email.com).
                </div>
            </div>

            <div>
                <label for="password" class="block text-xs uppercase tracking-wider text-[#C3D2CF] font-semibold mb-1">Password</label>
                <div class="input-group relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        enterkeyhint="done"
                        data-error="login-password-error"
                        placeholder="Masukkan password"
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
                <div id="login-password-error" class="field-error">
                    <span role="img" aria-label="Error">!</span> Password wajib diisi.
                </div>
            </div>

            <div class="flex items-center justify-between text-xs text-[#C3D2CF]">
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded bg-[#081715] border-white/25 text-[#C8EE5A] focus:ring-[#C8EE5A]">
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-full bg-white text-[#0D211F] hover:bg-[#C8EE5A] font-bold text-sm transition cursor-pointer">
                Masuk
            </button>
        </form>

        <div class="mt-7 pt-5 border-t border-white/10 text-center text-sm text-[#93ABA6]">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-white hover:text-[#C8EE5A] font-semibold underline underline-offset-4 ml-1">Daftar di sini</a>
        </div>
    </div>
</div>
@endsection
