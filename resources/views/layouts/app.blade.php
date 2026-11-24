<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark">
    <title>@yield('title', 'PadelHub Indonesia — Reservasi Lapangan Padel')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        club: {
                            base: '#0D211F',
                            deep: '#091917',
                            surface: '#132B28',
                            elevated: '#173531',
                            volt: '#C8EE5A',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/app-theme.css') }}">
    <script src="{{ asset('js/app-ui.js') }}" defer></script>
</head>
<body class="bg-[#0D211F] text-[#F5F7F6] antialiased selection:bg-[#C8EE5A] selection:text-[#0D211F] min-h-screen flex flex-col">

    <header class="site-header" id="site-header">
        <div class="header-inner">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-white hover:opacity-90 transition">
                <svg class="w-8 h-8 shrink-0" viewBox="0 0 36 36" fill="none" aria-hidden="true">
                    <rect x="1.5" y="1.5" width="33" height="33" rx="10" stroke="rgba(255,255,255,0.2)" stroke-width="1.5"/>
                    <path d="M12.5 22.5C9.75 19.75 9.75 15.25 12.5 12.5C15.25 9.75 19.75 9.75 22.5 12.5C25.25 15.25 25.25 19.75 22.5 22.5C19.75 25.25 15.25 25.25 12.5 22.5Z" stroke="#FFFFFF" stroke-width="1.8"/>
                    <path d="M12 23L9 26" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="25.5" cy="10.5" r="2.5" fill="#C8EE5A"/>
                </svg>
                <div class="leading-tight">
                    <span class="block text-base font-bold tracking-tight text-white">PadelHub</span>
                    <span class="block text-[10px] tracking-[0.22em] text-[#93ABA6] uppercase font-semibold">Indonesia</span>
                </div>
            </a>

            <nav class="site-nav" aria-label="Utama">
                <button
                    class="menu-button"
                    type="button"
                    popovertarget="site-menu"
                    popovertargetaction="toggle"
                    aria-controls="site-menu"
                >
                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" d="M3 5h14M3 10h14M3 15h14"/>
                    </svg>
                    <span>Menu</span>
                </button>

                <ul id="site-menu" class="site-menu" popover="auto">
                    <li>
                        <a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#lapangan">
                            Lapangan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('booking.create') }}" @if(request()->routeIs('booking.*')) aria-current="page" @endif>
                            Reservasi
                        </a>
                    </li>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li>
                                <a href="{{ route('admin.bookings.index') }}" @if(request()->routeIs('admin.bookings.*')) aria-current="page" @endif>
                                    Kelola Booking
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.courts.index') }}" @if(request()->routeIs('admin.courts.*')) aria-current="page" @endif>
                                    Daftar Lapangan
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <span class="hidden lg:inline text-xs text-[#93ABA6]">
                        Halo, <strong class="text-white font-semibold">{{ Auth::user()->name }}</strong>
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-1.5 rounded-full border border-white/20 hover:border-red-400/60 hover:text-red-200 text-xs font-semibold text-[#C3D2CF] transition cursor-pointer">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-1.5 rounded-full border border-white/25 hover:border-white/60 text-xs sm:text-sm font-medium text-white transition">
                        Masuk / Daftar
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1">
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-6 pt-6" role="alert">
                <div class="bg-red-950/50 border border-red-400/40 text-red-200 px-5 py-3.5 rounded-xl text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-300 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-white/10 bg-[#091917] mt-20">
        <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-xs text-[#93ABA6]">
            <p>&copy; {{ date('Y') }} PadelHub Indonesia. Hak cipta dilindungi.</p>
            <div class="flex flex-wrap items-center gap-6">
                <a href="{{ route('home') }}#lapangan" class="hover:text-white transition">Daftar Lapangan</a>
                <a href="{{ route('booking.create') }}" class="hover:text-white transition">Buat Reservasi</a>
                <a href="{{ route('home') }}#tentang" class="hover:text-white transition">Jam Operasional</a>
            </div>
        </div>
    </footer>

</body>
</html>
