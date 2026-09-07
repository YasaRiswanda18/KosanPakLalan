<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Penghuni - Kosan Pak Lalan</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAFAFA;
        }

        /* Custom Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #F1F5F9;
        }
        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }
    </style>
</head>

<body class="bg-[#FAFAFA] text-slate-800 antialiased selection:bg-slate-900 selection:text-white overflow-hidden min-h-screen">
    
    <div class="flex h-screen w-full overflow-hidden">
        
        <!-- ========================================== -->
        <!-- SIDEBAR BACKDROP (Mobile only) -->
        <!-- ========================================== -->
        <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity duration-300"></div>

        <!-- ========================================== -->
        <!-- SIDEBAR PENGHUNI (MODERN MINIMALIST) -->
        <!-- ========================================== -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-72 bg-white border-r border-slate-200/80 flex flex-col justify-between h-full z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] shadow-xl lg:shadow-none">
            
            <div class="flex flex-col flex-1 min-h-0">
                <!-- Brand Header -->
                <div class="h-20 flex items-center justify-between px-6 border-b border-slate-100">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-bold text-base shadow-sm group-hover:bg-slate-800 transition-colors shrink-0">
                            KL
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-base text-slate-900 tracking-tight leading-none group-hover:text-slate-700 transition-colors">KOSAN LALAN</span>
                            <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mt-1">Portal Penghuni</span>
                        </div>
                    </a>

                    <!-- Close Button for Mobile -->
                    <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigasi Menu Penghuni -->
                <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                    
                    <!-- RUMUS HITUNG NOTIF TAGIHAN -->
                    @php
                        $notifTagihan = 0;
                        if(isset($penghuni) && $penghuni) {
                            $notifTagihan = \App\Models\Tagihan::where('penghuni_id', $penghuni->id)
                                ->whereIn('status', ['Belum Lunas', 'Ditolak'])
                                ->count();
                        }
                    @endphp

                    <div class="px-3 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        Menu Utama
                    </div>

                    <!-- Dashboard / Beranda -->
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        <span>Beranda</span>
                    </a>
                    
                    <!-- Tagihan Saya (DENGAN NOTIF) -->
                    <a href="{{ route('user.tagihan') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.tagihan*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.tagihan*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6H2.25m0 0v11.25a2.25 2.25 0 002.25 2.25h15m0-15.75H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25zM15.75 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Tagihan Saya</span>
                        </div>
                        @if($notifTagihan > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-extrabold bg-rose-500 text-white rounded-full shadow-xs">
                                {{ $notifTagihan }}
                            </span>
                        @endif
                    </a>
                    
                    <!-- Lapor Keluhan -->
                    <a href="{{ route('user.pengaduan') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.pengaduan*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.pengaduan*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <span>Lapor Keluhan</span>
                    </a>

                    <!-- Pengumuman -->
                    <a href="{{ route('user.pengumuman') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.pengumuman*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.pengumuman*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" />
                            </svg>
                            <span>Pengumuman</span>
                        </div>
                        @if(isset($jumlahPengumuman) && $jumlahPengumuman > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-extrabold bg-rose-500 text-white rounded-full animate-pulse shadow-xs">
                                {{ $jumlahPengumuman }}
                            </span>
                        @endif
                    </a>

                    <div class="pt-4 px-3 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        Akun Anda
                    </div>

                    <!-- Profil & Keamanan -->
                    <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.profile*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.profile*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Profil & Keamanan</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- ========================================== -->
        <!-- KONTEN UTAMA -->
        <!-- ========================================== -->
        <main class="flex-1 flex flex-col h-screen relative z-10 overflow-hidden min-w-0">
            
           <!-- Topbar -->
            <header class="h-20 bg-white/85 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-6 sm:px-8 z-30 sticky top-0">
                <div class="flex items-center gap-4">
                    <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                            <a href="{{ route('user.dashboard') }}" class="hover:text-slate-700 transition-colors">Portal Penghuni</a>
                            <span>/</span>
                            <span class="text-slate-700">Beranda</span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight leading-tight mt-0.5">Beranda Utama</h2>
                    </div>
                </div>

                <!-- Right Actions & Profile Dropdown -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Tanggal Hari Ini -->
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/80 text-xs font-semibold text-slate-600">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button type="button" onclick="toggleDropdown()" id="profilButton" class="flex items-center gap-3 p-1.5 sm:px-3 sm:py-2 bg-white hover:bg-slate-50 border border-slate-200/80 rounded-2xl shadow-xs transition-all focus:outline-none">
                            @if(Auth::user()->foto_profil)
                                <img src="{{ asset('storage/profil/' . Auth::user()->foto_profil) }}" alt="Profil" class="w-8 h-8 rounded-xl object-cover border border-slate-200 shrink-0 bg-slate-100">
                            @else
                                <div class="w-8 h-8 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="hidden sm:flex flex-col text-left">
                                <span class="text-xs font-bold text-slate-900 leading-tight">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">
                                    @php
                                        $labelKamarTop = 'Penghuni';
                                        if(isset($penghuni) && $penghuni->kamars->count() > 0) {
                                            $labelKamarTop = $penghuni->kamars->pluck('nomor_kamar')->map(function($k){
                                                return Str::startsWith(strtolower(trim($k)), 'kamar') ? trim($k) : 'Kamar ' . trim($k);
                                            })->join(', ');
                                        }
                                    @endphp
                                    {{ $labelKamarTop }}
                                </span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profilDropdown" class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200/80 overflow-hidden hidden opacity-0 transition-all duration-200 transform origin-top-right scale-95 z-50">
                            <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Penghuni Kos</p>
                                <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate mt-0.5">&#64;{{ Auth::user()->username ?? 'user_kos' }}</p>
                            </div>
                            
                            <div class="p-2">
                                <a href="{{ route('user.profile') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 hover:bg-slate-50 rounded-xl transition-colors">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    <span>Pengaturan Profil</span>
                                </a>
                            </div>
                            
                            <div class="p-2 border-t border-slate-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-xl transition-colors">
                                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                        </svg>
                                        <span>Keluar (Logout)</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto p-6 sm:p-8 space-y-6">
                
                <!-- HERO WELCOME BANNER -->
                <div class="p-6 sm:p-8 rounded-3xl bg-slate-900 text-white shadow-xl shadow-slate-900/10 border border-slate-800 relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="absolute top-0 right-0 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none -mr-20 -mt-20"></div>
                    <div class="absolute bottom-0 left-1/3 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none -mb-20"></div>

                    <div class="relative z-10 max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-emerald-500/20 text-emerald-300 text-xs font-semibold uppercase tracking-wider mb-3 border border-emerald-500/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span>Penghuni Terdaftar Aktif</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                            Halo, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-300 mt-2 leading-relaxed">
                            Selamat datang di portal penghuni Kosan Pak Lalan. Pantau status pembayaran sewa kamar, kelola profil, dan laporkan keluhan fasilitas kos secara langsung.
                        </p>
                    </div>

                    <!-- Room Multi-Badge -->
                    <div class="relative z-10 bg-slate-950/60 border border-slate-800 p-5 rounded-2xl flex flex-col items-start sm:items-end justify-center min-w-[200px] shrink-0">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Unit Kamar Anda</span>
                        <div class="flex flex-wrap gap-1 mt-1 justify-end">
                            @if(isset($penghuni) && $penghuni->kamars->count() > 0)
                                @foreach($penghuni->kamars as $kmr)
                                    <span class="text-sm font-extrabold text-white bg-slate-800 px-2.5 py-1 rounded-lg border border-slate-700">
                                        {{ Str::startsWith(strtolower(trim($kmr->nomor_kamar)), 'kamar') ? trim($kmr->nomor_kamar) : 'Kamar ' . trim($kmr->nomor_kamar) }}
                                        @if($kmr->tipe_kamar == 'VIP')
                                            <span class="text-[9px] text-amber-300 ml-0.5">★ VIP</span>
                                        @endif
                                    </span>
                                @endforeach
                            @else
                                <span class="text-lg font-bold text-slate-400">Belum Ada</span>
                            @endif
                        </div>
                        <span class="text-xs text-slate-400 mt-2">
                            Total Tarif: Rp {{ number_format(isset($penghuni) ? $penghuni->kamars->sum('harga') : 0, 0, ',', '.') }} / bulan
                        </span>
                    </div>
                </div>

                <!-- 4 KARTU STATISTIK & RINGKASAN PENGHUNI -->
                @php
                    $latestTagihan = isset($penghuni) && $penghuni ? \App\Models\Tagihan::where('penghuni_id', $penghuni->id)->latest()->first() : null;
                    $totalTagihanLunas = isset($penghuni) && $penghuni ? \App\Models\Tagihan::where('penghuni_id', $penghuni->id)->where('status', 'Lunas')->count() : 0;
                    $totalKeluhan = isset($penghuni) && $penghuni ? \App\Models\Pengaduan::where('penghuni_id', $penghuni->id)->count() : 0;
                    $keluhanDiproses = isset($penghuni) && $penghuni ? \App\Models\Pengaduan::where('penghuni_id', $penghuni->id)->whereIn('status', ['Pending', 'Proses'])->count() : 0;
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    
                    <!-- 1. Kamar & Jumlah Unit -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Unit Disewa</span>
                                <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-200/60 flex items-center justify-center text-indigo-600 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875A2.625 2.625 0 0110.875 13.5h2.25a2.625 2.625 0 012.625 2.625V21M3 21h18M4.5 3h15a1.5 1.5 0 011.5 1.5v16.5H3V4.5A1.5 1.5 0 014.5 3z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                                    {{ isset($penghuni) ? $penghuni->kamars->count() : 0 }} Unit
                                </h3>
                                <span class="text-xs text-slate-400 font-medium">Kamar Aktif</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Mulai Sewa:</span>
                            <span class="font-semibold text-slate-700">
                                {{ isset($penghuni) && $penghuni->tanggal_masuk ? \Carbon\Carbon::parse($penghuni->tanggal_masuk)->format('d M Y') : '-' }}
                            </span>
                        </div>
                    </div>

                    <!-- 2. Status Tagihan Terakhir -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tagihan Terakhir</span>
                                <div class="w-10 h-10 rounded-2xl bg-emerald-50 border border-emerald-200/60 flex items-center justify-center text-emerald-600 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6H2.25m0 0v11.25a2.25 2.25 0 002.25 2.25h15m0-15.75H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25zM15.75 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            
                            @if($latestTagihan)
                                <div class="flex items-center gap-2">
                                    @if($latestTagihan->status == 'Lunas')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-xs font-bold shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Lunas
                                        </span>
                                    @elseif($latestTagihan->status == 'Menunggu Konfirmasi')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-amber-50 text-amber-700 border border-amber-200/80 text-xs font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Sedang Diverifikasi
                                        </span>
                                    @elseif($latestTagihan->status == 'Ditolak')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-rose-50 text-rose-700 border border-rose-200/80 text-xs font-bold">
                                            Bukti Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-rose-50 text-rose-700 border border-rose-200/80 text-xs font-bold">
                                            Belum Dibayar
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-xs font-semibold text-slate-400">Belum Ada Tagihan</span>
                            @endif
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                            <span class="text-slate-500">Periode:</span>
                            <span class="font-semibold text-slate-700">{{ $latestTagihan->bulan_tagihan ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- 3. Riwayat Pembayaran -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Riwayat Lunas</span>
                                <div class="w-10 h-10 rounded-2xl bg-blue-50 border border-blue-200/60 flex items-center justify-center text-blue-600 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalTagihanLunas }}</h3>
                                <span class="text-xs text-slate-400 font-medium">Bulan Terbayar</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                        </div>
                    </div>

                    <!-- 4. Laporan Keluhan Saya -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Laporan Keluhan</span>
                                <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-200/60 flex items-center justify-center text-amber-600 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalKeluhan }}</h3>
                                <span class="text-xs text-slate-400 font-medium">Laporan Dibuat</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                            <span class="text-slate-500">Sedang Ditangani:</span>
                            <span class="font-bold {{ $keluhanDiproses > 0 ? 'text-amber-600' : 'text-slate-700' }}">
                                {{ $keluhanDiproses }} Laporan
                            </span>
                        </div>
                    </div>

                </div>

                <!-- DUA KOLOM: RINCIAN HUNIAN & STATUS PEMBAYARAN CEPAT -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Kolom Kiri (2 Kolom): Info Kamar & Fasilitas -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Kartu Rincian Kamar (Multi-Kamar Support) -->
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-md">
                            <div class="flex items-center justify-between pb-5 mb-5 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-slate-900 text-white flex items-center justify-center shrink-0 shadow-xs">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875A2.625 2.625 0 0110.875 13.5h2.25a2.625 2.625 0 012.625 2.625V21M3 21h18M4.5 3h15a1.5 1.5 0 011.5 1.5v16.5H3V4.5A1.5 1.5 0 014.5 3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-extrabold text-slate-900 tracking-tight">Rincian Unit Kamar & Hunian</h3>
                                        <p class="text-xs text-slate-400 mt-0.5">Daftar seluruh kamar yang disewa di bawah tanggung jawab Anda</p>
                                    </div>
                                </div>
                            </div>

                            @if(isset($penghuni) && $penghuni->kamars->count() > 0)
                                <div class="space-y-3">
                                    @foreach($penghuni->kamars as $kmr)
                                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/60 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                                            <div>
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-sm font-extrabold text-slate-900">
                                                        {{ Str::startsWith(strtolower(trim($kmr->nomor_kamar)), 'kamar') ? trim($kmr->nomor_kamar) : 'Kamar ' . trim($kmr->nomor_kamar) }}
                                                    </span>
                                                    @if($kmr->tipe_kamar == 'VIP')
                                                        <span class="text-[10px] font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded">★ VIP</span>
                                                    @else
                                                        <span class="text-[10px] font-semibold text-slate-600 bg-slate-200/70 px-2 py-0.5 rounded">Standar</span>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-slate-500 font-medium">
                                                    Penghuni Fisik: <span class="font-bold text-slate-700">{{ $kmr->nama_penghuni_asli ?? $penghuni->nama }}</span> 
                                                    @if($kmr->kekerabatan)
                                                        <span class="text-emerald-600 font-bold ml-1">({{ $kmr->kekerabatan }})</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="text-left sm:text-right">
                                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Tarif Bulanan</span>
                                                <span class="text-sm font-extrabold text-emerald-600">Rp {{ number_format($kmr->harga, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Ringkasan Kontak -->
                                <div class="mt-4 p-4 rounded-2xl bg-slate-50 border border-slate-200/60 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Kontak Terdaftar</span>
                                        <span class="text-xs font-bold text-slate-900">{{ $penghuni->nomor_hp ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Profesi Utama</span>
                                        <span class="text-xs font-bold text-slate-900">{{ $penghuni->pekerjaan ?? '-' }}</span>
                                    </div>
                                </div>

                                <!-- Fasilitas Termasuk -->
                                <div class="mt-6 pt-5 border-t border-slate-100">
                                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-3">Fasilitas Termasuk:</span>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 text-xs text-slate-600">
                                        <div class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-100 font-medium">
                                            <span class="text-emerald-500 font-bold">✓</span> Ruangan besar
                                        </div>
                                        <div class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-100 font-medium">
                                            <span class="text-emerald-500 font-bold">✓</span> Lemari & Meja
                                        </div>
                                        <div class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-100 font-medium">
                                            <span class="text-emerald-500 font-bold">✓</span> Air Bersih
                                        </div>
                                        <div class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-100 font-medium">
                                            <span class="text-emerald-500 font-bold">✓</span> Dapur 
                                        </div>
                                        <div class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-100 font-medium">
                                            <span class="text-emerald-500 font-bold">✓</span> Parkir Motor Aman
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                    <p class="text-sm font-semibold text-slate-700">Data unit kamar belum dialokasikan</p>
                                    <p class="text-xs text-slate-400 mt-1">Silakan hubungi Pak Lalan untuk memperbarui penempatan kamar Anda.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Tata Tertib & Info Penting Kos -->
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-md">
                            <div class="flex items-center gap-3 pb-4 mb-4 border-b border-slate-100">
                                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-200/60">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-extrabold text-slate-900">Tata Tertib & Kenyamanan Bersama</h3>
                                    <p class="text-[11px] text-slate-400">Harap diperhatikan demi kenyamanan seluruh warga kos</p>
                                </div>
                            </div>

                            <div class="space-y-3 text-xs text-slate-600">
                                <div class="flex items-start gap-2.5 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                    <span class="font-bold text-slate-900 mt-0.5">1.</span>
                                    <span><strong>Jam Kunjungan Tamu:</strong> Batas tamu luar menginap atau berkunjung adalah maksimal pukul 22.00 WIB.</span>
                                </div>
                                <div class="flex items-start gap-2.5 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                    <span class="font-bold text-slate-900 mt-0.5">2.</span>
                                    <span><strong>Kebersihan Bersama:</strong> Buang sampah pada tempat sampah tertutup yang disediakan di lorong setiap hari.</span>
                                </div>
                                <div class="flex items-start gap-2.5 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                    <span class="font-bold text-slate-900 mt-0.5">3.</span>
                                    <span><strong>Hemat Listrik & Air:</strong> Pastikan mematikan lampu, kran air, dan AC saat keluar meninggalkan kamar kos.</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Kolom Kanan (1 Kolom): Status Pembayaran & Shortcut Cepat -->
                    <div class="space-y-6">
                        
                        <!-- Kartu Rekening & Pembayaran Cepat -->
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-3 pb-4 mb-4 border-b border-slate-100">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200/60">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6H2.25m0 0v11.25a2.25 2.25 0 002.25 2.25h15m0-15.75H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25zM15.75 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-extrabold text-slate-900">Rekening Resmi Kos</h3>
                                        <p class="text-[11px] text-slate-400">Metode transfer pembayaran sewa</p>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <!-- Bank BCA -->
                                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-between">
                                        <div>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">No Dana</span>
                                            <span id="norekBca" class="font-mono text-sm font-extrabold text-slate-900 select-all">082110163205</span>
                                            <span class="text-[11px] text-slate-500 block">a.n. Pak Lalan</span>
                                        </div>
                                        <button type="button" onclick="copyText('1234567890', this)" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200 shadow-2xs transition-all shrink-0">
                                            Salin
                                        </button>
                                    </div>

                                    <!-- Bank Mandiri -->
                                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-between">
                                        <div>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Bank Mandiri</span>
                                            <span id="norekMandiri" class="font-mono text-sm font-extrabold text-slate-900 select-all">1370 0123 4567 8</span>
                                            <span class="text-[11px] text-slate-500 block">a.n. Pak Lalan</span>
                                        </div>
                                        <button type="button" onclick="copyText('1370012345678', this)" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200 shadow-2xs transition-all shrink-0">
                                            Salin
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 pt-4 border-t border-slate-100">
                                <a href="{{ route('user.tagihan') }}" class="w-full py-3 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                                    <span>Upload Bukti Transfer</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                                </a>
                            </div>
                        </div>

                        <!-- Hubungi Pemilik Kos (WhatsApp Direct) -->
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200/60">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.861.173.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.043.073.043.419-.101.824z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-extrabold text-slate-900">Butuh Bantuan Cepat?</h3>
                                    <p class="text-xs text-slate-400">Hubungi Pak Lalan (Pengelola)</p>
                                </div>
                            </div>
                            
                            <p class="text-xs text-slate-500 leading-relaxed mb-4">
                                Untuk kendala mendesak, kebocoran air darurat, atau konfirmasi langsung, hubungi via WhatsApp pengelola.
                            </p>

                            <a href="https://wa.me/6282110163205?text=Halo%20Pak%20Lalan,%20saya%20penghuni%20ingin%20bertanya" target="_blank" class="w-full py-2.5 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white border border-emerald-200/80 font-bold text-xs transition-all flex items-center justify-center gap-1.5">
                                <span>Chat WhatsApp Pak Lalan</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                            </a>
                        </div>

                    </div>

                </div>
                
                <!-- ========================================== -->
                <!-- PENGUMUMAN DARI ADMIN (MADING KOSAN) -->
                <!-- ========================================== -->
                <div class="mt-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-2xl bg-slate-900 text-white flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 013.627-.06m3.627.06a18.03 18.03 0 003.627-.06m3.627.06c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 00-1.44-4.282m-3.102.069C18.423 15.75 18.75 14.883 19 14m-7 1.84c-.253-.962-.584-1.892-.985-2.783m-1.44-4.282A20.845 20.845 0 018.46 4.5m10.08 0a20.845 20.845 0 001.44 4.282" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Siaran Informasi & Pengumuman</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Berita terbaru dan info penting dari pengelola kosan.</p>
                        </div>
                    </div>

                    <!-- Grid Card Pengumuman -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                        @forelse($pengumumans as $p)
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col h-full">
                            
                            <!-- Header Kategori & Waktu -->
                            <div class="flex items-start justify-between mb-4">
                                @if($p->kategori == 'Penting')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-rose-50 text-rose-700 border border-rose-200/80 text-[10px] font-bold uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span> Penting
                                    </span>
                                @elseif($p->kategori == 'Tagihan')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-[10px] font-bold uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tagihan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-sky-50 text-sky-700 border border-sky-200/80 text-[10px] font-bold uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> Info
                                    </span>
                                @endif
                                
                                <span class="text-[10px] font-semibold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">{{ $p->created_at->diffForHumans() }}</span>
                            </div>

                            <!-- Judul & Isi -->
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-slate-900 leading-snug mb-2">{{ $p->judul }}</h4>
                                <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">{{ $p->isi_pengumuman }}</p>
                            </div>
                        </div>
                        @empty
                        <!-- Empty State Kalau Ga Ada Pengumuman -->
                        <div class="col-span-full bg-white rounded-3xl border border-dashed border-slate-300 p-10 text-center shadow-sm">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-center text-slate-400 mx-auto mb-3 shadow-xs">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 013.627-.06m3.627.06a18.03 18.03 0 003.627-.06m3.627.06c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 00-1.44-4.282m-3.102.069C18.423 15.75 18.75 14.883 19 14m-7 1.84c-.253-.962-.584-1.892-.985-2.783m-1.44-4.282A20.845 20.845 0 018.46 4.5m10.08 0a20.845 20.845 0 001.44 4.282" /></svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-900">Belum Ada Pengumuman</h4>
                            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Saat ini belum ada informasi atau tagihan terbaru dari pengelola kosan.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- SCRIPT JS (CLIPBOARD, DROPDOWN, SIDEBAR) -->
    <script>
        // Copy to clipboard
        function copyText(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const prev = btn.innerText;
                btn.innerText = 'Tersalin!';
                btn.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-200');
                setTimeout(() => {
                    btn.innerText = prev;
                    btn.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-200');
                }, 2000);
            });
        }

        // Dropdown Profil
        function toggleDropdown() {
            const dropdown = document.getElementById('profilDropdown');
            if (!dropdown) return;
            
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                setTimeout(() => {
                    dropdown.classList.remove('opacity-0', 'scale-95');
                    dropdown.classList.add('opacity-100', 'scale-100');
                }, 10);
            } else {
                dropdown.classList.remove('opacity-100', 'scale-100');
                dropdown.classList.add('opacity-0', 'scale-95');
                setTimeout(() => { dropdown.classList.add('hidden'); }, 200); 
            }
        }

        window.addEventListener('click', function(e) {
            const button = document.getElementById('profilButton');
            const dropdown = document.getElementById('profilDropdown');
            if (button && dropdown && !button.contains(e.target) && !dropdown.contains(e.target)) {
                if (!dropdown.classList.contains('hidden')) {
                    dropdown.classList.remove('opacity-100', 'scale-100');
                    dropdown.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => { dropdown.classList.add('hidden'); }, 200);
                }
            }
        });

        // Mobile Sidebar Drawer
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (!sidebar || !backdrop) return;

            const isOpen = !sidebar.classList.contains('-translate-x-full');
            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            } else {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>