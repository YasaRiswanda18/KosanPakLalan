<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Keluhan - Kosan Pak Lalan</title>
    
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
            color: #0F172A;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .modal-enter {
            animation: modalIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        
        .modal-exit {
            animation: modalOut 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes modalIn {
            0% { opacity: 0; transform: scale(0.95) translateY(10px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        @keyframes modalOut {
            0% { opacity: 1; transform: scale(1) translateY(0); }
            100% { opacity: 0; transform: scale(0.95) translateY(10px); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-1 { animation-delay: 0.05s; }
        .delay-2 { animation-delay: 0.1s; }
        .delay-3 { animation-delay: 0.15s; }

        @keyframes pingBadge {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.08); opacity: 1; }
            100% { transform: scale(1); opacity: 0.8; }
        }

        .animate-active-badge {
            animation: pingBadge 2.5s infinite ease-in-out;
        }

        /* Custom scrollbar */
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
<body class="antialiased min-h-screen flex text-slate-800 bg-[#FAFAFA] selection:bg-slate-900 selection:text-white">

    <div class="flex h-screen w-full overflow-hidden">
        
        <!-- ========================================== -->
        <!-- SIDEBAR ADMIN (MODERN MINIMALIST) -->
        <!-- ========================================== -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-72 bg-white border-r border-slate-200/80 flex flex-col justify-between h-full z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] shadow-xl lg:shadow-none">
            
            <div class="flex flex-col flex-1 min-h-0">
                <!-- Brand Header -->
                <div class="h-20 flex items-center justify-between px-6 border-b border-slate-100">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-bold text-base shadow-sm group-hover:bg-slate-800 transition-colors shrink-0">
                            KL
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-base text-slate-900 tracking-tight leading-none group-hover:text-slate-700 transition-colors">KOSAN LALAN</span>
                            <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mt-1">Portal Admin</span>
                        </div>
                    </a>

                    <!-- Close Button for Mobile -->
                    <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

<!-- Navigasi Menu -->
                <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                    
                    <!-- RUMUS NOTIFIKASI ADMIN -->
                    @php
                        $notifTagihanAdmin = \App\Models\Tagihan::where('status', 'Menunggu Konfirmasi')->count();
                        $notifKeluhanAdmin = \App\Models\Pengaduan::where('status', 'Pending')->count();
                    @endphp

                    <div class="px-3 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        Menu Utama
                    </div>

                    <!-- Dashboard (Aktif) -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    
                    <!-- Manajemen Kamar -->
                    <a href="{{ route('admin.kamar.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.kamar.*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.kamar.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875A2.625 2.625 0 0110.875 13.5h2.25a2.625 2.625 0 012.625 2.625V21M3 21h18M4.5 3h15a1.5 1.5 0 011.5 1.5v16.5H3V4.5A1.5 1.5 0 014.5 3z" />
                        </svg>
                        <span>Manajemen Kamar</span>
                    </a>
                    
                    <!-- Data Penghuni -->
                    <a href="{{ route('admin.penghuni.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.penghuni.*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.penghuni.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        <span>Data Penghuni</span>
                    </a>
                    
                    <!-- Tagihan & Kas (DENGAN NOTIFIKASI) -->
                    <a href="{{ route('admin.tagihan.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.tagihan.*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.tagihan.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6H2.25m0 0v11.25a2.25 2.25 0 002.25 2.25h15m0-15.75H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25zM15.75 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Tagihan & Kas</span>
                        </div>
                        @if($notifTagihanAdmin > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-extrabold bg-rose-500 text-white rounded-full animate-pulse shadow-xs">
                                {{ $notifTagihanAdmin }}
                            </span>
                        @endif
                    </a>

                    <!-- Laporan Keluhan (DENGAN NOTIFIKASI) -->
                    <a href="{{ route('admin.pengaduan.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.pengaduan.*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.pengaduan.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>Laporan Keluhan</span>
                        </div>
                        @if($notifKeluhanAdmin > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-extrabold bg-rose-500 text-white rounded-full animate-pulse shadow-xs">
                                {{ $notifKeluhanAdmin }}
                            </span>
                        @endif
                    </a>

                    <div class="pt-4 px-3 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        Sistem
                    </div>

                    <!-- Kelola Akun -->
                    <a href="{{ route('admin.akun.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.akun.*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.akun.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Kelola Akun</span>
                    </a>

                    <!-- Kelola Pengumuman -->
                    <a href="{{ route('admin.pengumuman.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.pengumuman.*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.pengumuman.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <span>Kelola Pengumuman</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Backdrop for mobile drawer -->
        <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-20 hidden md:hidden transition-opacity"></div>

        <!-- ========================================== -->
        <!-- KONTEN UTAMA -->
        <!-- ========================================== -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            
            <!-- Topbar (Glass Header) -->
            <header class="h-20 glass-header border-b border-slate-200/80 flex items-center justify-between px-4 sm:px-8 z-10 shrink-0">
                <div class="flex items-center gap-3">
                    <button type="button" onclick="toggleSidebar()" class="p-2 rounded-xl text-slate-600 hover:bg-slate-100 md:hidden transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-slate-400">Admin</span>
                            <span class="text-xs text-slate-300">/</span>
                            <span class="text-xs font-semibold text-slate-700">Laporan Keluhan</span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">Kotak Pengaduan Penghuni</h2>
                    </div>
                </div>

                <!-- Right Header Elements -->
                <div class="flex items-center gap-3">
                    <!-- Live Time & Date Badge -->
                    <div class="hidden lg:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100/80 border border-slate-200/60 text-xs font-semibold text-slate-600">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button type="button" onclick="toggleDropdown()" id="profilButton" class="flex items-center gap-2.5 p-1.5 pr-3 rounded-2xl bg-white border border-slate-200/80 shadow-xs hover:border-slate-300 hover:shadow-sm transition-all focus:outline-none">
                            <div class="w-8 h-8 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                @if(Auth::user()->foto_profil)
                                    <img src="{{ asset('storage/profil/' . Auth::user()->foto_profil) }}" alt="Profil" class="w-full h-full object-cover rounded-xl">
                                @else
                                    {{ substr(Auth::user()->name ?? 'P', 0, 1) }}
                                @endif
                            <div class="hidden sm:flex flex-col text-left">
    <span class="text-xs font-bold text-slate-900 leading-tight">{{ Auth::user()->name ?? 'Pak Lalan' }}</span>
    <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider mt-0.5">Administrator</span>
</div>

                        <div id="profilDropdown" class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden hidden opacity-0 transition-all duration-200 transform origin-top-right scale-95 z-50">
                            <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Masuk sebagai</p>
                                <p class="text-xs font-bold text-slate-800 truncate mt-0.5">{{ Auth::user()->username ?? 'admin_lalan' }}</p>
                            </div>
                            <div class="p-1.5">
                                <a href="{{ route('admin.profil.index') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-colors">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    <span>Pengaturan Profil</span>
                                </a>
                            </div>
                            <div class="p-1.5 border-t border-slate-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-xl transition-colors text-left">
                                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        <span>Keluar (Logout)</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto p-4 sm:p-8 space-y-6">
                <div class="max-w-7xl mx-auto space-y-6">

                    <!-- FLASH ALERT SUCCESS -->
                    @if(session('success'))
                    <div id="flash-banner" class="bg-emerald-50 border border-emerald-200/80 rounded-2xl p-4 flex items-center justify-between shadow-xs animate-fade-in">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold text-sm shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-emerald-900">Aksi Berhasil!</h4>
                                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button type="button" onclick="document.getElementById('flash-banner').remove()" class="text-emerald-500 hover:text-emerald-800 p-1.5 rounded-lg hover:bg-emerald-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    @endif

                    <!-- ========================================== -->
                    <!-- 3 STATISTIC CARDS (MINIMALIST SAAS) -->
                    <!-- ========================================== -->
                    @php
                        $totalKeluhan = $pengaduans->count();
                        $menungguCount = $pengaduans->where('status', 'Menunggu')->count();
                        $diprosesCount = $pengaduans->where('status', 'Diproses')->count();
                        $selesaiCount = $pengaduans->where('status', 'Selesai')->count();
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6">
                        
                        <!-- 1. Total Laporan Masuk -->
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-sm transition-all duration-300 flex flex-col justify-between animate-fade-in delay-1 group">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-2xl bg-slate-900 text-white flex items-center justify-center group-hover:scale-105 transition-transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Laporan</span>
                                </div>
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-[11px] font-bold text-slate-600">Semua Tiket</span>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalKeluhan }}</h3>
                                <p class="text-xs text-slate-500 font-medium">Rekapitulasi seluruh pengaduan penghuni</p>
                            </div>
                        </div>

                        <!-- 2. Menunggu & Diproses (Pending Actions) -->
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-sm transition-all duration-300 flex flex-col justify-between animate-fade-in delay-2 group">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-2xl bg-amber-500 text-white flex items-center justify-center group-hover:scale-105 transition-transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Perlu Tindakan</span>
                                </div>
                                <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 border border-amber-200/60 text-[11px] font-bold text-amber-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    <span>Aktif</span>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-3xl font-extrabold text-amber-600 tracking-tight">{{ $menungguCount + $diprosesCount }}</h3>
                                <p class="text-xs text-slate-500 font-medium">
                                    <span class="font-bold text-slate-700">{{ $menungguCount }}</span> Menunggu &bull; <span class="font-bold text-slate-700">{{ $diprosesCount }}</span> Sedang Diproses
                                </p>
                            </div>
                        </div>

                        <!-- 3. Selesai Ditangani -->
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-sm transition-all duration-300 flex flex-col justify-between animate-fade-in delay-3 group">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-2xl bg-emerald-500 text-white flex items-center justify-center group-hover:scale-105 transition-transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Selesai Ditangani</span>
                                </div>
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-[11px] font-bold text-emerald-700">Tuntas</span>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-3xl font-extrabold text-emerald-600 tracking-tight">{{ $selesaiCount }}</h3>
                                <p class="text-xs text-slate-500 font-medium">Perbaikan telah rampung & tuntas</p>
                            </div>
                        </div>

                    </div>

                    <!-- ========================================== -->
                    <!-- TOOLBAR & FILTER BAR -->
                    <!-- ========================================== -->
                    <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-200/80 shadow-xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 animate-fade-in delay-2">
                        
                        <!-- Search Box -->
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>
                            <input type="text" id="liveSearchInput" onkeyup="filterKeluhan()" placeholder="Cari keluhan berdasarkan judul, penghuni, kamar, atau deskripsi..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-xs font-medium text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
                        </div>

                        <!-- Status Filter Tabs -->
                        <div class="flex items-center gap-1.5 p-1 bg-slate-100/80 rounded-2xl overflow-x-auto shrink-0">
                            <button type="button" onclick="setFilterStatus('all', this)" class="filter-tab-btn px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all bg-white text-slate-900 shadow-xs">
                                Semua ({{ $totalKeluhan }})
                            </button>
                            <button type="button" onclick="setFilterStatus('Menunggu', this)" class="filter-tab-btn px-3.5 py-1.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all">
                                Menunggu ({{ $menungguCount }})
                            </button>
                            <button type="button" onclick="setFilterStatus('Diproses', this)" class="filter-tab-btn px-3.5 py-1.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all">
                                Diproses ({{ $diprosesCount }})
                            </button>
                            <button type="button" onclick="setFilterStatus('Selesai', this)" class="filter-tab-btn px-3.5 py-1.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all">
                                Selesai ({{ $selesaiCount }})
                            </button>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- DAFTAR KELUHAN (MODERN SAAS CARDS) -->
                    <!-- ========================================== -->
                    <div id="keluhanContainer" class="space-y-4 animate-fade-in delay-3">
                        @forelse($pengaduans as $item)
                        <div class="keluhan-card bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-7 shadow-xs hover:shadow-md transition-all duration-300 relative group overflow-hidden" 
                             data-status="{{ $item->status }}"
                             data-search="{{ strtolower(($item->judul ?? '') . ' ' . ($item->deskripsi ?? '') . ' ' . ($item->penghuni->nama ?? '') . ' ' . ($item->penghuni->kamar->nomor_kamar ?? '')) }}">
                            
                            <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                                
                                <!-- LEFT: TICKET INFO & PENGHUNI -->
                                <div class="flex-1 space-y-4">
                                    
                                    <!-- Ticket Header Badge & Date -->
                                    <div class="flex flex-wrap items-center gap-2.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 border border-slate-200 text-[11px] font-bold tracking-tight">
                                            #TIKET-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>

                                        <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }} WIB</span>
                                            <span class="text-slate-300">&bull;</span>
                                            <span class="text-slate-500 font-semibold">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                        </div>
                                    </div>

                                    <!-- Tenant & Room Identifier -->
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-slate-900 to-slate-800 text-white flex items-center justify-center text-xs font-bold shadow-xs border border-slate-700/50 shrink-0">
                                            <svg class="w-5 h-5 text-slate-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-900 leading-tight">
                                                {{ $item->penghuni->nama ?? 'Penghuni Telah Dihapus' }}
                                            </h4>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                @if($item->penghuni && $item->penghuni->kamar)
                                                    @php
                                                        $nomorKamarClean = Str::startsWith(strtolower(trim($item->penghuni->kamar->nomor_kamar)), 'kamar') ? trim($item->penghuni->kamar->nomor_kamar) : 'Kamar ' . trim($item->penghuni->kamar->nomor_kamar);
                                                        $tipeKamar = $item->penghuni->kamar->tipe_kamar ?? 'Standar';
                                                    @endphp
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 border border-slate-200 text-[11px] font-semibold">
                                                        {{ $nomorKamarClean }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md {{ $tipeKamar == 'VIP' ? 'bg-amber-50 text-amber-700 border border-amber-200/80 font-bold' : 'bg-slate-50 text-slate-600 border border-slate-200/60 font-semibold' }} text-[10px]">
                                                        {{ $tipeKamar == 'VIP' ? '★ Tipe VIP' : 'Tipe Standar' }}
                                                    </span>
                                                @else
                                                    <span class="text-[11px] text-slate-400 font-medium">Tanpa Unit Kamar</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Complaint Subject & Description -->
                                    <div class="space-y-2 pt-1">
                                        <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight leading-snug">
                                            {{ $item->judul }}
                                        </h3>
                                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/70 text-xs sm:text-sm text-slate-700 leading-relaxed">
                                            {{ $item->deskripsi }}
                                        </div>
                                    </div>

                                    <!-- PHOTO EVIDENCE IF ATTACHED -->
                                    @if($item->foto)
                                    <div class="pt-2">
                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Lampiran Bukti Foto</span>
                                        <div class="inline-flex items-center gap-3 p-2 rounded-2xl bg-slate-50 border border-slate-200/80 group/photo">
                                            <div class="relative w-24 h-24 rounded-xl overflow-hidden bg-slate-900 shrink-0 cursor-pointer" onclick="openPhotoModal('{{ asset('storage/' . $item->foto) }}', '{{ addslashes($item->judul) }}')">
                                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Bukti Kerusakan" class="w-full h-full object-cover group-hover/photo:scale-110 transition-transform duration-300">
                                                <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover/photo:opacity-100 flex items-center justify-center transition-opacity">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg>
                                                </div>
                                            </div>
                                            <div class="space-y-1 pr-3">
                                                <p class="text-xs font-bold text-slate-800">Foto Kerusakan</p>
                                                <p class="text-[11px] text-slate-400">Klik untuk memperbesar gambar</p>
                                                <button type="button" onclick="openPhotoModal('{{ asset('storage/' . $item->foto) }}', '{{ addslashes($item->judul) }}')" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-900 hover:text-slate-600 transition-colors pt-1">
                                                    <span>Lihat Resolusi Penuh</span>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>

                                <!-- RIGHT: STATUS CONTROL & ACTION BUTTONS -->
                                <div class="lg:w-72 shrink-0 flex flex-col justify-between gap-5 pt-4 lg:pt-0 lg:border-l lg:border-slate-100 lg:pl-6">
                                    
                                    <!-- Current Status Badge Indicator -->
                                    <div class="space-y-2">
                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Status Penanganan</span>
                                        
                                        @if($item->status == 'Menunggu')
                                            <div class="flex items-center gap-2 p-3 rounded-2xl bg-amber-50 border border-amber-200/80 text-amber-800">
                                                <div class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></div>
                                                <div>
                                                    <p class="text-xs font-bold">Menunggu Respon</p>
                                                    <p class="text-[11px] text-amber-600">Laporan belum diproses teknisi</p>
                                                </div>
                                            </div>
                                        @elseif($item->status == 'Diproses')
                                            <div class="flex items-center gap-2 p-3 rounded-2xl bg-blue-50 border border-blue-200/80 text-blue-800">
                                                <div class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-pulse"></div>
                                                <div>
                                                    <p class="text-xs font-bold">Sedang Diproses</p>
                                                    <p class="text-[11px] text-blue-600">Dalam tahap perbaikan fisik</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2 p-3 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800">
                                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                <div>
                                                    <p class="text-xs font-bold">Telah Selesai</p>
                                                    <p class="text-[11px] text-emerald-600">Perbaikan selesai & ditutup</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- FORM UBAH STATUS -->
                                    <div class="space-y-2">
                                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                                            Ubah Status Cepat
                                        </label>
                                        <form action="{{ route('admin.pengaduan.updateStatus', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="relative">
                                                <select name="status" onchange="this.form.submit()" class="w-full pl-3.5 pr-8 py-2.5 bg-slate-50 hover:bg-slate-100/80 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all cursor-pointer appearance-none">
                                                    <option value="Menunggu" {{ $item->status == 'Menunggu' ? 'selected' : '' }}>⏳ Menunggu Respon</option>
                                                    <option value="Diproses" {{ $item->status == 'Diproses' ? 'selected' : '' }}>🛠️ Sedang Diproses</option>
                                                    <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>✅ Selesai Ditangani</option>
                                                </select>
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" /></svg>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- DELETE ACTION BUTTON -->
                                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                        <span class="text-[11px] text-slate-400 font-medium">Hapus Arsip</span>
                                        <button type="button" 
                                                onclick="openDeleteModal('{{ route('admin.pengaduan.destroy', $item->id) }}', '{{ addslashes($item->judul) }}', '{{ addslashes($item->penghuni->nama ?? 'Penghuni') }}')" 
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200/80 font-semibold text-xs transition-all shadow-xs" 
                                                title="Hapus Pengaduan">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                            <span>Hapus Tiket</span>
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </div>
                        @empty
                        <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center shadow-xs">
                            <div class="w-16 h-16 rounded-3xl bg-slate-100 flex items-center justify-center mx-auto mb-4 text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-800">Semua Fasilitas Terpantau Aman</h3>
                            <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Belum ada laporan keluhan yang dikirimkan oleh penghuni kos. Lingkungan kos dalam kondisi prima.</p>
                        </div>
                        @endforelse

                        <!-- NO SEARCH RESULT STATE -->
                        <div id="noSearchState" class="hidden bg-white rounded-3xl border border-slate-200/80 p-12 text-center shadow-xs">
                            <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-800">Tidak ada laporan yang cocok</h4>
                            <p class="text-xs text-slate-400 mt-1">Coba kata kunci lain atau ubah filter status di atas.</p>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <!-- ========================================== -->
    <!-- MODAL OVERLAY & DIALOGS -->
    <!-- ========================================== -->
    <div id="modalOverlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 hidden transition-opacity"></div>

    <!-- 1. MODAL PREVIEW FOTO KERUSAKAN -->
    <div id="modalPhotoBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-2xl hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8">
            
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-slate-100">
                <div>
                    <h3 id="photoModalTitle" class="text-base font-bold text-slate-900 tracking-tight">Foto Bukti Kerusakan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Dokumentasi keluhan fasilitas dari anak kos.</p>
                </div>
                <button type="button" onclick="closeModal('modalPhotoBox')" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="rounded-2xl overflow-hidden bg-slate-900 max-h-[65vh] flex items-center justify-center border border-slate-100">
                <img id="photoModalImg" src="" alt="Bukti Resolusi Penuh" class="max-h-[65vh] w-auto object-contain">
            </div>

            <div class="pt-5 mt-4 border-t border-slate-100 flex items-center justify-between">
                <a id="photoModalDownload" href="" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-xs font-semibold text-slate-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                    <span>Buka Tab Baru</span>
                </a>
                <button type="button" onclick="closeModal('modalPhotoBox')" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-xs font-semibold text-white transition-colors">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- 2. MODAL KONFIRMASI HAPUS PENGADUAN -->
    <div id="modalDeleteBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8">
            
            <div class="flex items-center gap-3.5 mb-5">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-600 flex items-center justify-center font-bold text-xl shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Hapus Tiket Laporan?</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 mb-6 space-y-1.5">
                <p class="text-xs text-slate-500 font-medium">Judul Keluhan:</p>
                <p id="deleteJudul" class="text-xs font-bold text-slate-800 truncate"></p>
                <p class="text-xs text-slate-500 font-medium pt-1">Pelapor:</p>
                <p id="deletePenghuni" class="text-xs font-semibold text-slate-700"></p>
            </div>

            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex items-center gap-3">
                    <button type="button" onclick="closeModal('modalDeleteBox')" class="w-1/2 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="w-1/2 py-3 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-xs font-semibold text-white shadow-xs transition-all">
                        Ya, Hapus
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- ========================================== -->
    <!-- JAVASCRIPT LOGIC & INTERACTIONS -->
    <!-- ========================================== -->
    <script>
        // Modal System
        function openModal(modalId) {
            const overlay = document.getElementById('modalOverlay');
            const modal = document.getElementById(modalId);
            
            overlay.classList.remove('hidden');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            const overlay = document.getElementById('modalOverlay');
            const modal = document.getElementById(modalId);
            
            modal.classList.add('hidden');
            overlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close on backdrop click
        document.getElementById('modalOverlay').addEventListener('click', function() {
            document.querySelectorAll('[id^="modal"]').forEach(el => {
                if (el.id !== 'modalOverlay') el.classList.add('hidden');
            });
            this.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        // Photo Lightbox Modal
        function openPhotoModal(imgUrl, title) {
            document.getElementById('photoModalImg').src = imgUrl;
            document.getElementById('photoModalTitle').innerText = title || 'Foto Bukti Kerusakan';
            document.getElementById('photoModalDownload').href = imgUrl;
            openModal('modalPhotoBox');
        }

        // Delete Modal Confirmation
        function openDeleteModal(actionUrl, judul, penghuni) {
            document.getElementById('deleteForm').action = actionUrl;
            document.getElementById('deleteJudul').innerText = judul;
            document.getElementById('deletePenghuni').innerText = penghuni;
            openModal('modalDeleteBox');
        }

        // Live Search & Tab Filtering
        let activeStatus = 'all';

        function setFilterStatus(status, button) {
            activeStatus = status;
            
            // Tab button styles
            document.querySelectorAll('.filter-tab-btn').forEach(btn => {
                btn.classList.remove('bg-white', 'text-slate-900', 'shadow-xs');
                btn.classList.add('text-slate-600');
            });
            button.classList.remove('text-slate-600');
            button.classList.add('bg-white', 'text-slate-900', 'shadow-xs');

            filterKeluhan();
        }

        function filterKeluhan() {
            const searchVal = document.getElementById('liveSearchInput').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.keluhan-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                const cardSearch = card.getAttribute('data-search') || '';

                const matchesStatus = (activeStatus === 'all' || cardStatus === activeStatus);
                const matchesSearch = (searchVal === '' || cardSearch.includes(searchVal));

                if (matchesStatus && matchesSearch) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const noSearchState = document.getElementById('noSearchState');
            if (noSearchState) {
                if (visibleCount === 0 && cards.length > 0) {
                    noSearchState.classList.remove('hidden');
                } else {
                    noSearchState.classList.add('hidden');
                }
            }
        }

        // Profile Dropdown
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
</body>
</html>