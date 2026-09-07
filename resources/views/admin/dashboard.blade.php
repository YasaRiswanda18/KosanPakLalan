<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Kosan Pak Lalan</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
   <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAFAFA;
        }

        /* Smooth Fade In Animation */
        .animate-fade-in {
            animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delay-1 { animation-delay: 50ms; }
        .delay-2 { animation-delay: 100ms; }
        .delay-3 { animation-delay: 150ms; }
        .delay-4 { animation-delay: 200ms; }

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

        /* Smooth Active Status Badge Pulse & Glow */
        @keyframes statusPulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
                transform: scale(1);
            }
            50% {
                box-shadow: 0 0 0 5px rgba(16, 185, 129, 0);
                transform: scale(1.03);
            }
        }
        .animate-active-badge {
            animation: statusPulse 2.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
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
        </aside>

        <!-- ========================================== -->
        <!-- KONTEN UTAMA -->
        <!-- ========================================== -->
        <main class="flex-1 flex flex-col h-screen relative z-10 overflow-hidden min-w-0">
            
            <!-- Topbar (Glass Header) -->
            <header class="h-20 bg-white/85 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-6 sm:px-8 z-30 sticky top-0">
                
                <div class="flex items-center gap-4">
                    <!-- Hamburger Toggle Button -->
                    <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    <!-- Breadcrumb / Title -->
                    <div>
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                            <span class="text-slate-700">Admin</span>
                            <span>/</span>
                            <span class="text-slate-700">Dashboard</span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight leading-tight mt-0.5">Ringkasan Operasional Kos</h2>
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
                                    {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
                                </div>
                            @endif
                            <div class="hidden sm:flex flex-col text-left">
                                <span class="text-xs font-bold text-slate-900 leading-tight">{{ Auth::user()->name ?? 'Pak Lalan' }}</span>
                                <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Administrator</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profilDropdown" class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200/80 overflow-hidden hidden opacity-0 transition-all duration-200 transform origin-top-right scale-95 z-50">
                            <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Masuk Sebagai</p>
                                <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                                <p class="text-xs text-slate-500 truncate mt-0.5">&#64;{{ Auth::user()->username ?? 'admin_lalan' }}</p>
                            </div>
                            
                            <div class="p-2">
                                <a href="{{ route('admin.profil.index') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 hover:bg-slate-50 rounded-xl transition-colors">
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
                
                <!-- HEADER BANNER -->
               <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-md animate-fade-in">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-semibold uppercase tracking-wider mb-2 border border-emerald-200/60">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Periode Aktif: {{ $bulanIni ?? 'Agustus 2026' }}
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-1">Selamat Datang, {{ Auth::user()->name ?? 'Pak Lalan' }}</h1>
                    <p class="text-sm text-slate-500 max-w-xl leading-relaxed">
                        Pantau tingkat keterisian kamar, status pembayaran uang sewa, dan laporan keluhan fasilitas kosan secara terpadu.
                    </p>
                </div>

                <!-- 3 KARTU STATISTIK MINIMALIS (Diperlebar) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    
                    <!-- 1. Penghuni Aktif -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Penghuni Aktif</span>
                            <div class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-center text-slate-700 group-hover:scale-110 group-hover:bg-slate-900 group-hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <h4 class="count-up text-3xl font-extrabold text-slate-900 tracking-tight" data-target="{{ $penghuniAktif }}">0</h4>
                            <span class="text-xs text-slate-400 font-medium">Orang</span>
                        </div>
                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Status Kamar</span>
                            <span class="font-semibold text-slate-700">Terdaftar Resmi</span>
                        </div>
                    </div>

                        <!-- 2. Kamar Terisi -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kamar Terisi</span>
                            
                            <!-- Ikon Warna Biru Solid Permanen Tanpa Animasi -->
                            <div class="w-12 h-12 rounded-2xl bg-sky-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Lanjutan isi kodingan angka 4 / 4 Unit dkk di bawahnya... -->
                        <div class="flex items-baseline gap-2">
                            <h4 class="count-up text-3xl font-extrabold text-slate-900 tracking-tight" data-target="{{ $kamarTerisi }}">0</h4>
                            <span class="text-xs text-slate-400 font-medium">/ {{ $totalKamar }} Unit</span>
                        </div>
                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Okupansi</span>
                            <span class="font-semibold text-sky-600">{{ $totalKamar > 0 ? round(($kamarTerisi / $totalKamar) * 100) : 0 }}% Terisi</span>
                        </div>
                    </div>

                    <!-- 3. Kamar Kosong -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kamar Kosong</span>
                            <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-200/60 flex items-center justify-center text-amber-600 group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <h4 class="count-up text-3xl font-extrabold text-amber-600 tracking-tight" data-target="{{ $kamarKosong }}">0</h4>
                            <span class="text-xs text-slate-400 font-medium">Unit Siap Huni</span>
                        </div>
                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Ketersediaan</span>
                            <span class="font-semibold text-amber-600">Dapat Disewa</span>
                        </div>
                    </div>

                </div>

                <!-- BARIS KONTEN TENGAH: KAS MASUK (PINDAHAN) & TABEL PENGHUNI TERBARU -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                 <!-- KARTU TOTAL KAS MASUK + GRAFIK (DARK MODE ESTETIK) -->
                        <div class="bg-slate-900 rounded-3xl p-6 border border-slate-800 shadow-xl shadow-slate-900/20 hover:shadow-2xl hover:shadow-emerald-900/20 transition-all duration-300 relative overflow-hidden group flex flex-col justify-between h-full">
                            
                            <!-- Efek Glow Hijau di Latar Belakang -->
                            <div class="absolute -right-6 -top-6 w-32 h-32 bg-emerald-500/10 blur-3xl rounded-full group-hover:bg-emerald-500/20 transition-all"></div>
                            
                            <div class="flex flex-col flex-1">
                                <!-- Header Card -->
                                <div class="flex items-center justify-between mb-2 relative z-10">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shadow-inner">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6H2.25m0 0v11.25a2.25 2.25 0 002.25 2.25h15m0-15.75H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25zM15.75 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider">Total Kas Masuk</span>
                                    </div>
                                    

                                </div>
                                
                                <!-- Nominal Uang -->
                                <div class="relative z-10">
                                    <h3 class="text-3xl font-extrabold text-white tracking-tight">
                                        Rp {{ number_format($pemasukan, 0, ',', '.') }}
                                    </h3>
                                </div>

                                <!-- CANVAS GRAFIK REVENUE (AMAN GAK KEGANGGU) -->
                                <div class="relative flex-1 w-full mt-4 min-h-[120px] z-10">
                                    <canvas id="revenueChart"></canvas>
                                </div>
                            </div>
                            
                            <!-- Footer Card -->
                            <div class="mt-4 pt-4 border-t border-slate-700/60 flex items-center justify-between text-[11px] relative z-10 shrink-0">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                                    <span class="font-bold text-emerald-400">
                                        {{ \App\Models\Tagihan::where('status', 'Lunas')->count() }} Lunas
                                    </span>
                                </div>
                                <span class="font-medium text-slate-400">Kas Terverifikasi</span>
                            </div>
                        </div>
                    <!-- Tabel Penghuni Terbaru -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md lg:col-span-2 flex flex-col justify-between overflow-hidden">
                        <div class="p-6 sm:p-8 flex items-center justify-between border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-bold text-slate-900 tracking-tight">Daftar Penghuni</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Penghuni yang baru menempati kamar kos</p>
                            </div>
                            <a href="{{ route('admin.penghuni.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 hover:text-slate-900 px-3 py-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                                <span>Lihat Semua</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                            </a>
                        </div>

                        <div class="overflow-x-auto flex-1">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                        <th class="py-3 px-6">Penghuni</th>
                                        <th class="py-3 px-6">Kamar</th>
                                        <th class="py-3 px-6">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-xs font-medium">
                                    @forelse($penghunisTerbaru as $p)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <!-- Nama & Avatar Profil Penghuni -->
                                                <td class="py-3.5 px-6">
                                                    <div class="flex items-center gap-3">
                                                        <!-- CEK FOTO PROFIL -->
                                                        @if($p->user && $p->user->foto_profil)
                                                            <img src="{{ asset('storage/profil/' . $p->user->foto_profil) }}" alt="Profil" class="w-9 h-9 rounded-xl object-cover border border-slate-200/60 shadow-2xs shrink-0 bg-slate-100">
                                                        @else
                                                            <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs shrink-0 border border-slate-200/60 shadow-2xs">
                                                                {{ strtoupper(substr($p->nama, 0, 2)) }}
                                                            </div>
                                                        @endif
                                                        
                                                        <div>
                                                            <span class="font-bold text-slate-900 block text-xs sm:text-sm">{{ $p->nama }}</span>
                                                            <span class="text-[11px] text-slate-400">{{ $p->no_hp ?? '-' }}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Kamar (Mendukung Multi-Kamar) -->
                                                <td class="py-3.5 px-6">
                                                    @if($p->kamars->count() > 0)
                                                        <div class="flex flex-wrap gap-1.5">
                                                            @foreach($p->kamars as $kmr)
                                                                <span class="inline-flex items-center gap-1 font-semibold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200/60 capitalize text-[11px]">
                                                                    {{ Str::startsWith(strtolower(trim($kmr->nomor_kamar)), 'kamar') ? trim($kmr->nomor_kamar) : 'Kamar ' . trim($kmr->nomor_kamar) }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-slate-400 italic">Belum assign</span>
                                                    @endif
                                                </td>
                                        <!-- Status Aktif dengan Animasi Glowing Pulse -->
                                        <td class="py-3.5 px-6">
                                            @if($p->status == 'Aktif')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200/60 animate-active-badge">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium">
                                                    Keluar
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="py-8 text-center text-xs text-slate-400">
                                            Belum ada data penghuni kos yang terdaftar.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- LAPORAN KELUHAN & PENGADUAN PERLU TINDAKAN -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md p-6 sm:p-8 space-y-5">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-200/60 text-amber-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 tracking-tight">Keluhan & Pengaduan Terbaru</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Laporan kerusakan atau fasilitas kos yang membutuhkan penanganan</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.pengaduan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 hover:text-slate-900 px-3 py-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                            <span>Kelola Laporan</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($pengaduanTerbaru as $adu)
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/60 flex flex-col justify-between space-y-3 hover:border-slate-300 transition-colors">
                            <div class="space-y-1.5">
                                <div class="text-[11px] text-slate-400 pt-2 border-t border-slate-200/60 flex items-center justify-between">
                                    <span class="font-medium text-slate-600">
                                        Kamar {{ $adu->penghuni && $adu->penghuni->kamars->count() > 0 ? $adu->penghuni->kamars->pluck('nomor_kamar')->join(', ') : '-' }}
                                    </span>
                                    <span>{{ $adu->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">{{ $adu->deskripsi }}</p>
                            </div>
                            <div class="text-[11px] text-slate-400 pt-2 border-t border-slate-200/60 flex items-center justify-between">
                                <span class="font-medium text-slate-600">Kamar {{ $adu->penghuni && $adu->penghuni->kamar ? $adu->penghuni->kamar->nomor_kamar : '-' }}</span>
                                <span>{{ $adu->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-3 py-6 text-center text-xs text-slate-400 bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                            Tidak ada keluhan aktif yang perlu penanganan saat ini. Kondisi kos kondusif! ✨
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- ========================================== -->
    <!-- JAVASCRIPT LOGIC, COUNT-UP (CHART DIHAPUS) -->
    <!-- ========================================== -->
    <script>
        // Animasi Count-up Angka
        document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll('.count-up');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                let count = 0;
                const speed = 25; 
                const increment = Math.max(1, Math.ceil(target / speed));

                const updateCount = () => {
                    count += increment;
                    if (count < target) {
                        counter.innerText = count;
                        setTimeout(updateCount, 30);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
            });
        });

        // Profile Dropdown Toggle
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

        // CHART.JS KAS MASUK (LINE CHART)
        const revCtx = document.getElementById('revenueChart');
        if (revCtx) {
            new Chart(revCtx, {
                type: 'line',
                data: {
               // 1. UBAH LABELS BULANNYA DI SINI
                    labels: ['Ags', 'Sep', 'Okt', 'Nov', 'Des', 'Jan'], 
                    datasets: [{
                        label: 'Pemasukan',
                        // 2. TARUH VARIABEL PEMASUKAN DI DEPAN (AGUSTUS), SISANYA DUMMY/NOL
                        data: [{{ $pemasukan }}, 0, 0, 0, 0, 0], 
                        borderColor: '#10B981', // Emerald-500
                        backgroundColor: 'rgba(16, 185, 129, 0.1)', // Efek gradient bawah garis
                        borderWidth: 3,
                        pointBackgroundColor: '#10B981',
                        pointBorderColor: '#0F172A',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // Bikin garisnya melengkung smooth
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1E293B',
                            titleColor: '#94A3B8',
                            bodyColor: '#F8FAFC',
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { color: '#64748B', font: { size: 10, family: "'Plus Jakarta Sans', sans-serif" } }
                        },
                        y: {
                            display: false, // Disembunyikan biar desainnya bersih & estetik
                            min: 0
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>