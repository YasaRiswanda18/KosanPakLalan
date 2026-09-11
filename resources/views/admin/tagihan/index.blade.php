<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tagihan & Kas - Kosan Pak Lalan</title>
    
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

        /* Smooth Fade In Animation */
        .animate-fade-in {
            animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .delay-1 { animation-delay: 50ms; }
        .delay-2 { animation-delay: 100ms; }
        .delay-3 { animation-delay: 150ms; }
        .delay-4 { animation-delay: 200ms; }

        /* Smooth Active Status Badge Pulse & Glow */
        @keyframes statusPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.35); transform: scale(1); }
            50% { box-shadow: 0 0 0 5px rgba(16, 185, 129, 0); transform: scale(1.02); }
        }
        .animate-active-badge {
            animation: statusPulse 2.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Modal Transitions */
        .modal-enter { opacity: 0; transform: scale(0.96) translateY(8px); }
        .modal-enter-active { opacity: 1; transform: scale(1) translateY(0); transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); }
        .modal-leave { opacity: 1; transform: scale(1) translateY(0); }
        .modal-leave-active { opacity: 0; transform: scale(0.96) translateY(8px); transition: all 0.2s cubic-bezier(0.4, 0, 1, 1); }

        /* Custom Modern Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #F1F5F9; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
    </style>
</head>

<body class="bg-[#FAFAFA] text-slate-800 antialiased selection:bg-slate-900 selection:text-white overflow-hidden min-h-screen">
    
    <div class="flex h-screen w-full overflow-hidden">
        
        <!-- SIDEBAR BACKDROP (Mobile only) -->
        <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity duration-300"></div>

        <!-- SIDEBAR ADMIN -->
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
                    <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Navigasi Menu -->
                <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                    @php
                        $notifTagihanAdmin = \App\Models\Tagihan::where('status', 'Menunggu Konfirmasi')->count();
                        $notifKeluhanAdmin = \App\Models\Pengaduan::where('status', '!=', 'Selesai')->count();
                    @endphp

                    <div class="px-3 pb-2 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        Menu Utama
                    </div>

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
                        @if($notifTagihanAdmin > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-extrabold bg-rose-500 text-white rounded-full animate-pulse shadow-xs">
                                {{ $notifTagihanAdmin }}
                            </span>
                        @endif
                    </a>

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
            
            <!-- Topbar (Glass Header) -->
            <header class="h-20 bg-white/85 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-6 sm:px-8 z-30 sticky top-0">
                <div class="flex items-center gap-4">
                    <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                    </button>
                    <div>
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-700 transition-colors">Dashboard</a>
                            <span>/</span>
                            <span class="text-slate-700">Tagihan & Kas</span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight leading-tight mt-0.5">Keuangan & Penagihan</h2>
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

                        <div id="profilDropdown" class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200/80 overflow-hidden hidden opacity-0 transition-all duration-200 transform origin-top-right scale-95 z-50">
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

                @if(session('error'))
                <div id="alertError" class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-sm font-semibold flex items-center justify-between gap-3 shadow-xs animate-fade-in">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center shrink-0 text-sm font-bold shadow-xs">!</span>
                        <p>{{ session('error') }}</p>
                    </div>
                    <button type="button" onclick="document.getElementById('alertError').remove()" class="text-rose-500 hover:text-rose-800 p-1.5 rounded-lg hover:bg-rose-100/60 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                @endif

                @if($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-sm font-semibold shadow-xs animate-fade-in">
                    <div class="flex items-start gap-3">
                        <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center shrink-0 text-sm font-bold shadow-xs">!</span>
                        <div class="flex-1">
                            <p class="font-bold">Ada beberapa kesalahan validasi:</p>
                            <ul class="mt-1 list-disc list-inside text-xs font-medium text-rose-700 space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <!-- HEADER BANNER & ACTION BUTTONS -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm animate-fade-in">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold uppercase tracking-wider mb-2">
                            <span>Manajemen Kas & Tagihan</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Kelola Tagihan & Kas</h1>
                        <p class="text-sm text-slate-500 mt-1 max-w-xl leading-relaxed">
                            Pantau saldo kas masuk, verifikasi bukti transfer anak kos, terbitkan tagihan satuan/massal, dan unduh pembukuan PDF.
                        </p>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-3 shrink-0">
                        <button type="button" onclick="openSatuanModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-semibold shadow-sm transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            <span>Tagihan Satuan</span>
                        </button>

                        <form id="formGenerateTagihan" action="{{ route('admin.tagihan.generate') }}" method="POST" class="inline-block">
                            @csrf
                            <button type="button" onclick="openGenerateModal()" class="inline-flex items-center gap-2 px-5 py-3 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg>
                                <span>Tagih Massal Bulan Ini</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- 4 KARTU STATISTIK KEUANGAN -->
                @php
                    $countLunas = $tagihans->where('status', 'Lunas')->count();
                    $countVerif = $tagihans->where('status', 'Menunggu Konfirmasi')->count();
                    $countBelum = $tagihans->where('status', 'Belum Lunas')->count();
                    $countDitolak = $tagihans->where('status', 'Ditolak')->count();
                    $totalTagihanCount = $tagihans->count();
                    $ratePembayaran = $totalTagihanCount > 0 ? round(($countLunas / $totalTagihanCount) * 100) : 0;
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <!-- 1. Total Kas Masuk -->
                    <div class="bg-slate-900 rounded-3xl p-6 text-white relative overflow-hidden shadow-xl shadow-slate-900/10 border border-slate-800 animate-fade-in delay-1 flex flex-col justify-between group">
                        <div class="absolute top-0 right-0 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none -mr-16 -mt-16"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6H2.25m0 0v11.25a2.25 2.25 0 002.25 2.25h15m0-15.75H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25zM15.75 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </div>
                                    <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">Total Kas Masuk</span>
                                </div>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight transition-opacity duration-200">
                                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="relative z-10 mt-4 pt-3 border-t border-slate-800/80 flex items-center justify-between text-[11px]">
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                <span class="text-emerald-400 font-semibold">{{ $countLunas }} Lunas</span>
                            </div>
                            <span class="text-slate-400">Kas Terverifikasi</span>
                        </div>
                    </div>

                    <!-- 2. Total Tunggakan / Pending -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Tunggakan</span>
                                <div class="w-12 h-12 rounded-2xl border border-rose-100 bg-rose-50 text-rose-500 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                                    Rp {{ number_format($totalTunggakan, 0, ',', '.') }}
                                </h3>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>{{ $countBelum }} Tagihan Terbuka</span>
                            <span class="font-bold text-rose-600">Pending Kas</span>
                        </div>
                    </div>

                    <!-- 3. Butuh Verifikasi Transfer -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Verifikasi Bukti</span>
                                <div class="w-12 h-12 rounded-2xl border border-amber-100 bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="count-up text-3xl font-extrabold text-slate-800 tracking-tight" data-target="{{ $countVerif }}">0</h3>
                                <span class="text-sm text-slate-500 font-medium">Struk Transfer</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                            <span class="text-slate-500">Menunggu ACC</span>
                            @if($countVerif > 0)
                                <span class="font-bold text-amber-600">Perlu Dicek &rarr;</span>
                            @else
                                <span class="font-bold text-emerald-600">Semua Beres</span>
                            @endif
                        </div>
                    </div>

                    <!-- 4. Rasio Pembayaran (Payment Rate %) -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tingkat Bayar</span>
                                <div class="w-12 h-12 rounded-2xl border border-indigo-100 bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $ratePembayaran }}%</h3>
                                <span class="text-sm text-slate-500 font-medium">Terbayar</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 mt-3 overflow-hidden border border-slate-200/50">
                                <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $ratePembayaran }}%"></div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 flex items-center justify-between text-[11px] text-slate-500">
                            <span>{{ $countLunas }} dari {{ $totalTagihanCount }} Tagihan</span>
                            <span class="font-bold text-slate-700">Persentase</span>
                        </div>
                    </div>
                </div>

                <!-- TOOLBAR FILTER, BULAN, PENCARIAN & VIEW TOGGLE -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-md space-y-4 animate-fade-in delay-2">
                    
                    <form action="{{ route('admin.tagihan.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3 items-stretch lg:items-center justify-between">
                        <div class="flex flex-col sm:flex-row gap-3 flex-1 min-w-0">
                            <!-- Search Input -->
                            <div class="relative flex-1">
                                <input type="text" name="search" id="serverSearchInput" value="{{ request('search') }}" onkeyup="applyClientFilter()" placeholder="Cari nama penghuni, kamar, atau catatan..." class="w-full pl-9 pr-8 py-2.5 bg-slate-50 border border-slate-200/90 rounded-2xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                @if(request('search'))
                                    <a href="{{ route('admin.tagihan.index', ['bulan' => request('bulan')]) }}" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </a>
                                @endif
                            </div>

                            <!-- Filter Bulan (Backend GET) -->
                            <div class="w-full sm:w-48 relative">
                                <select name="bulan" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/90 rounded-2xl text-xs font-medium text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all cursor-pointer">
                                    <option value="Semua Bulan">Semua Bulan</option>
                                    @php
                                        $daftarBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                    @endphp
                                    @foreach($daftarBulan as $b)
                                        <option value="{{ $b }}" {{ (request('bulan') == $b || request('bulan') == date('F', strtotime("2026-$loop->iteration-01"))) ? 'selected' : '' }}>
                                            Bulan {{ $b }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl shadow-xs transition-all shrink-0">
                                Filter
                            </button>

                            @if(request('search') || (request('bulan') && request('bulan') != 'Semua Bulan'))
                                <a href="{{ route('admin.tagihan.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-all shrink-0 flex items-center justify-center">
                                    Reset
                                </a>
                            @endif
                        </div>

                        <!-- Cetak PDF & Bersihkan Arsip Lunas -->
                        <div class="flex items-center gap-2.5 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100 shrink-0">
                            <a href="{{ route('admin.tagihan.cetak', ['search' => request('search'), 'bulan' => request('bulan')]) }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white border border-blue-200/80 font-semibold text-xs rounded-xl transition-all shadow-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.049.208-2.158 1.052-2.738a4.5 4.5 0 016.456 0c.844.58 1.292 1.689 1.052 2.738M12 3v13.5m0 0l-3-3m3 3l3-3M3 18.75h18" /></svg>
                                <span>Cetak Rekap PDF</span>
                            </a>
                            <button type="button" onclick="openBersihkanModal('{{ request('bulan') }}')" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-200/80 font-semibold text-xs rounded-xl transition-all shadow-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                <span>Bersihkan Arsip Lunas</span>
                            </button>
                        </div>
                    </form>

                    <!-- Row 2: Status Pills -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-3 border-t border-slate-100">
                        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0 w-full">
                            <button type="button" onclick="setStatusFilter('all')" id="filterStatusAll" class="status-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-white shadow-xs transition-all shrink-0">
                                Semua ({{ $totalTagihanCount }})
                            </button>
                            <button type="button" onclick="setStatusFilter('Menunggu Konfirmasi')" id="filterStatusVerif" class="status-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/80 hover:bg-amber-100 transition-all shrink-0 flex items-center gap-1.5">
                                @if($countVerif > 0)
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>
                                @endif
                                <span>Verifikasi Bukti ({{ $countVerif }})</span>
                            </button>
                            <button type="button" onclick="setStatusFilter('Belum Lunas')" id="filterStatusBelum" class="status-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0">
                                Belum Lunas ({{ $countBelum }})
                            </button>
                            <button type="button" onclick="setStatusFilter('Lunas')" id="filterStatusLunas" class="status-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0">
                                Lunas ({{ $countLunas }})
                            </button>
                            @if($countDitolak > 0)
                            <button type="button" onclick="setStatusFilter('Ditolak')" id="filterStatusDitolak" class="status-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200/80 transition-all shrink-0">
                                Ditolak ({{ $countDitolak }})
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- FULL VIEW: TABEL TAGIHAN & KAS -->
                <!-- ========================================== -->
                <div id="tagihanTableView" class="bg-white rounded-3xl border border-slate-200/80 shadow-md overflow-hidden animate-fade-in delay-3">
                    <div class="overflow-x-auto min-h-[450px]">
                        <table class="w-full min-w-[1000px] text-left border-collapse table-fixed">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    <th class="py-4 px-6 w-[25%]">Penghuni & Unit</th>
                                    <th class="py-4 px-6 w-[15%]">Periode Tagihan</th>
                                    <th class="py-4 px-6 w-[20%]">Nominal Sewa</th>
                                    <th class="py-4 px-6 w-[15%] text-center">Status Pembayaran</th>
                                    <th class="py-4 px-6 w-[25%] text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @forelse($tagihans as $tagihan)
                                <!-- PERBAIKAN SEARCH UNTUK MULTI KAMAR -->
                                <tr class="tagihan-table-row hover:bg-slate-50/80 transition-colors group"
                                    data-status="{{ $tagihan->status }}"
                                    data-search="{{ strtolower(($tagihan->penghuni->nama ?? '') . ' ' . ($tagihan->penghuni->nomor_hp ?? '') . ' ' . ($tagihan->penghuni && $tagihan->penghuni->kamars->count() > 0 ? $tagihan->penghuni->kamars->pluck('nomor_kamar')->join(' ') : '') . ' ' . $tagihan->bulan_tagihan . ' ' . $tagihan->catatan . ' ' . $tagihan->status) }}">
                                    
                                    <!-- Penghuni & Unit -->
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3.5">
                                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-slate-900 to-slate-800 text-white flex items-center justify-center text-xs font-bold shadow-xs border border-slate-700/50 group-hover:scale-105 transition-transform shrink-0">
                                                {{ strtoupper(substr($tagihan->penghuni->nama ?? 'P', 0, 2)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <span class="text-sm font-bold text-slate-900 block leading-tight truncate group-hover:text-slate-700 transition-colors">
                                                    {{ $tagihan->penghuni->nama ?? 'Penghuni Telah Dihapus' }}
                                                </span>
                                                <!-- PERBAIKAN TAMPILAN KAMAR (MULTI-KAMAR) -->
                                                <div class="mt-0.5 flex flex-wrap gap-1">
                                                    @if($tagihan->penghuni && $tagihan->penghuni->kamars->count() > 0)
                                                        @foreach($tagihan->penghuni->kamars as $kmr)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 border border-slate-200/80 text-[10px] font-semibold">
                                                                {{ Str::startsWith(strtolower(trim($kmr->nomor_kamar)), 'kamar') ? trim($kmr->nomor_kamar) : 'Kamar ' . trim($kmr->nomor_kamar) }}
                                                                @if($kmr->tipe_kamar == 'VIP')
                                                                    <span class="text-[9px] font-bold text-amber-700 bg-amber-100 px-1 py-0.5 rounded ml-1">VIP</span>
                                                                @endif
                                                            </span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-[10px] text-slate-400 font-medium">Kamar Kosong</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Bulan Tagihan -->
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-slate-50 border border-slate-200/80 text-xs font-bold text-slate-800">
                                            {{ $tagihan->bulan_tagihan }}
                                        </span>
                                    </td>
                                    
                                    <!-- Nominal -->
                                    <td class="py-4 px-6">
                                        <span class="text-sm font-extrabold text-slate-900 block">
                                            Rp {{ number_format($tagihan->jumlah_bayar, 0, ',', '.') }}
                                        </span>
                                        @if($tagihan->catatan)
                                            <span class="text-[10px] text-slate-400 italic block mt-0.5">
                                                {{ $tagihan->catatan }}
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <!-- Status -->
                                    <td class="py-4 px-6 text-center">
                                        @if($tagihan->status == 'Lunas')
                                            <div class="flex flex-col items-center gap-1">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-xs font-bold shadow-2xs animate-active-badge">
                                                    <span class="relative flex h-2 w-2">
                                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                                    </span>
                                                    <span>Lunas</span>
                                                </span>
                                                @if($tagihan->tanggal_bayar)
                                                    <span class="text-[10px] text-slate-400 font-medium">
                                                        {{ \Carbon\Carbon::parse($tagihan->tanggal_bayar)->format('d M Y') }}
                                                    </span>
                                                @endif
                                            </div>
                                        @elseif($tagihan->status == 'Menunggu Konfirmasi')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-700 border border-amber-200/80 text-xs font-bold shadow-2xs animate-pulse">
                                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                                <span>Verifikasi Bukti</span>
                                            </span>
                                        @elseif($tagihan->status == 'Ditolak')
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
                                    
                                    <!-- Aksi -->
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($tagihan->status == 'Menunggu Konfirmasi' && $tagihan->bukti_bayar)
                                                <button type="button" onclick="openVerifikasiModal({{ $tagihan->id }}, '{{ asset('storage/' . $tagihan->bukti_bayar) }}', '{{ addslashes($tagihan->penghuni->nama ?? 'Penghuni') }}')" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold shadow-xs transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <span>Cek Bukti</span>
                                                </button>
                                            @elseif($tagihan->status == 'Belum Lunas' || $tagihan->status == 'Ditolak')
                                                <!-- Lunasin -->
                                                <button type="button" onclick="openBayarModal({{ $tagihan->id }}, '{{ addslashes($tagihan->penghuni->nama ?? 'Penghuni') }}', '{{ number_format($tagihan->jumlah_bayar, 0, ',', '.') }}')" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-xs transition-all" title="Konfirmasi Bayar Cash/Manual">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                    <span>Lunasin</span>
                                                </button>
                                                <!-- Edit -->
                                                <button type="button" onclick="openEditTagihanModal({{ $tagihan->id }}, {{ $tagihan->jumlah_bayar }}, '{{ addslashes($tagihan->catatan ?? '') }}')" class="p-2 rounded-xl bg-slate-50 hover:bg-slate-900 text-slate-600 hover:text-white border border-slate-200/80 transition-all shadow-2xs" title="Edit Tagihan">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                </button>
                                                <!-- Hapus -->
                                                <button type="button" onclick="openDeleteTagihanModal({{ $tagihan->id }})" class="p-2 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200/80 transition-all shadow-2xs" title="Hapus Tagihan">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            @else
                                                <a href="{{ route('admin.tagihan.cetak_struk', $tagihan->id) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80 text-xs font-bold shadow-xs transition-all group" title="Cetak Kwitansi Pembayaran">
                                                    <svg class="w-4 h-4 text-emerald-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.049.208-2.158 1.052-2.738a4.5 4.5 0 016.456 0c.844.58 1.292 1.689 1.052 2.738M12 3v13.5m0 0l-3-3m3 3l3-3M3 18.75h18" />
                                                    </svg>
                                                    <span>Cetak Struk</span>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400">
                                        Tidak ada data tagihan ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- EMPTY CLIENT SEARCH RESULT MESSAGE -->
                <div id="noResultsTagihan" class="hidden py-16 text-center bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8 animate-fade-in">
                    <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400 mx-auto mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Tagihan Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Tidak ada tagihan yang sesuai dengan kata kunci pencarian atau filter status yang dipilih.</p>
                    <button type="button" onclick="resetAllFilters()" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-all">
                        Reset Filter
                    </button>
                </div>

            </div>
        </main>
    </div>
    
    <!-- ========================================== -->
    <!-- MODAL OVERLAY GLOBAL -->
    <!-- ========================================== -->
    <div id="modalOverlayGlobal" onclick="closeAllModals()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden transition-opacity opacity-0 duration-300"></div>

    <!-- ========================================== -->
    <!-- 1. MODAL KONFIRMASI PEMBAYARAN MANUAL -->
    <!-- ========================================== -->
    <div id="modalBayarBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 text-center">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-200/60 shadow-2xs">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6H2.25m0 0v11.25a2.25 2.25 0 002.25 2.25h15m0-15.75H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25zM15.75 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Konfirmasi Pelunasan?</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                Konfirmasi pelunasan kas sewa dari <span id="bayarNamaLabel" class="font-extrabold text-slate-900 bg-slate-100 px-2 py-0.5 rounded-md"></span> sebesar <span id="bayarNominalLabel" class="font-extrabold text-emerald-600"></span>?
            </p>
            <form id="formBayarTagihan" method="POST" class="flex items-center gap-3 mt-6">
                @csrf
                <button type="button" onclick="closeModal('modalBayarBox')" class="w-1/2 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-all">
                    Batal
                </button>
                <button type="submit" class="w-1/2 py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm hover:shadow-md transition-all">
                    Ya, Konfirmasi Lunas
                </button>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 2. MODAL GENERATE TAGIHAN MASSAL -->
    <!-- ========================================== -->
    <div id="modalGenerateBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 text-center">
            <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-amber-200/60 shadow-2xs">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                </svg>
            </div>
            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Tagih Semua Penghuni?</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                Sistem akan membuatkan invoice tagihan baru untuk seluruh penyewa yang berstatus <span class="font-extrabold text-emerald-600">Aktif</span> pada bulan ini tanpa membuat invoice ganda.
            </p>
            <div class="flex items-center gap-3 mt-6">
                <button type="button" onclick="closeModal('modalGenerateBox')" class="w-1/2 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-all">
                    Batal
                </button>
                <button type="button" onclick="document.getElementById('formGenerateTagihan').submit()" class="w-1/2 py-3 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold shadow-sm hover:shadow-md transition-all">
                    Ya, Buat Tagihan
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 3. MODAL TAGIHAN SATUAN / MANUAL -->
    <!-- ========================================== -->
    <div id="modalSatuanBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-lg hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-5 mb-5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-900 text-white flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Buat Tagihan Satuan</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Terbitkan invoice sewa khusus untuk salah satu penyewa.</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('modalSatuanBox')" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <form action="{{ route('admin.tagihan.storeManual') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Pilih Penghuni Aktif <span class="text-rose-500">*</span>
                    </label>
                    <select name="penghuni_id" id="selectPenghuni" required onchange="setHargaOtomatis()" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all cursor-pointer">
                        <option value="" data-harga="">-- Pilih Penghuni Aktif --</option>
                        
                        <!-- PERBAIKAN DROPDOWN MANUAL TAGIHAN -->
                        @foreach($penghuniAktifList as $p)
                            @php
                                $jumlahKamar = $p->kamars->count();
                                if ($jumlahKamar > 0) {
                                    $listKamar = $p->kamars->pluck('nomor_kamar')->map(function($k) {
                                        return Str::startsWith(strtolower(trim($k)), 'kamar') ? trim($k) : 'Kamar ' . trim($k);
                                    })->join(', ');
                                    $totalHarga = $p->kamars->sum('harga');
                                    $labelKamar = $jumlahKamar > 1 ? "($jumlahKamar Unit) $listKamar" : $listKamar;
                                } else {
                                    $labelKamar = 'Tanpa Kamar';
                                    $totalHarga = 0;
                                }
                            @endphp
                            <option value="{{ $p->id }}" data-harga="{{ $totalHarga }}">
                                {{ $p->nama }} — {{ $labelKamar }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- KODE BARU YANG UDAH FIX -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Periode Tagihan <span class="text-rose-500">*</span>
                            </label>
                           <input type="text" name="bulan_tagihan" required 
                value="{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::now()->addMonthsNoOverflow(1)->translatedFormat('d F Y') }}" 
                placeholder="Cth: 31 Agustus 2026 - 30 September 2026" 
                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
                        </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Nominal Tagihan (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="jumlah_bayar" id="inputNominal" required placeholder="Otomatis dari tarif kamar" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" onclick="closeModal('modalSatuanBox')" class="w-1/3 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="w-2/3 py-3 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                        <span>Terbitkan Tagihan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 4. MODAL EDIT / REVISI TAGIHAN -->
    <!-- ========================================== -->
    <div id="modalEditTagihanBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8">
            <div class="flex justify-between items-center pb-5 mb-5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 border border-slate-200 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Revisi Tagihan</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Ubah nominal sewa atau catatan tagihan.</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('modalEditTagihanBox')" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <form id="formEditTagihan" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Nominal Baru (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" id="editNominalInput" name="jumlah_bayar" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Catatan Khusus (Opsional)
                    </label>
                    <input type="text" id="editCatatanInput" name="catatan" placeholder="Cth: Potongan diskon / Denda telat" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" onclick="closeModal('modalEditTagihanBox')" class="w-1/3 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="w-2/3 py-3 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold shadow-sm hover:shadow-md transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 5. MODAL HAPUS TAGIHAN -->
    <!-- ========================================== -->
    <div id="modalDeleteTagihanBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 text-center">
            <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-rose-200/60 shadow-2xs">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
            </div>
            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Hapus Tagihan?</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                Tagihan ini akan dihapus permanen dari sistem pencatatan kosan Pak Lalan.
            </p>
            <form id="formDeleteTagihan" method="POST" class="flex items-center gap-3 mt-6">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal('modalDeleteTagihanBox')" class="w-1/2 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-all">
                    Batal
                </button>
                <button type="submit" class="w-1/2 py-3 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm hover:shadow-md transition-all">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 6. MODAL VERIFIKASI BUKTI TRANSFER -->
    <!-- ========================================== -->
    <div id="modalVerifikasiBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-lg hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-5 mb-5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Verifikasi Bukti Transfer</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Pengirim: <span id="namaPenghuniModal" class="font-extrabold text-slate-900"></span></p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('modalVerifikasiBox')" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <div class="space-y-5">
                <!-- Preview Struk Transfer -->
                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200/80 flex flex-col items-center">
                    <a id="linkFullFoto" href="#" target="_blank" title="Klik untuk membuka struk penuh di tab baru" class="block w-full text-center group">
                        <img id="imgBukti" src="" alt="Bukti Transfer" class="w-full h-auto max-h-72 object-contain rounded-xl bg-white border border-slate-200 shadow-2xs group-hover:opacity-95 transition-opacity">
                    </a>
                    <p class="text-[11px] text-slate-400 mt-2 font-medium">Klik gambar untuk membuka bukti dalam ukuran penuh</p>
                </div>
                
                <div class="space-y-3 pt-2">
                    <!-- Form Terima / Konfirmasi Lunas -->
                    <form id="formKonfirmasi" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            <span>Bukti Valid, Konfirmasi Lunas</span>
                        </button>
                    </form>

                    <!-- Form Tolak Bukti -->
                    <form id="formTolakBukti" method="POST" class="p-4 rounded-2xl bg-rose-50/70 border border-rose-200/80 space-y-2.5">
                        @csrf
                        @method('PUT')
                        <label class="block text-xs font-bold text-rose-700 uppercase tracking-wider">
                            Tolak Pembayaran (Jika Bukti Tidak Valid)
                        </label>
                        <div class="flex gap-2">
                            <input type="text" name="alasan_tolak" required placeholder="Cth: Struk buram / Nominal belum sesuai" class="flex-1 px-3.5 py-2.5 bg-white border border-rose-200 rounded-xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/10">
                            <button type="submit" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs rounded-xl shadow-xs transition-all shrink-0">
                                Tolak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 7. MODAL BERSIHKAN ARSIP LUNAS -->
    <!-- ========================================== -->
    <div id="modalBersihkanBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 text-center">
            <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-rose-200/60 shadow-2xs">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
            </div>
            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Bersihkan Arsip Lunas?</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                Pastikan Anda sudah mengunduh <span class="font-bold text-slate-900">Rekap PDF</span>. Seluruh data tagihan berstatus <span class="font-extrabold text-emerald-600">Lunas</span> pada filter yang dipilih akan dihapus permanen.
            </p>
            <div class="my-3">
                <span id="labelBulanBersih" class="inline-block px-3 py-1 bg-slate-100 rounded-lg text-xs font-semibold text-slate-700"></span>
            </div>
            <form id="formBersihkanArsip" action="{{ route('admin.tagihan.bersihkan') }}" method="POST" class="flex items-center gap-3 mt-5">
                @csrf
                @method('DELETE')
                <input type="hidden" name="bulan" id="inputBulanBersih" value="">
                <button type="button" onclick="closeModal('modalBersihkanBox')" class="w-1/2 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-all">
                    Batal
                </button>
                <button type="submit" class="w-1/2 py-3 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm hover:shadow-md transition-all">
                    Ya, Bersihkan
                </button>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SCRIPT JS (MODALS, FILTER, SEARCH) -->
    <!-- ========================================== -->
    <script>
        const overlayGlobal = document.getElementById('modalOverlayGlobal');
        let currentStatusFilter = 'all';

        // Modal Global Handler
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
            ['modalBayarBox', 'modalGenerateBox', 'modalSatuanBox', 'modalEditTagihanBox', 'modalDeleteTagihanBox', 'modalVerifikasiBox', 'modalBersihkanBox'].forEach(id => {
                const el = document.getElementById(id);
                if (el && !el.classList.contains('hidden')) {
                    closeModal(id);
                }
            });
        }

        // Shortcut Openers
        function openBayarModal(id, nama, nominal) {
            document.getElementById('formBayarTagihan').action = `/admin/tagihan/${id}/bayar`;
            document.getElementById('bayarNamaLabel').innerText = nama;
            document.getElementById('bayarNominalLabel').innerText = 'Rp ' + nominal;
            openModal('modalBayarBox');
        }

        function openGenerateModal() { openModal('modalGenerateBox'); }
        function openSatuanModal() { openModal('modalSatuanBox'); }

        function openEditTagihanModal(id, nominal, catatan) {
            document.getElementById('formEditTagihan').action = `/admin/tagihan/${id}`;
            document.getElementById('editNominalInput').value = nominal;
            document.getElementById('editCatatanInput').value = catatan || '';
            openModal('modalEditTagihanBox');
        }

        function openDeleteTagihanModal(id) {
            document.getElementById('formDeleteTagihan').action = `/admin/tagihan/${id}`;
            openModal('modalDeleteTagihanBox');
        }

        function openVerifikasiModal(id, imgUrl, nama) {
            document.getElementById('formKonfirmasi').action = `/admin/tagihan/${id}/konfirmasi`;
            document.getElementById('formTolakBukti').action = `/admin/tagihan/${id}/tolak`;
            document.getElementById('imgBukti').src = imgUrl;
            document.getElementById('linkFullFoto').href = imgUrl;
            document.getElementById('namaPenghuniModal').innerText = nama;
            openModal('modalVerifikasiBox');
        }

        function setHargaOtomatis() {
            const select = document.getElementById('selectPenghuni');
            // Mengambil total harga dari data-harga yang sudah dijumlahkan di controller/blade sebelumnya
            const harga = select.options[select.selectedIndex].getAttribute('data-harga');
            document.getElementById('inputNominal').value = harga || '';
        }

        function openBersihkanModal(bulan) {
            document.getElementById('inputBulanBersih').value = bulan || '';
            if (bulan && bulan !== 'Semua Bulan') {
                document.getElementById('labelBulanBersih').innerText = "Target Arsip: Bulan " + bulan;
            } else {
                document.getElementById('labelBulanBersih').innerText = "Target Arsip: Semua Bulan";
            }
            openModal('modalBersihkanBox');
        }

        // Status Filter Handler
        function setStatusFilter(status) {
            currentStatusFilter = status;

            const btnAll = document.getElementById('filterStatusAll');
            const btnVerif = document.getElementById('filterStatusVerif');
            const btnBelum = document.getElementById('filterStatusBelum');
            const btnLunas = document.getElementById('filterStatusLunas');
            const btnDitolak = document.getElementById('filterStatusDitolak');

            const activeClass = 'status-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-white shadow-xs transition-all shrink-0';
            const inactiveClass = 'status-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0';

            if (btnAll) btnAll.className = (status === 'all') ? activeClass : inactiveClass;
            if (btnVerif) btnVerif.className = (status === 'Menunggu Konfirmasi') ? activeClass : 'status-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/80 hover:bg-amber-100 transition-all shrink-0 flex items-center gap-1.5';
            if (btnBelum) btnBelum.className = (status === 'Belum Lunas') ? activeClass : inactiveClass;
            if (btnLunas) btnLunas.className = (status === 'Lunas') ? activeClass : inactiveClass;
            if (btnDitolak) btnDitolak.className = (status === 'Ditolak') ? activeClass : 'status-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200/80 transition-all shrink-0';

            applyClientFilter();
        }

        function resetAllFilters() {
            const input = document.getElementById('serverSearchInput');
            if (input) input.value = '';
            setStatusFilter('all');
        }

        // Unified Instant Client-Side Filter & Search (Hanya memproses Table Rows)
        function applyClientFilter() {
            const searchVal = (document.getElementById('serverSearchInput')?.value || '').trim().toLowerCase();
            const rows = document.querySelectorAll('.tagihan-table-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const searchStr = row.getAttribute('data-search') || '';
                const status = row.getAttribute('data-status') || '';

                const matchSearch = searchVal === '' || searchStr.includes(searchVal);
                const matchStatus = (currentStatusFilter === 'all') || (status === currentStatusFilter);

                if (matchSearch && matchStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const noResults = document.getElementById('noResultsTagihan');
            if (visibleCount === 0 && rows.length > 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        // Dropdown Profil Admin
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

        document.addEventListener('DOMContentLoaded', function() {
            // Count-Up Animation for Stat Numbers
            const counters = document.querySelectorAll('.count-up');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                if (isNaN(target)) return;
                
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

            // Auto dismiss alert after 5s
            const alertSuccess = document.getElementById('alertSuccess');
            if (alertSuccess) {
                setTimeout(() => {
                    alertSuccess.style.opacity = '0';
                    alertSuccess.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => alertSuccess.remove(), 500);
                }, 5000);
            }
        });

        // Escape Key to close all modals
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAllModals();
                const dropdown = document.getElementById('profilDropdown');
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    toggleDropdown();
                }
            }
        });
    </script>
</body>
</html>