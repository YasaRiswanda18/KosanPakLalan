<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Penghuni - Kosan Pak Lalan</title>
    
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

        <!-- SIDEBAR ADMIN -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-72 bg-white border-r border-slate-200/80 flex flex-col justify-between h-full z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] shadow-xl lg:shadow-none">
            <div class="flex flex-col flex-1 min-h-0">
                <div class="h-20 flex items-center justify-between px-6 border-b border-slate-100">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-bold text-base shadow-sm group-hover:bg-slate-800 transition-colors shrink-0">KL</div>
                        <div class="flex flex-col">
                            <span class="font-bold text-base text-slate-900 tracking-tight leading-none group-hover:text-slate-700 transition-colors">KOSAN LALAN</span>
                            <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mt-1">Portal Admin</span>
                        </div>
                    </a>
                    <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">

                <!-- RUMUS NOTIFIKASI ADMIN -->
                    @php
                        $notifTagihanAdmin = \App\Models\Tagihan::where('status', 'Menunggu Konfirmasi')->count();
                        $notifKeluhanAdmin = \App\Models\Pengaduan::where('status', 'Pending')->count();
                    @endphp
                    
                    <div class="px-3 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Menu Utama</div>

                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.kamar.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.kamar.*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.kamar.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875A2.625 2.625 0 0110.875 13.5h2.25a2.625 2.625 0 012.625 2.625V21M3 21h18M4.5 3h15a1.5 1.5 0 011.5 1.5v16.5H3V4.5A1.5 1.5 0 014.5 3z" /></svg>
                        <span>Manajemen Kamar</span>
                    </a>
                    <a href="{{ route('admin.penghuni.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.penghuni.*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.penghuni.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                        <span>Data Penghuni</span>
                    </a>
                    <a href="{{ route('admin.tagihan.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.tagihan.*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.tagihan.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6H2.25m0 0v11.25a2.25 2.25 0 002.25 2.25h15m0-15.75H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25zM15.75 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span>Tagihan & Kas</span>
                        </div>
                        @if(($notifTagihanAdmin ?? 0) > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-extrabold bg-rose-500 text-white rounded-full shadow-xs">{{ $notifTagihanAdmin }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.pengaduan.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.pengaduan.*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.pengaduan.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>Laporan Keluhan</span>
                        </div>
                        @if(($notifKeluhanAdmin ?? 0) > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-extrabold bg-rose-500 text-white rounded-full animate-pulse shadow-xs">
                                {{ $notifKeluhanAdmin }}
                            </span>
                        @endif
                    </a>

                    <div class="pt-4 px-3 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sistem</div>
                    <a href="{{ route('admin.akun.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.akun.*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.akun.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                        <span>Kelola Akun</span>
                    </a>
                    <a href="{{ route('admin.pengumuman.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.pengumuman.*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.pengumuman.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                        <span>Kelola Pengumuman</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <main class="flex-1 flex flex-col h-screen relative z-10 overflow-hidden min-w-0">
            
            <!-- Topbar -->
            <header class="h-20 bg-white/85 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-6 sm:px-8 z-30 sticky top-0">
                <div class="flex items-center gap-4">
                    <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-700 transition-colors">Dashboard</a>
                            <span>/</span>
                            <span class="text-slate-700">Data Penghuni</span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight leading-tight mt-0.5">Kelola & Direktori Penyewa</h2>
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
                                    {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
                                </div>
                            @endif
                            <div class="hidden sm:flex flex-col text-left">
                                <span class="text-xs font-bold text-slate-900 leading-tight">{{ Auth::user()->name ?? 'Pak Lalan' }}</span>
                                <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Administrator</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </button>

                        <div id="profilDropdown" class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200/80 overflow-hidden hidden transition-all duration-200 z-50">
                            <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Masuk Sebagai</p>
                                <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                                <p class="text-xs text-slate-500 truncate mt-0.5">&#64;{{ Auth::user()->username ?? 'admin_lalan' }}</p>
                            </div>
                            <div class="p-2">
                                <a href="{{ route('admin.profil.index') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 hover:bg-slate-50 rounded-xl transition-colors">
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

            <!-- Scrollable Content Area -->
            <!-- DITAMBAHKAN OVERFLOW-Y-SCROLL BIAR ANTI LOMPAT -->
            <div class="flex-1 overflow-y-scroll p-6 sm:p-8 space-y-6">
                
                @if(session('success_akun'))
                <div id="alertAkun" class="p-6 rounded-3xl bg-slate-900 text-white shadow-xl shadow-slate-900/10 border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-emerald-500/20 text-emerald-300 text-xs font-semibold uppercase tracking-wider mb-2 border border-emerald-500/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span>Akun Login Penghuni Otomatis Dibuat</span>
                        </div>
                        <h3 class="text-xl font-extrabold tracking-tight text-white">Kredensial Login Penghuni Baru</h3>
                        <p class="text-xs text-slate-300 mt-1 max-w-xl leading-relaxed">Berikan informasi akun ini kepada penghuni untuk masuk ke aplikasi kosan Pak Lalan.</p>
                        <div class="mt-4 flex items-center gap-3">
                            <div class="px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 font-mono text-xs text-emerald-400 select-all tracking-wide shadow-inner">
                                {{ session('success_akun') }}
                            </div>
                            <button type="button" onclick="copyAkun('{{ session('success_akun') }}')" id="copyBtn" class="px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-900 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow-xs shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" /></svg>
                                <span id="copyBtnText">Salin Akun</span>
                            </button>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('alertAkun').remove()" class="text-slate-400 hover:text-white p-2 rounded-xl hover:bg-slate-800 transition-colors self-start md:self-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                @endif

                @if(session('success'))
                <div id="alertSuccess" class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-semibold flex items-center justify-between gap-3 shadow-xs animate-fade-in">
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
                <div id="alertErrorValidasi" class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-sm font-semibold shadow-xs flex items-start justify-between gap-3">
                    <div class="flex items-start gap-3">
                        <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center shrink-0 text-sm font-bold shadow-xs">!</span>
                        <div class="flex-1 mt-0.5">
                            <p class="font-bold">Ada beberapa kesalahan validasi:</p>
                            <ul class="mt-1 list-disc list-inside text-xs font-medium text-rose-700 space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('alertErrorValidasi').remove()" class="text-rose-500 hover:text-rose-800 p-1.5 rounded-lg hover:bg-rose-100/60 transition-colors shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                @endif

               <!-- HEADER BANNER & PRIMARY ACTION -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm mb-6">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Data Penghuni Kos</h1>
                        <p class="text-sm text-slate-500 mt-1 max-w-xl leading-relaxed">
                            Pantau kontak darurat penyewa aktif, profesi, tanggal mulai sewa, serta alokasi unit kamar.
                        </p>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-3 shrink-0">
                        <button type="button" onclick="openModal()" class="inline-flex items-center gap-2 px-5 py-3 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            <span>Tambah Penghuni Baru</span>
                        </button>
                    </div>
                </div>

                <!-- TOOLBAR FILTER -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-md flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1 min-w-0">
                        <div class="relative w-full sm:w-80">
                            <input type="text" id="penghuniSearchInput" onkeyup="applyPenghuniFilter()" placeholder="Cari nama, no. HP, atau kamar..." class="w-full pl-9 pr-8 py-2.5 bg-slate-50 border border-slate-200/90 rounded-2xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            <button type="button" id="clearSearchBtn" onclick="clearSearch()" class="hidden absolute right-3 top-2.5 text-slate-400 hover:text-slate-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0">
                            <button type="button" onclick="setProfesiFilter('all')" id="filterProfesiAll" class="profesi-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-white shadow-xs transition-all shrink-0">Semua ({{ $penghunis->count() }})</button>
                            <button type="button" onclick="setProfesiFilter('Mahasiswa')" id="filterProfesiMhs" class="profesi-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0">Mahasiswa ({{ $penghunis->where('pekerjaan', 'Mahasiswa')->count() }})</button>
                            <button type="button" onclick="setProfesiFilter('Karyawan')" id="filterProfesiKaryawan" class="profesi-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0">Karyawan ({{ $penghunis->where('pekerjaan', 'Karyawan')->count() }})</button>
                            <button type="button" onclick="setProfesiFilter('Lainnya')" id="filterProfesiLainnya" class="profesi-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0">Lainnya ({{ $penghunis->whereNotIn('pekerjaan', ['Mahasiswa', 'Karyawan'])->count() }})</button>
                        </div>
                    </div>
                </div>

                <!-- VIEW 1: TABLE -->
                <div id="penghuniTableView" class="bg-white rounded-3xl border border-slate-200/80 shadow-md overflow-hidden">
                    <div class="overflow-x-auto min-h-[450px]">
                        <table id="penghuniTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    <th class="py-4 px-6 w-[30%]">Profil Penghuni</th>
                                    <th class="py-4 px-6 w-[20%]">Kontak WhatsApp</th>
                                    <th class="py-4 px-6 w-[15%]">Profesi</th>
                                    <th class="py-4 px-6 w-[25%]">Unit Kamar</th>
                                    <th class="py-4 px-6 w-[10%] text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @forelse($penghunis as $penghuni)
                                
                                <!-- SETUP DATA JSON UNTUK DETAIL MODAL -->
                                @php
                                    $detailData = [
                                        'nama' => $penghuni->nama,
                                        'nik' => $penghuni->nik,
                                        'nomor_hp' => $penghuni->nomor_hp,
                                        'pekerjaan' => $penghuni->pekerjaan,
                                        'tanggal_masuk' => \Carbon\Carbon::parse($penghuni->tanggal_masuk)->translatedFormat('d F Y'),
                                        'kamars' => $penghuni->kamars->map(function($k) use ($penghuni) {
                                            return [
                                                'id' => $k->id,
                                                'nomor_kamar' => Str::startsWith(strtolower(trim($k->nomor_kamar)), 'kamar') ? trim($k->nomor_kamar) : 'Kamar ' . trim($k->nomor_kamar),
                                                'tipe_kamar' => $k->tipe_kamar,
                                                'harga' => number_format($k->harga, 0, ',', '.'),
                                                'nama_penghuni_asli' => $k->nama_penghuni_asli ?? $penghuni->nama,
                                                'kekerabatan' => $k->kekerabatan ?? 'Penyewa Utama'
                                            ];
                                        })
                                    ];
                                @endphp
                                
                                <tr class="penghuni-table-row hover:bg-slate-50/80 transition-colors"
                                    data-nama="{{ strtolower($penghuni->nama) }}"
                                    data-pekerjaan="{{ $penghuni->pekerjaan }}"
                                    data-search="{{ strtolower($penghuni->nama . ' ' . $penghuni->nomor_hp . ' ' . $penghuni->pekerjaan . ' ' . ($penghuni->kamars->count() > 0 ? $penghuni->kamars->pluck('nomor_kamar')->join(' ') : '')) }}">
                                    
                                    <!-- Elemen Tersembunyi buat nyimpen data JSON aman -->
                                    <span id="detail-data-{{ $penghuni->id }}" class="hidden">{{ json_encode($detailData) }}</span>

                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3.5">
                                            <div class="relative shrink-0">
                                                @if($penghuni->user && $penghuni->user->foto_profil)
                                                    <img src="{{ asset('storage/profil/' . $penghuni->user->foto_profil) }}" alt="{{ $penghuni->nama }}" class="w-10 h-10 rounded-2xl object-cover border border-slate-200 bg-slate-100">
                                                @else
                                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-slate-900 to-slate-800 text-white flex items-center justify-center text-xs font-bold border border-slate-700/50 shrink-0">
                                                        {{ strtoupper(substr($penghuni->nama, 0, 2)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <span class="text-sm font-bold text-slate-900 block leading-tight truncate">{{ $penghuni->nama }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="py-4 px-6">
                                        @php
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $penghuni->nomor_hp);
                                            if (Str::startsWith($cleanPhone, '0')) $cleanPhone = '62' . substr($cleanPhone, 1);
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-800 hover:text-emerald-600 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.861.173.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.043.073.043.419-.101.824z"/></svg>
                                            <span>{{ $penghuni->nomor_hp }}</span>
                                        </a>
                                    </td>

                                    <td class="py-4 px-6">
                                        @if($penghuni->pekerjaan == 'Mahasiswa')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-xl bg-blue-50 text-blue-700 border border-blue-200/80 text-[11px] font-bold">Mahasiswa</span>
                                        @elseif($penghuni->pekerjaan == 'Karyawan')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-xl bg-purple-50 text-purple-700 border border-purple-200/80 text-[11px] font-bold">Karyawan</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 border border-slate-200/80 text-[11px] font-semibold">{{ $penghuni->pekerjaan }}</span>
                                        @endif
                                    </td>
                                    
                                    <td class="py-4 px-6">
                                        @if($penghuni->kamars->count() > 0)
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach($penghuni->kamars as $kmr)
                                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-800 border border-slate-200/60 text-xs font-bold">
                                                        <span>{{ Str::startsWith(strtolower(trim($kmr->nomor_kamar)), 'kamar') ? trim($kmr->nomor_kamar) : 'Kamar ' . trim($kmr->nomor_kamar) }}</span>
                                                        @if($kmr->tipe_kamar == 'VIP')
                                                            <span class="text-[10px] font-bold text-amber-700 bg-amber-100 px-1.5 py-0.5 rounded">VIP</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-xl bg-rose-50 text-rose-700 border border-rose-200 text-xs font-semibold">Belum Kamar</span>
                                        @endif
                                    </td> 
                                    
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Tombol Detail / Lihat Data -->
                                            <button type="button" onclick="openDetailModal({{ $penghuni->id }})" class="p-2 rounded-xl bg-sky-50 hover:bg-sky-600 text-sky-600 hover:text-white border border-sky-200/80 transition-all shadow-2xs" title="Lihat Detail & Daftar Kamar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            </button>

                                            <!-- Tombol Tambah Kamar Sewa (Multi-Kamar) -->
                                            <button type="button" onclick="openTambahKamarModal({{ $penghuni->id }}, '{{ addslashes($penghuni->nama) }}')" class="p-2 rounded-xl bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200/80 transition-all shadow-2xs" title="Tambah Kamar untuk Saudara/Teman">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                            </button>

                                            <!-- Tombol Edit -->
                                            <button type="button" onclick="openEditModal({{ $penghuni->id }}, '{{ addslashes($penghuni->nama) }}', '{{ $penghuni->nik ?? '' }}', '{{ $penghuni->nomor_hp }}', '{{ $penghuni->pekerjaan }}', '{{ $penghuni->kamars->first() ? $penghuni->kamars->first()->id : '' }}', '{{ $penghuni->status }}')" class="p-2 rounded-xl bg-slate-50 hover:bg-slate-900 text-slate-600 hover:text-white border border-slate-200/80 transition-all shadow-2xs" title="Edit Penghuni">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                            </button>
                                            
                                            <!-- Tombol Hapus -->
                                            <button type="button" onclick="openDeleteModal({{ $penghuni->id }}, '{{ addslashes($penghuni->nama) }}')" class="p-2 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200/80 transition-all shadow-2xs" title="Keluarkan Penghuni">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400">Belum ada data penghuni kos terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="noResultsMessage" class="hidden py-16 text-center bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8">
                    <h3 class="text-base font-bold text-slate-900">Penghuni Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-400 mt-1">Tidak ada penyewa yang cocok dengan kriteria pencarian.</p>
                    <button type="button" onclick="clearSearch()" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold">Reset Filter</button>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL OVERLAY -->
    <div id="modalOverlay" onclick="closeAllModals()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden transition-opacity opacity-0 duration-300"></div>
    
    <!-- MODAL TAMBAH -->
    <div id="modalBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-lg hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-5 mb-5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-900 text-white flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.765z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Tambah Penghuni Baru</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Daftarkan penyewa baru dan alokasikan kamar.</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
            
            <form action="{{ route('admin.penghuni.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIK (E-KTP) <span class="text-rose-500">*</span></label>
                    <input type="number" name="nik" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">WhatsApp <span class="text-rose-500">*</span></label>
                        <input type="number" name="nomor_hp" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Profesi <span class="text-rose-500">*</span></label>
                        <select name="pekerjaan" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                            <option value="Mahasiswa">Mahasiswa</option>
                            <option value="Karyawan">Karyawan</option>
                            <option value="Lainnya">Lainnya / Wirausaha</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Masuk <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_masuk" required value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kamar <span class="text-rose-500">*</span></label>
                        <select name="kamar_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                            <option value="" disabled selected>Pilih Kamar...</option>
                            @foreach($kamarKosong as $kamar)
                                <option value="{{ $kamar->id }}">{{ $kamar->nomor_kamar }} (Rp {{ number_format($kamar->harga, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" onclick="closeModal()" class="w-1/3 py-3 px-4 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-700">Batal</button>
                    <button type="submit" class="w-2/3 py-3 px-4 rounded-xl bg-slate-900 text-white text-xs font-semibold">Simpan & Alokasikan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div id="modalEditBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-lg hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-5 mb-5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 border border-slate-200 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Edit Data Penghuni</h3>
                    </div>
                </div>
                <button type="button" onclick="closeEditModal()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
            
            <form id="formEditPenghuni" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" id="editNama" name="nama" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIK (E-KTP) <span class="text-rose-500">*</span></label>
                    <input type="number" id="editNik" name="nik" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">WhatsApp <span class="text-rose-500">*</span></label>
                        <input type="number" id="editHp" name="nomor_hp" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Profesi <span class="text-rose-500">*</span></label>
                        <select id="editPekerjaan" name="pekerjaan" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                            <option value="Mahasiswa">Mahasiswa</option>
                            <option value="Karyawan">Karyawan</option>
                            <option value="Lainnya">Lainnya / Wirausaha</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pindah Kamar (Opsional)</label>
                        <select id="editKamar" name="kamar_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                            <option value="" disabled selected>Pilih Kamar Kosong...</option>
                            @foreach($kamarKosong as $kamar)
                                <option value="{{ $kamar->id }}">{{ $kamar->nomor_kamar }} (Kosong)</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Hunian <span class="text-rose-500">*</span></label>
                        <select id="editStatus" name="status" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold focus:outline-none focus:border-slate-900">
                            <option value="Aktif">Aktif (Menetap)</option>
                            <option value="Keluar">Keluar (Kosongkan Kamar)</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" onclick="closeEditModal()" class="w-1/3 py-3 px-4 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-700">Batal</button>
                    <button type="submit" class="w-2/3 py-3 px-4 rounded-xl bg-slate-900 text-white text-xs font-semibold">Perbarui Penghuni</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL HAPUS PENGHUNI UTAMA -->
    <div id="modalDeleteBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 text-center">
            <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-rose-200/60 shadow-2xs">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
            </div>
            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Hapus Data Penghuni?</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                Yakin ingin menghapus <span id="deleteNamaLabel" class="font-extrabold text-slate-900"></span>? Data penghuni akan dihapus permanen dan semua kamarnya otomatis berstatus Kosong.
            </p>
            <form id="formDeletePenghuni" method="POST" class="flex items-center gap-3 mt-6">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="w-1/2 py-3 px-4 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-700">Batal</button>
                <button type="submit" class="w-1/2 py-3 px-4 rounded-xl bg-rose-600 text-white text-xs font-semibold">Ya, Keluarkan</button>
            </form>
        </div>
    </div>

    <!-- MODAL TAMBAH KAMAR SEWA -->
    <div id="modalTambahKamarBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-lg hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8">
            <div class="flex justify-between items-center pb-5 mb-5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-200/60 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Sewa Kamar Tambahan</h3>
                    </div>
                </div>
                <button type="button" onclick="closeTambahKamarModal()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
            
            <form id="formTambahKamar" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Penanggung Jawab (Penyewa Utama)</label>
                    <input type="text" id="tambahKamarNama" disabled class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-2xl text-sm font-bold text-slate-500 cursor-not-allowed">
                    <p class="text-[10px] text-slate-400 mt-1">Tagihan akan masuk ke akun orang ini.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Kamar Kosong <span class="text-rose-500">*</span></label>
                    <select name="kamar_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                        <option value="" disabled selected>-- Pilih Kamar --</option>
                        @foreach($kamarKosong as $kamar)
                            <option value="{{ $kamar->id }}">{{ $kamar->nomor_kamar }} (Rp {{ number_format($kamar->harga, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Yang Menempati <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_penghuni_asli" required placeholder="Contoh: Anton" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Hubungan <span class="text-rose-500">*</span></label>
                        <input type="text" name="kekerabatan" required placeholder="Contoh: Saudara / Teman" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" onclick="closeTambahKamarModal()" class="w-1/3 py-3 px-4 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-700">Batal</button>
                    <button type="submit" class="w-2/3 py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition-all">Simpan & Alokasikan</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- MODAL DETAIL PENGHUNI (DENGAN TOMBOL EDIT & HAPUS KAMAR) -->
    <div id="modalDetailBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-2xl hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 max-h-[90vh] flex flex-col">
            <div class="flex justify-between items-center pb-5 mb-5 border-b border-slate-100 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 border border-sky-200/60 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Detail Penyewa & Kamar</h3>
                    </div>
                </div>
                <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
            
            <div class="overflow-y-auto flex-1 pr-2">
                <!-- Info Penyewa Utama -->
                <div class="mb-6">
                    <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3">Biodata Penanggung Jawab</h4>
                    <div class="grid grid-cols-2 gap-y-4 gap-x-6 p-4 rounded-2xl bg-slate-50 border border-slate-200/60">
                        <div>
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</span>
                            <span id="detailNama" class="text-sm font-bold text-slate-900"></span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">NIK</span>
                            <span id="detailNik" class="text-sm font-semibold text-slate-700"></span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">No. WhatsApp</span>
                            <span id="detailHp" class="text-sm font-semibold text-slate-700"></span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Profesi</span>
                            <span id="detailPekerjaan" class="text-sm font-semibold text-slate-700"></span>
                        </div>
                        <div class="col-span-2">
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Mulai Sewa</span>
                            <span id="detailTanggal" class="text-sm font-semibold text-slate-700"></span>
                        </div>
                    </div>
                </div>

                <!-- Info Kamar -->
                <div>
                    <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3">Daftar Kamar yang Disewa</h4>
                    <div id="detailKamarList" class="space-y-3">
                        <!-- Card kamar bakal di-render otomatis via JS di sini -->
                    </div>
                </div>
            </div>
            
            <div class="pt-4 border-t border-slate-100 mt-6 shrink-0 text-right">
                <button type="button" onclick="closeDetailModal()" class="py-2.5 px-6 rounded-xl bg-slate-900 text-white text-xs font-semibold shadow-sm hover:shadow-md transition-all">Tutup Detail</button>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT SUB-KAMAR SEWA -->
    <div id="modalEditKamarSewaBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8">
            <div class="flex justify-between items-center pb-5 mb-5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Edit Penghuni Kamar</h3>
                        <p class="text-xs text-slate-400 mt-0.5" id="labelEditKamar">Kamar --</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditKamarSewaModal()" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
            
            <form id="formEditKamarSewa" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Yang Menempati <span class="text-rose-500">*</span></label>
                    <input type="text" id="editKamarNama" name="nama_penghuni_asli" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Hubungan Kekerabatan <span class="text-rose-500">*</span></label>
                    <input type="text" id="editKamarKekerabatan" name="kekerabatan" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:outline-none focus:border-slate-900">
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" onclick="closeEditKamarSewaModal()" class="w-1/3 py-3 px-4 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-700">Batal</button>
                    <button type="submit" class="w-2/3 py-3 px-4 rounded-xl bg-slate-900 text-white text-xs font-semibold">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL HAPUS SUB-KAMAR SEWA -->
    <div id="modalHapusKamarSewaBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 text-center">
            <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-rose-200/60 shadow-2xs">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
            </div>
            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Lepas Kamar Ini?</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                Yakin ingin melepaskan <span id="labelHapusKamar" class="font-extrabold text-slate-900 bg-slate-100 px-2 py-0.5 rounded-md"></span> dari tanggungan penyewa ini? Kamar akan kembali berstatus Kosong.
            </p>
            <form id="formHapusKamarSewa" method="POST" class="flex items-center gap-3 mt-6">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeHapusKamarSewaModal()" class="w-1/2 py-3 px-4 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-700">Batal</button>
                <button type="submit" class="w-1/2 py-3 px-4 rounded-xl bg-rose-600 text-white text-xs font-semibold">Ya, Lepas</button>
            </form>
        </div>
    </div>


    <!-- SCRIPT UTAMA PENGHUNI -->
    <script>
        const overlay = document.getElementById('modalOverlay');
        let currentProfesiFilter = 'all';

        function showModal(modalId) {
            const m = document.getElementById(modalId);
            const content = m.querySelector('.modal-enter, .modal-leave-active, div');
            overlay.classList.remove('hidden');
            m.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                if (content) {
                    content.classList.remove('modal-leave-active', 'modal-leave');
                    content.classList.add('modal-enter-active');
                }
            }, 10);
        }

        function hideModal(modalId) {
            const m = document.getElementById(modalId);
            const content = m.querySelector('.modal-enter-active, .modal-enter, div');
            if(modalId !== 'modalEditKamarSewaBox' && modalId !== 'modalHapusKamarSewaBox') {
                overlay.classList.add('opacity-0');
            }
            if (content) {
                content.classList.remove('modal-enter-active');
                content.classList.add('modal-leave-active');
            }
            setTimeout(() => {
                if(modalId !== 'modalEditKamarSewaBox' && modalId !== 'modalHapusKamarSewaBox') {
                    overlay.classList.add('hidden');
                }
                m.classList.add('hidden');
                if (content) {
                    content.classList.remove('modal-leave-active');
                    content.classList.add('modal-enter');
                }
            }, 200);
        }

        function closeAllModals() {
            closeModal();
            closeEditModal();
            closeDeleteModal();
            closeTambahKamarModal();
            closeDetailModal();
            closeEditKamarSewaModal();
            closeHapusKamarSewaModal();
        }

        function openModal() { showModal('modalBox'); }
        function closeModal() { hideModal('modalBox'); }

        function openEditModal(id, nama, nik, hp, pekerjaan, kamar_id, status) {
            document.getElementById('formEditPenghuni').action = `/admin/penghuni/${id}`;
            document.getElementById('editNama').value = nama;
            document.getElementById('editNik').value = nik;
            document.getElementById('editHp').value = hp;
            document.getElementById('editPekerjaan').value = pekerjaan;
            document.getElementById('editStatus').value = status;
            
            let selectKamar = document.getElementById('editKamar');
            if (!Array.from(selectKamar.options).some(opt => opt.value == kamar_id) && kamar_id) {
                let option = new Option('Kamar Saat Ini (Tetap)', kamar_id, true, true);
                selectKamar.add(option, 0);
            }
            selectKamar.value = kamar_id;
            
            showModal('modalEditBox');
        }
        function closeEditModal() { hideModal('modalEditBox'); }

        function openDeleteModal(id, nama) {
            document.getElementById('formDeletePenghuni').action = `/admin/penghuni/${id}`;
            document.getElementById('deleteNamaLabel').innerText = nama;
            showModal('modalDeleteBox');
        }
        function closeDeleteModal() { hideModal('modalDeleteBox'); }

        function openTambahKamarModal(id, nama) {
            document.getElementById('formTambahKamar').action = `/admin/penghuni/${id}/tambah-kamar`;
            document.getElementById('tambahKamarNama').value = nama;
            showModal('modalTambahKamarBox');
        }
        function closeTambahKamarModal() { hideModal('modalTambahKamarBox'); }

        // FUNGSI SUB-MODAL KAMAR
        function openEditKamarSewaModal(kamarId, nomor, nama, kekerabatan) {
            closeDetailModal(); // Tutup detail dulu biar gak numpuk berantakan
            setTimeout(() => {
                document.getElementById('formEditKamarSewa').action = `/admin/penghuni/kamar/${kamarId}`;
                document.getElementById('editKamarNama').value = nama;
                document.getElementById('editKamarKekerabatan').value = kekerabatan;
                document.getElementById('labelEditKamar').innerText = nomor;
                showModal('modalEditKamarSewaBox');
            }, 300);
        }
        function closeEditKamarSewaModal() { hideModal('modalEditKamarSewaBox'); overlay.classList.add('hidden', 'opacity-0'); }

        function openHapusKamarSewaModal(kamarId, nomor) {
            closeDetailModal();
            setTimeout(() => {
                document.getElementById('formHapusKamarSewa').action = `/admin/penghuni/kamar/${kamarId}`;
                document.getElementById('labelHapusKamar').innerText = nomor;
                showModal('modalHapusKamarSewaBox');
            }, 300);
        }
        function closeHapusKamarSewaModal() { hideModal('modalHapusKamarSewaBox'); overlay.classList.add('hidden', 'opacity-0'); }

        // FUNGSI MODAL DETAIL
        function openDetailModal(id) {
            const rawData = document.getElementById('detail-data-' + id).innerText;
            const data = JSON.parse(rawData);
            
            document.getElementById('detailNama').innerText = data.nama;
            document.getElementById('detailNik').innerText = data.nik;
            document.getElementById('detailHp').innerText = data.nomor_hp;
            document.getElementById('detailPekerjaan').innerText = data.pekerjaan;
            document.getElementById('detailTanggal').innerText = data.tanggal_masuk;
            
            const roomContainer = document.getElementById('detailKamarList');
            roomContainer.innerHTML = '';
            
            if (data.kamars.length === 0) {
                roomContainer.innerHTML = '<div class="text-sm text-slate-500 italic text-center py-6 bg-slate-50 rounded-2xl border border-dashed border-slate-200">Belum ada kamar yang dialokasikan.</div>';
            } else {
                data.kamars.forEach(kamar => {
                    const badgeVIP = kamar.tipe_kamar === 'VIP' ? `<span class="text-[10px] font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded ml-2">★ VIP</span>` : '';
                    
                    const card = `
                    <div class="p-4 rounded-2xl border border-slate-200/80 bg-white hover:border-slate-300 transition-colors flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                        <div>
                            <div class="flex items-center mb-1">
                                <h4 class="text-sm font-extrabold text-slate-900">${kamar.nomor_kamar}</h4>
                                ${badgeVIP}
                            </div>
                            <p class="text-xs text-slate-500 font-medium">Ditempati oleh: <span class="font-bold text-slate-700">${kamar.nama_penghuni_asli}</span> <span class="text-emerald-600 bg-emerald-50 border border-emerald-200/60 px-1.5 py-0.5 rounded ml-1">(${kamar.kekerabatan})</span></p>
                        </div>
                        <div class="flex flex-col sm:items-end gap-2">
                            <div class="text-left sm:text-right">
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Tarif Bulanan</span>
                                <span class="text-sm font-extrabold text-slate-900">Rp ${kamar.harga}</span>
                            </div>
                            <div class="flex items-center gap-1.5 mt-1 sm:mt-0">
                                <button type="button" onclick="openEditKamarSewaModal(${kamar.id}, '${kamar.nomor_kamar}', '${kamar.nama_penghuni_asli}', '${kamar.kekerabatan}')" class="px-2.5 py-1 rounded-md bg-slate-100 hover:bg-slate-900 text-slate-600 hover:text-white text-[10px] font-bold transition-all border border-slate-200">Edit Info</button>
                                <button type="button" onclick="openHapusKamarSewaModal(${kamar.id}, '${kamar.nomor_kamar}')" class="px-2.5 py-1 rounded-md bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white text-[10px] font-bold transition-all border border-rose-100">Lepas</button>
                            </div>
                        </div>
                    </div>
                    `;
                    roomContainer.innerHTML += card;
                });
            }
            showModal('modalDetailBox');
        }
        function closeDetailModal() { hideModal('modalDetailBox'); }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeAllModals();
        });

        function setProfesiFilter(profesi) {
            currentProfesiFilter = profesi;
            applyPenghuniFilter();
            
            const btnAll = document.getElementById('filterProfesiAll');
            const btnMhs = document.getElementById('filterProfesiMhs');
            const btnKaryawan = document.getElementById('filterProfesiKaryawan');
            const btnLainnya = document.getElementById('filterProfesiLainnya');

            const activeClass = 'profesi-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-white shadow-xs transition-all shrink-0';
            const inactiveClass = 'profesi-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0';

            if(btnAll) btnAll.className = (profesi === 'all') ? activeClass : inactiveClass;
            if(btnMhs) btnMhs.className = (profesi === 'Mahasiswa') ? activeClass : inactiveClass;
            if(btnKaryawan) btnKaryawan.className = (profesi === 'Karyawan') ? activeClass : inactiveClass;
            if(btnLainnya) btnLainnya.className = (profesi === 'Lainnya') ? activeClass : inactiveClass;
        }

        function clearSearch() {
            document.getElementById('penghuniSearchInput').value = '';
            setProfesiFilter('all');
        }

        function applyPenghuniFilter() {
            const query = (document.getElementById('penghuniSearchInput').value || '').trim().toLowerCase();
            const tableRows = document.querySelectorAll('.penghuni-table-row');
            let visibleCount = 0;

            const clearBtn = document.getElementById('clearSearchBtn');
            if (query.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }

            tableRows.forEach(row => {
                const searchStr = row.getAttribute('data-search') || '';
                const pekerjaan = row.getAttribute('data-pekerjaan') || '';
                const match1 = query === '' || searchStr.includes(query);
                const match2 = currentProfesiFilter === 'all' || pekerjaan === currentProfesiFilter || (currentProfesiFilter === 'Lainnya' && pekerjaan !== 'Mahasiswa' && pekerjaan !== 'Karyawan');
                
                if (match1 && match2) { row.style.display = ''; visibleCount++; } 
                else { row.style.display = 'none'; }
            });

            const noResults = document.getElementById('noResultsMessage');
            if (visibleCount === 0 && tableRows.length > 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
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

            const alertErrorValidasi = document.getElementById('alertErrorValidasi');
            if (alertErrorValidasi) {
                setTimeout(() => {
                    alertErrorValidasi.style.opacity = '0';
                    alertErrorValidasi.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => alertErrorValidasi.remove(), 500);
                }, 6000);
            }
        });

        function copyAkun(text) {
            navigator.clipboard.writeText(text).then(() => {
                const btnText = document.getElementById('copyBtnText');
                if (btnText) {
                    const prev = btnText.innerText;
                    btnText.innerText = 'Tersalin!';
                    setTimeout(() => { btnText.innerText = prev; }, 2000);
                }
            });
        }

        function toggleDropdown() {
            const dropdown = document.getElementById('profilDropdown');
            if (dropdown.classList.contains('hidden')) { dropdown.classList.remove('hidden'); } 
            else { dropdown.classList.add('hidden'); }
        }
        
        window.addEventListener('click', function(e) {
            const button = document.getElementById('profilButton');
            const dropdown = document.getElementById('profilDropdown');
            if (button && dropdown && !button.contains(e.target) && !dropdown.contains(e.target)) {
                if (!dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            }
        });

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