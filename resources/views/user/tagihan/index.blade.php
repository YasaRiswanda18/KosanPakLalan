<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tagihan Saya - Kosan Pak Lalan</title>
    
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

        /* Modal Transitions */
        .modal-enter {
            opacity: 0;
            transform: scale(0.96) translateY(8px);
        }
        .modal-enter-active {
            opacity: 1;
            transform: scale(1) translateY(0);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .modal-leave {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
        .modal-leave-active {
            opacity: 0;
            transform: scale(0.96) translateY(8px);
            transition: all 0.2s cubic-bezier(0.4, 0, 1, 1);
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
        
        <!-- SIDEBAR BACKDROP -->
        <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity duration-300"></div>

        <!-- SIDEBAR PENGHUNI -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-72 bg-white border-r border-slate-200/80 flex flex-col justify-between h-full z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] shadow-xl lg:shadow-none">
            <div class="flex flex-col flex-1 min-h-0">
                <div class="h-20 flex items-center justify-between px-6 border-b border-slate-100">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-bold text-base shadow-sm group-hover:bg-slate-800 transition-colors shrink-0">KL</div>
                        <div class="flex flex-col">
                            <span class="font-bold text-base text-slate-900 tracking-tight leading-none group-hover:text-slate-700 transition-colors">KOSAN LALAN</span>
                            <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mt-1">Portal Penghuni</span>
                        </div>
                    </a>
                    <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                    @php
                        $notifTagihan = 0;
                        if(isset($penghuni) && $penghuni) {
                            $notifTagihan = \App\Models\Tagihan::where('penghuni_id', $penghuni->id)
                                ->whereIn('status', ['Belum Lunas', 'belum_lunas', 'Ditolak', 'ditolak'])
                                ->count();
                        }
                    @endphp

                    <div class="px-3 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Menu Utama</div>
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        <span>Beranda</span>
                    </a>
                    
                    <a href="{{ route('user.tagihan') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.tagihan*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.tagihan*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6H2.25m0 0v11.25a2.25 2.25 0 002.25 2.25h15m0-15.75H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25zM15.75 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span>Tagihan Saya</span>
                        </div>
                        @if($notifTagihan > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-extrabold bg-rose-500 text-white rounded-full shadow-xs">{{ $notifTagihan }}</span>
                        @endif
                    </a>
                    
                    <a href="{{ route('user.pengaduan') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.pengaduan*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.pengaduan*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                        <span>Lapor Keluhan</span>
                    </a>

                    <a href="{{ route('user.pengumuman') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.pengumuman*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.pengumuman*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" /></svg>
                            <span>Pengumuman</span>
                        </div>
                        @if(isset($jumlahPengumuman) && $jumlahPengumuman > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-extrabold bg-rose-500 text-white rounded-full animate-pulse shadow-xs">{{ $jumlahPengumuman }}</span>
                        @endif
                    </a>

                    <div class="pt-4 px-3 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Akun Anda</div>
                    <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.profile*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.profile*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                        <span>Profil & Keamanan</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <main class="flex-1 flex flex-col h-screen relative z-10 overflow-hidden min-w-0">
            
            <header class="h-20 bg-white/85 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-6 sm:px-8 z-30 sticky top-0">
                <div class="flex items-center gap-4">
                    <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                            <a href="{{ route('user.dashboard') }}" class="hover:text-slate-700 transition-colors">Portal Penghuni</a>
                            <span>/</span>
                            <span class="text-slate-700">Tagihan</span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight leading-tight mt-0.5">Riwayat Pembayaran</h2>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/80 text-xs font-semibold text-slate-600">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                    </div>
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
                                    {{ isset($penghuni) && $penghuni->kamar ? 'Kamar ' . trim(str_ireplace('kamar', '', $penghuni->kamar->nomor_kamar)) : 'Penghuni' }}
                                </span>
                            </div>
                        </button>
                        <div id="profilDropdown" class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200/80 overflow-hidden hidden opacity-0 transition-all duration-200 transform origin-top-right scale-95 z-50">
                            <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Penghuni Kos</p>
                                <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate mt-0.5">&#64;{{ Auth::user()->username ?? 'user_kos' }}</p>
                            </div>
                            <div class="p-2">
                                <a href="{{ route('user.profile') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 hover:bg-slate-50 rounded-xl transition-colors">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                    <span>Pengaturan Profil</span>
                                </a>
                            </div>
                            <div class="p-2 border-t border-slate-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-xl transition-colors">
                                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                                        <span>Keluar (Logout)</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-scroll p-6 sm:p-8 space-y-6">
                
                @if(session('success'))
                <div id="alertSuccess" class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-semibold flex items-center justify-between gap-3 shadow-xs">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-sm font-bold shadow-xs">✓</span>
                        <p>{{ session('success') }}</p>
                    </div>
                    <button type="button" onclick="document.getElementById('alertSuccess').remove()" class="text-emerald-500 hover:text-emerald-800 p-1.5 rounded-lg hover:bg-emerald-100/60 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                @endif

                @if($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-sm font-semibold shadow-xs">
                    <div class="flex items-start gap-3">
                        <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center shrink-0 text-sm font-bold shadow-xs">!</span>
                        <div class="flex-1">
                            <p class="font-bold">Ada beberapa kendala unggah file:</p>
                            <ul class="mt-1 list-disc list-inside text-xs font-medium text-rose-700 space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <!-- HEADER BANNER -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-md flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold uppercase tracking-wider mb-2">
                            <span>Pusat Pembayaran Sewa</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Tagihan & Riwayat</h1>
                        <p class="text-sm text-slate-500 mt-1 max-w-xl leading-relaxed">Cek rincian invoice sewa kos bulanan Anda, kirimkan foto struk transfer untuk verifikasi, dan pantau status pelunasan.</p>
                    </div>

                    <!-- Rekening Box -->
                    <div class="flex flex-wrap items-center gap-3 shrink-0">
                        <div class="px-4 py-3 bg-slate-50 rounded-2xl border border-slate-200/70 flex items-center gap-3">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Bank BCA</span>
                                <span class="font-mono text-xs font-extrabold text-slate-900 select-all">1234 5678 90</span>
                            </div>
                            <button type="button" onclick="copyText('1234567890', this)" class="px-2.5 py-1 rounded-lg bg-white hover:bg-slate-100 text-slate-700 text-[11px] font-bold border border-slate-200 shadow-2xs transition-all">Salin</button>
                        </div>
                        <div class="px-4 py-3 bg-slate-50 rounded-2xl border border-slate-200/70 flex items-center gap-3">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Bank Mandiri</span>
                                <span class="font-mono text-xs font-extrabold text-slate-900 select-all">1370 0123 4567 8</span>
                            </div>
                            <button type="button" onclick="copyText('1370012345678', this)" class="px-2.5 py-1 rounded-lg bg-white hover:bg-slate-100 text-slate-700 text-[11px] font-bold border border-slate-200 shadow-2xs transition-all">Salin</button>
                        </div>
                    </div>
                </div>

                @php
                    $totalSemua = count($tagihans);
                    // Dibuat lebih aman dengan case-insensitive array logic
                    $totalLunas = collect($tagihans)->whereIn('status', ['Lunas', 'lunas'])->count();
                    $totalVerif = collect($tagihans)->whereIn('status', ['Menunggu Konfirmasi', 'menunggu_konfirmasi'])->count();
                    $totalBelum = collect($tagihans)->whereIn('status', ['Belum Lunas', 'belum_lunas'])->count();
                    $totalDitolak = collect($tagihans)->whereIn('status', ['Ditolak', 'ditolak'])->count();
                    $nominalPending = collect($tagihans)->whereIn('status', ['Belum Lunas', 'belum_lunas', 'Ditolak', 'ditolak'])->sum(function($q) { return $q->jumlah_bayar ?? $q->total_tagihan; });
                @endphp

                <!-- STATISTIK KARTU -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Riwayat Tagihan</span>
                                <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-200/60 flex items-center justify-center text-indigo-500 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalSemua }}</h3>
                                <span class="text-xs text-slate-400 font-medium">Bulan Tercatat</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Perlu Dibayar</span>
                                <div class="w-10 h-10 rounded-full bg-rose-50 border border-rose-200/60 flex items-center justify-center text-rose-500 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalBelum + $totalDitolak }}</h3>
                                <span class="text-xs text-slate-400 font-medium">Tagihan Terbuka</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                            <span class="text-slate-500">Nominal:</span>
                            <span class="font-extrabold text-rose-600">Rp {{ number_format($nominalPending, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Diverifikasi</span>
                                <div class="w-10 h-10 rounded-full bg-amber-50 border border-amber-200/60 flex items-center justify-center text-amber-500 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalVerif }}</h3>
                                <span class="text-xs text-slate-400 font-medium">Struk Terkirim</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                            <span class="text-slate-500">Pemeriksaan:</span>
                            @if($totalVerif > 0)
                                <span class="font-bold text-amber-600">Menunggu ACC &rarr;</span>
                            @else
                                <span class="font-semibold text-slate-600">Tidak Ada</span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sudah Lunas</span>
                                <div class="w-10 h-10 rounded-full bg-emerald-50 border border-emerald-200/60 flex items-center justify-center text-emerald-500 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-3xl font-extrabold text-emerald-600 tracking-tight">{{ $totalLunas }}</h3>
                                <span class="text-xs text-slate-400 font-medium">Bulan Lunas</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Status Rekening:</span>
                            <span class="font-semibold text-emerald-600">Terdata Sah</span>
                        </div>
                    </div>
                </div>

                <!-- FILTER & SEARCH -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1 min-w-0">
                        <div class="relative w-full sm:w-80">
                            <input type="text" id="userTagihanSearchInput" onkeyup="applyUserTagihanFilter()" placeholder="Cari periode bulan..." class="w-full pl-9 pr-8 py-2.5 bg-slate-50 border border-slate-200/90 rounded-2xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            <button type="button" id="clearUserSearchBtn" onclick="clearUserSearch()" class="hidden absolute right-3 top-2.5 text-slate-400 hover:text-slate-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0">
                            <button type="button" onclick="setUserStatusFilter('all')" id="btnStatusAll" class="tagihan-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-white shadow-xs transition-all shrink-0">
                                Semua ({{ $totalSemua }})
                            </button>
                            <button type="button" onclick="setUserStatusFilter('belum_lunas')" id="btnStatusBelum" class="tagihan-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0">
                                Belum Lunas ({{ $totalBelum }})
                            </button>
                            <button type="button" onclick="setUserStatusFilter('menunggu_konfirmasi')" id="btnStatusVerif" class="tagihan-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/80 hover:bg-amber-100 transition-all shrink-0 flex items-center gap-1.5">
                                <span>Verifikasi ({{ $totalVerif }})</span>
                            </button>
                            <button type="button" onclick="setUserStatusFilter('lunas')" id="btnStatusLunas" class="tagihan-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0">
                                Lunas ({{ $totalLunas }})
                            </button>
                            @if($totalDitolak > 0)
                            <button type="button" onclick="setUserStatusFilter('ditolak')" id="btnStatusDitolak" class="tagihan-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200/80 transition-all shrink-0">
                                Ditolak ({{ $totalDitolak }})
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- VIEW TABEL -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[1000px] text-left border-collapse table-fixed">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    <th class="py-4 px-6 w-[20%]">Bulan / Periode</th>
                                    <th class="py-4 px-6 w-[20%]">Nominal Sewa</th>
                                    <th class="py-4 px-6 w-[20%] text-center">Status Pembayaran</th>
                                    <th class="py-4 px-6 w-[15%] text-center">Bukti Transfer</th>
                                    <th class="py-4 px-6 w-[25%] text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @forelse($tagihans as $tagihan)
                                @php
                                    // Bikin format status seragam (lowercase + underscore)
                                    $safeStatus = strtolower(str_replace(' ', '_', $tagihan->status));
                                @endphp
                                <tr class="user-tagihan-table-row hover:bg-slate-50/80 transition-colors"
                                    data-status="{{ $safeStatus }}"
                                    data-search="{{ strtolower($tagihan->bulan_tagihan . ' ' . $tagihan->jumlah_bayar . ' ' . $tagihan->catatan . ' ' . $tagihan->status) }}">
                                    
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-2.5">
                                            <span class="font-extrabold text-slate-900 block text-sm">{{ $tagihan->bulan_tagihan }}</span>
                                        </div>
                                        @if($tagihan->catatan)
                                            <span class="text-[11px] text-slate-400 italic block mt-0.5">{{ $tagihan->catatan }}</span>
                                        @endif
                                    </td>
                                    
                                    <td class="py-4 px-6">
                                        <span class="font-extrabold text-slate-900 block text-sm">
                                            Rp {{ number_format($tagihan->jumlah_bayar ?? $tagihan->total_tagihan, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    
                                    <td class="py-4 px-6 text-center">
                                        @if(in_array($safeStatus, ['lunas']))
                                            <div class="flex flex-col items-center gap-1">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-xs font-bold">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    <span>Lunas</span>
                                                </span>
                                            </div>
                                        @elseif(in_array($safeStatus, ['menunggu_konfirmasi', 'menunggu']))
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-700 border border-amber-200/80 text-xs font-bold">
                                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                                <span>Verifikasi</span>
                                            </span>
                                        @elseif(in_array($safeStatus, ['ditolak']))
                                            <div class="flex flex-col items-center gap-1">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-50 text-rose-700 border border-rose-200/80 text-xs font-bold">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    <span>Ditolak</span>
                                                </span>
                                                @if($tagihan->alasan_tolak)
                                                    <span class="text-[10px] text-rose-500 font-medium max-w-[120px] truncate" title="{{ $tagihan->alasan_tolak }}">
                                                        {{ $tagihan->alasan_tolak }}
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-600 border border-slate-200 text-xs font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                <span>Belum Lunas</span>
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="py-4 px-6 text-center">
                                        @if($tagihan->bukti_bayar)
                                            <button type="button" onclick="openPreviewBuktiModal('{{ asset('storage/' . $tagihan->bukti_bayar) }}', '{{ $tagihan->bulan_tagihan }}')" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 px-2.5 py-1 rounded-lg transition-colors">
                                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                <span>Lihat</span>
                                            </button>
                                        @else
                                            <span class="text-[11px] text-slate-400 font-medium">-</span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6 text-right">
                                        @if(in_array($safeStatus, ['belum_lunas']))
                                            <button type="button" onclick="openUploadModal({{ $tagihan->id }}, '{{ $tagihan->bulan_tagihan }}', '{{ number_format($tagihan->jumlah_bayar ?? $tagihan->total_tagihan, 0, ',', '.') }}')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-xs transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                                                <span>Upload Bukti</span>
                                            </button>
                                        @elseif(in_array($safeStatus, ['ditolak']))
                                            <button type="button" onclick="openDetailTolakModal({{ $tagihan->id }}, '{{ $tagihan->bulan_tagihan }}', '{{ addslashes($tagihan->alasan_tolak ?? '') }}')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-xs transition-all">
                                                <span>Upload Ulang</span>
                                            </button>
                                        @else
                                            <span class="text-xs font-semibold text-emerald-600">Proses Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400">
                                        Belum ada riwayat tagihan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="noResultsUserTagihan" class="hidden py-16 text-center bg-white rounded-3xl border border-slate-200/80 shadow-md p-8">
                    <h3 class="text-base font-bold text-slate-900">Tagihan Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-400 mt-1">Tidak ada riwayat tagihan yang cocok dengan kata kunci atau filter.</p>
                </div>

            </div>
        </main>
    </div>

    <!-- MODAL OVERLAY -->
    <div id="modalOverlayGlobal" onclick="closeAllModals()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden transition-opacity opacity-0 duration-300"></div>

    <!-- MODAL UPLOAD BUKTI -->
    <div id="modalUploadBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-5 mb-5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Upload Bukti Transfer</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Periode: <span id="labelBulan" class="font-extrabold text-slate-900"></span></p>
                    </div>
                </div>
                <button type="button" onclick="closeUploadModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <form id="formUploadBukti" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">Nominal:</span>
                    <span id="labelNominalUpload" class="font-extrabold text-slate-900 text-sm"></span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Foto Struk <span class="text-rose-500">*</span></label>
                    <input type="file" name="bukti_bayar" id="inputBuktiBayar" required accept="image/*" onchange="previewUploadImage(this, 'previewImgUpload')" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 cursor-pointer focus:outline-none">
                </div>

                <div id="previewContainerUpload" class="hidden p-2 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <img id="previewImgUpload" src="" alt="Pratinjau Struk" class="w-full h-auto max-h-48 object-contain rounded-xl bg-white mx-auto">
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" onclick="closeUploadModal()" class="w-1/3 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-all">Batal</button>
                    <button type="submit" class="w-2/3 py-3 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition-all">Kirim Bukti Transfer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DETAIL TOLAK & UPLOAD ULANG -->
    <div id="modalDetailTolakBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-5 mb-5 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Bukti Ditolak</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Periode: <span id="labelBulanTolak" class="font-extrabold text-slate-900"></span></p>
                </div>
                <button type="button" onclick="closeDetailTolakModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-xs text-rose-900 space-y-1.5">
                    <span class="font-bold text-rose-950 uppercase tracking-wider block text-[10px]">Catatan Pengelola:</span>
                    <p id="labelAlasan" class="leading-relaxed font-medium"></p>
                </div>

                <form id="formUploadUlang" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kirim Ulang Bukti <span class="text-rose-500">*</span></label>
                        <input type="file" name="bukti_bayar" required accept="image/*" onchange="previewUploadImage(this, 'previewImgUlang')" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-rose-600 file:text-white hover:file:bg-rose-700 cursor-pointer focus:outline-none">
                    </div>
                    <div id="previewContainerUlang" class="hidden p-2 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                        <img id="previewImgUlang" src="" alt="Pratinjau Ulang" class="w-full h-auto max-h-48 object-contain rounded-xl bg-white mx-auto">
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100 mt-6">
                        <button type="button" onclick="closeDetailTolakModal()" class="w-1/3 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-all">Batal</button>
                        <button type="submit" class="w-2/3 py-3 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold transition-all">Kirim Ulang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PREVIEW BUKTI -->
    <div id="modalPreviewBuktiBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 text-center max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Struk Pembayaran</h3>
                    <p class="text-xs text-slate-400 mt-0.5" id="labelPreviewPeriode"></p>
                </div>
                <button type="button" onclick="closePreviewBuktiModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200 mb-5">
                <img id="imgPreviewModal" src="" alt="Bukti Transfer" class="w-full h-auto max-h-80 object-contain rounded-xl bg-white border border-slate-200 mx-auto">
            </div>
            <button type="button" onclick="closePreviewBuktiModal()" class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition-all">Tutup</button>
        </div>
    </div>

    <script>
        const overlayGlobal = document.getElementById('modalOverlayGlobal');
        let currentStatusFilter = 'all';

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = modal.querySelector('.modal-enter, .modal-leave-active, div');
            overlayGlobal.classList.remove('hidden');
            modal.classList.remove('hidden');
            setTimeout(() => {
                overlayGlobal.classList.remove('opacity-0');
                if (content) {
                    content.classList.remove('modal-leave-active', 'modal-leave');
                    content.classList.add('modal-enter-active');
                }
            }, 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = modal.querySelector('.modal-enter-active, .modal-enter, div');
            overlayGlobal.classList.add('opacity-0');
            if (content) {
                content.classList.remove('modal-enter-active');
                content.classList.add('modal-leave-active');
            }
            setTimeout(() => {
                overlayGlobal.classList.add('hidden');
                modal.classList.add('hidden');
                if (content) {
                    content.classList.remove('modal-leave-active');
                    content.classList.add('modal-enter');
                }
            }, 200);
        }

        function closeAllModals() {
            closeUploadModal();
            closeDetailTolakModal();
            closePreviewBuktiModal();
        }

        function openUploadModal(id, bulan, nominal) {
            document.getElementById('formUploadBukti').action = "{{ url('user/tagihan') }}/" + id + "/upload-bukti";
            document.getElementById('labelBulan').innerText = bulan;
            document.getElementById('labelNominalUpload').innerText = 'Rp ' + nominal;
            const previewCont = document.getElementById('previewContainerUpload');
            if (previewCont) previewCont.classList.add('hidden');
            document.getElementById('inputBuktiBayar').value = '';
            openModal('modalUploadBox');
        }

        function closeUploadModal() { closeModal('modalUploadBox'); }

        function openDetailTolakModal(id, bulan, alasan) {
            document.getElementById('formUploadUlang').action = "{{ url('user/tagihan') }}/" + id + "/upload-bukti";
            document.getElementById('labelBulanTolak').innerText = bulan;
            document.getElementById('labelAlasan').innerText = alasan || 'Bukti transfer tidak jelas.';
            const previewCont = document.getElementById('previewContainerUlang');
            if (previewCont) previewCont.classList.add('hidden');
            openModal('modalDetailTolakBox');
        }

        function closeDetailTolakModal() { closeModal('modalDetailTolakBox'); }

        function openPreviewBuktiModal(imgUrl, bulan) {
            document.getElementById('imgPreviewModal').src = imgUrl;
            document.getElementById('labelPreviewPeriode').innerText = 'Periode ' + bulan;
            openModal('modalPreviewBuktiBox');
        }

        function closePreviewBuktiModal() { closeModal('modalPreviewBuktiBox'); }

        function previewUploadImage(input, targetImgId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById(targetImgId);
                    img.src = e.target.result;
                    img.parentElement.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function setUserStatusFilter(status) {
            currentStatusFilter = status;
            const activeClass = 'tagihan-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-white shadow-xs transition-all shrink-0';
            const inactiveClass = 'tagihan-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0';

            document.getElementById('btnStatusAll').className = (status === 'all') ? activeClass : inactiveClass;
            document.getElementById('btnStatusBelum').className = (status === 'belum_lunas') ? activeClass : inactiveClass;
            if (document.getElementById('btnStatusVerif')) document.getElementById('btnStatusVerif').className = (status === 'menunggu_konfirmasi') ? activeClass : inactiveClass;
            document.getElementById('btnStatusLunas').className = (status === 'lunas') ? activeClass : inactiveClass;
            if (document.getElementById('btnStatusDitolak')) document.getElementById('btnStatusDitolak').className = (status === 'ditolak') ? activeClass : inactiveClass;

            applyUserTagihanFilter();
        }

        function clearUserSearch() {
            const input = document.getElementById('userTagihanSearchInput');
            if (input) input.value = '';
            setUserStatusFilter('all');
        }

        function applyUserTagihanFilter() {
            const query = (document.getElementById('userTagihanSearchInput')?.value || '').trim().toLowerCase();
            const clearBtn = document.getElementById('clearUserSearchBtn');
            if (query.length > 0) clearBtn.classList.remove('hidden');
            else clearBtn.classList.add('hidden');

            const rows = document.querySelectorAll('.user-tagihan-table-row');
            let visibleCount = 0;
            rows.forEach(row => {
                const searchStr = row.getAttribute('data-search') || '';
                const status = row.getAttribute('data-status') || '';
                const matchQuery = query === '' || searchStr.includes(query);
                // Biar aman pencocokan JS
                const matchStatus = (currentStatusFilter === 'all') || (status.includes(currentStatusFilter) || currentStatusFilter.includes(status));

                if (matchQuery && matchStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const noResults = document.getElementById('noResultsUserTagihan');
            if (visibleCount === 0 && rows.length > 0) noResults.classList.remove('hidden');
            else noResults.classList.add('hidden');
        }

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

        document.addEventListener("DOMContentLoaded", () => {
            const alertSuccess = document.getElementById('alertSuccess');
            if (alertSuccess) {
                setTimeout(() => {
                    alertSuccess.style.opacity = '0';
                    alertSuccess.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => alertSuccess.remove(), 500);
                }, 5000);
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAllModals();
                const dropdown = document.getElementById('profilDropdown');
                if (dropdown && !dropdown.classList.contains('hidden')) toggleDropdown();
            }
        });

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

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (!sidebar || !backdrop) return;
            if (!sidebar.classList.contains('-translate-x-full')) {
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