<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Kamar - Kosan Pak Lalan</title>
    
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

        /* Smooth Fade In Animations */
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
        .animate-active-badge { animation: statusPulse 2.5s cubic-bezier(0.4, 0, 0.6, 1) infinite; }

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

        <!-- SIDEBAR ADMIN (MODERN MINIMALIST) -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-72 bg-white border-r border-slate-200/80 flex flex-col justify-between h-full z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] shadow-xl lg:shadow-none">
            <div class="flex flex-col flex-1 min-h-0">
                <!-- Brand Header -->
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

                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    
                    <!-- Manajemen Kamar (Aktif) -->
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
                    
                    <!-- Tagihan & Kas -->
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

                    <!-- Laporan Keluhan -->
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
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.akun.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Kelola Akun</span>
                    </a>

                    <a href="{{ route('admin.pengumuman.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.pengumuman.*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.pengumuman.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
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
                            <span class="text-slate-700">Manajemen Kamar</span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight leading-tight mt-0.5">Kelola & Monitoring Kamar</h2>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Tanggal Hari Ini -->
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/80 text-xs font-semibold text-slate-600">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
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
            <div class="flex-1 overflow-y-scroll p-6 sm:p-8 space-y-6">
                
                <!-- ALERT NOTIFIKASI SUKSES / ERROR -->
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
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-sm font-semibold shadow-xs animate-fade-in">
                    <div class="flex items-start gap-3">
                        <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center shrink-0 text-sm font-bold shadow-xs">!</span>
                        <div class="flex-1">
                            <p class="font-bold">Ada beberapa kesalahan validasi pengisian:</p>
                            <ul class="mt-1 list-disc list-inside text-xs font-medium text-rose-700 space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <!-- HEADER BANNER & PRIMARY ACTION -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm animate-fade-in">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Kamar Kos</h1>
                        <p class="text-sm text-slate-500 mt-1 max-w-xl leading-relaxed">
                            Konfigurasi nomor unit, tarif bulanan, tipe spesifikasi fasilitas, serta pantau ketersediaan kamar secara komprehensif.
                        </p>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-3 shrink-0">
                        <!-- Tombol Update Tarif Massal -->
                        <button type="button" onclick="openUpdateTarifModal()" class="inline-flex items-center gap-2 px-4 py-3 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded-xl shadow-sm border border-slate-200/80 hover:border-slate-300 transition-all duration-200">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Update Tarif Massal</span>
                        </button>

                        <!-- Tombol Tambah Kamar Baru -->
                        <button type="button" onclick="openModal()" class="inline-flex items-center gap-2 px-5 py-3 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Tambah Kamar Baru</span>
                        </button>
                    </div>
                </div>

                <!-- 4 KARTU STATISTIK MINIMALIS -->
                @php
                    $omsetBerjalan = $kamars->where('status', 'Terisi')->sum('harga');
                    $totalPotensiOmset = $kamars->sum('harga');
                    $persentaseOkupansi = $totalKamar > 0 ? round(($kamarTerisi / $totalKamar) * 100) : 0;
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    
                    <!-- 1. Total Kamar -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Unit Kamar</span>
                            <div class="w-10 h-10 rounded-full border border-slate-200 bg-slate-50 text-slate-500 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875A2.625 2.625 0 0110.875 13.5h2.25a2.625 2.625 0 012.625 2.625V21M3 21h18M4.5 3h15a1.5 1.5 0 011.5 1.5v16.5H3V4.5A1.5 1.5 0 014.5 3z" /></svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <h4 class="count-up text-3xl font-extrabold text-slate-900 tracking-tight" data-target="{{ $totalKamar }}">0</h4>
                            <span class="text-xs text-slate-400 font-medium">Unit Kosan</span>
                        </div>
                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Kapasitas Bangunan</span>
                            <span class="font-semibold text-slate-700">100% Terdata</span>
                        </div>
                    </div>

                    <!-- 2. Kamar Terisi (Okupansi) -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kamar Terisi</span>
                            <div class="w-12 h-12 rounded-2xl bg-sky-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <h4 class="count-up text-3xl font-extrabold text-slate-900 tracking-tight" data-target="{{ $kamarTerisi }}">0</h4>
                            <span class="text-xs text-slate-400 font-medium">/ {{ $totalKamar }} Unit</span>
                        </div>
                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Okupansi</span>
                            <span class="font-semibold text-sky-600">{{ $totalKamar > 0 ? round(($kamarTerisi / $totalKamar) * 100) : 0 }}% Terisi</span>
                        </div>
                    </div>

                    <!-- 3. Kamar Kosong (Ready) -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kamar Kosong</span>
                            <div class="w-10 h-10 rounded-full border border-amber-200 bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>
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

                    <!-- 4. Estimasi Nilai Sewa Berjalan -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pendapatan Sewa/Bln</span>
                            <div class="w-12 h-12 rounded-2xl bg-sky-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <h4 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Rp {{ number_format($omsetBerjalan, 0, ',', '.') }}</h4>
                        </div>
                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Maksimal Potensi</span>
                            <span class="font-semibold text-slate-700">Rp {{ number_format($totalPotensiOmset, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- TOOLBAR FILTER & PENCARIAN -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-md flex flex-col lg:flex-row lg:items-center justify-between gap-4 animate-fade-in delay-2">
                    
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1 min-w-0">
                        <!-- Search Box -->
                        <div class="relative w-full sm:w-80">
                            <input type="text" id="kamarSearchInput" onkeyup="applyKamarFilter()" placeholder="Cari nomor kamar, tipe, atau penghuni..." class="w-full pl-9 pr-8 py-2.5 bg-slate-50 border border-slate-200/90 rounded-2xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            <button type="button" id="clearSearchBtn" onclick="clearSearch()" class="hidden absolute right-3 top-2.5 text-slate-400 hover:text-slate-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <!-- Status Filter Pills -->
                        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0">
                            <button type="button" onclick="setStatusFilter('all')" id="filterStatusAll" class="kamar-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-white shadow-xs transition-all shrink-0">
                                Semua ({{ $totalKamar }})
                            </button>
                            <button type="button" onclick="setStatusFilter('Kosong')" id="filterStatusKosong" class="kamar-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0">
                                Kosong ({{ $kamarKosong }})
                            </button>
                            <button type="button" onclick="setStatusFilter('Terisi')" id="filterStatusTerisi" class="kamar-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0">
                                Terisi ({{ $kamarTerisi }})
                            </button>
                        </div>
                    </div>

                    <!-- Tipe Filter -->
                    <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-slate-400 hidden sm:inline">Tipe:</span>
                            <select id="tipeFilterSelect" onchange="applyKamarFilter()" class="px-3 py-2 bg-slate-50 border border-slate-200/90 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/5 cursor-pointer">
                                <option value="all">Semua Tipe</option>
                                <option value="Standar">Tipe Standar</option>
                                <option value="VIP">Tipe VIP</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- FULL VIEW TABLE (SATU-SATUNYA TAMPILAN SEKARANG) -->
                <div id="kamarTableView" class="bg-white rounded-3xl border border-slate-200/80 shadow-md overflow-hidden animate-fade-in delay-3">
                            <div class="overflow-x-auto min-h-[450px]">
                                <table id="kamarTable" class="w-full min-w-[1000px] text-left border-collapse table-fixed">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    <th class="py-4 px-6 w-[15%]">No. Kamar</th>
                                    <th class="py-4 px-6 w-[15%]">Tipe Kamar</th>
                                    <th class="py-4 px-6 w-[20%]">Tarif Sewa Bulanan</th>
                                    <th class="py-4 px-6 w-[20%]">Status Ketersediaan</th>
                                    <th class="py-4 px-6 w-[20%]">Penghuni Aktif</th>
                                    <th class="py-4 px-6 w-[10%] text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @forelse($kamars as $kamar)
                                <tr class="kamar-table-row hover:bg-slate-50/80 transition-colors group"
                                    data-nomor="{{ strtolower($kamar->nomor_kamar) }}"
                                    data-tipe="{{ $kamar->tipe_kamar }}"
                                    data-status="{{ $kamar->status }}"
                                    data-penghuni="{{ $kamar->penghuni ? strtolower($kamar->nama_penghuni_asli ?? $kamar->penghuni->nama) : '' }}"
                                    data-search="{{ strtolower($kamar->nomor_kamar . ' ' . $kamar->tipe_kamar . ' ' . $kamar->status . ' ' . ($kamar->penghuni ? ($kamar->nama_penghuni_asli ?? $kamar->penghuni->nama) . ' ' . ($kamar->penghuni->nomor_hp ?? '') : '')) }}">
                                    
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3.5">
                                            <div class="w-10 h-10 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-xs shrink-0 group-hover:scale-105 transition-transform">
                                                {{ trim(str_ireplace('kamar', '', $kamar->nomor_kamar)) }}
                                            </div>
                                            <div>
                                                <span class="text-sm font-bold text-slate-900 block leading-tight">
                                                    {{ Str::startsWith(strtolower(trim($kamar->nomor_kamar)), 'kamar') ? trim($kamar->nomor_kamar) : 'Kamar ' . trim($kamar->nomor_kamar) }}
                                                </span>
                                                <span class="text-[11px] text-slate-400 font-medium">Unit Kosan</span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="py-4 px-6">
                                        @if($kamar->tipe_kamar == 'VIP')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-amber-50 text-amber-700 border border-amber-200/80 text-[11px] font-bold">
                                                <span>★ VIP</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 border border-slate-200/80 text-[11px] font-semibold">
                                                Standar
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6">
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-sm font-extrabold text-slate-900 tracking-tight">Rp {{ number_format($kamar->harga, 0, ',', '.') }}</span>
                                            <span class="text-[11px] text-slate-400 font-normal">/ bln</span>
                                        </div>
                                    </td>
                                    
                                    <td class="py-4 px-6">
                                        @if($kamar->status == 'Terisi')
                                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-xs font-bold shadow-2xs animate-active-badge">
                                                <span class="relative flex h-2 w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                                </span>
                                                <span>Terisi</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-700 border border-amber-200/80 text-xs font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                <span>Kosong (Siap Huni)</span>
                                            </span>
                                        @endif
                                    </td> 
                                    
                                    <!-- PERBAIKAN: Kolom Nama Penghuni yang Mendukung Fitur Yasa/Anton -->
                                    <td class="py-4 px-6">
                                        @if($kamar->status == 'Terisi' && $kamar->penghuni)
                                            <div class="flex items-center gap-3">
                                                <!-- Avatar Profil Singkatan Nama -->
                                                <div class="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200/60 text-slate-700 flex items-center justify-center text-xs font-bold shrink-0 shadow-sm group-hover:bg-slate-900 group-hover:text-white transition-all">
                                                    {{ strtoupper(substr($kamar->nama_penghuni_asli ?? $kamar->penghuni->nama, 0, 2)) }}
                                                </div>
                                                
                                                <!-- Detail Nama & Kontak -->
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-slate-900 text-xs sm:text-sm leading-tight">
                                                        {{ $kamar->nama_penghuni_asli ?? $kamar->penghuni->nama }}
                                                    </span>
                                                    <span class="text-[11px] text-slate-500 font-medium mt-0.5">
                                                        {{ $kamar->penghuni->nomor_hp ?? '-' }} 
                                                        
                                                        {{-- Kalau ada status kekerabatan, tampilkan --}}
                                                        @if($kamar->kekerabatan)
                                                            <span class="text-emerald-600 font-bold ml-1">({{ $kamar->kekerabatan }})</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2 text-slate-400">
                                                <span class="text-xs font-medium italic text-slate-400">Belum ada penghuni</span>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Tombol Edit -->
                                            <button type="button" onclick="openEditModal({{ $kamar->id }}, '{{ addslashes($kamar->nomor_kamar) }}', '{{ $kamar->tipe_kamar }}', {{ $kamar->harga }}, '{{ $kamar->status }}')" class="p-2 rounded-xl bg-slate-50 hover:bg-slate-900 text-slate-600 hover:text-white border border-slate-200/80 transition-all shadow-2xs" title="Edit Kamar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                            </button>
                                            <!-- Tombol Hapus -->
                                            <button type="button" onclick="openDeleteModal({{ $kamar->id }}, '{{ addslashes($kamar->nomor_kamar) }}')" class="p-2 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200/80 transition-all shadow-2xs" title="Hapus Kamar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-slate-400">Belum ada data kamar kos terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pesan Kosong Kalau Filter/Search Nggak Ketemu -->
                <div id="noResultsMessage" class="hidden py-16 text-center bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8 animate-fade-in">
                    <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400 mx-auto mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Kamar Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Tidak ada kamar yang sesuai dengan kriteria pencarian atau filter yang dipilih.</p>
                    <button type="button" onclick="clearSearch()" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-all">
                        Reset Filter & Pencarian
                    </button>
                </div>

            </div>
        </main>
    </div>

    <!-- MODAL OVERLAY BACKDROP -->
    <div id="modalOverlay" onclick="closeAllModals()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden transition-opacity opacity-0 duration-300"></div>
    
    <!-- MODAL TAMBAH KAMAR BARU -->
    <div id="modalBox" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4 cursor-pointer" onclick="closeModal()">
            <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full max-w-lg p-6 sm:p-8 cursor-default" onclick="event.stopPropagation()">
                <div class="flex justify-between items-center pb-5 mb-5 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-slate-900 text-white flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Tambah Kamar Baru</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Daftarkan nomor dan tarif unit kamar ke sistem.</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                
                <form action="{{ route('admin.kamar.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Kamar <span class="text-rose-500">*</span></label>
                        <input type="text" id="storeNomor" name="nomor_kamar" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-colors cursor-text caret-slate-900">
                        <p class="text-[11px] text-emerald-600 font-semibold mt-1">✨ Nomor otomatis diisi berdasarkan urutan terakhir (bisa diedit manual).</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tipe Kamar <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="tipe_kamar" value="Standar" onchange="setHargaOtomatis(this.value, 'inputHarga')" class="peer sr-only" checked>
                                <div class="p-3 rounded-2xl border-2 border-slate-200 peer-checked:border-slate-900 peer-checked:bg-slate-50 transition-all flex flex-col items-start h-full">
                                    <span class="text-xs font-bold text-slate-900">Standar</span>
                                    <span class="text-[11px] text-slate-500 mt-0.5">Rp 650.000 / bln</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="tipe_kamar" value="VIP" onchange="setHargaOtomatis(this.value, 'inputHarga')" class="peer sr-only">
                                <div class="p-3 rounded-2xl border-2 border-slate-200 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 transition-all flex flex-col items-start h-full">
                                    <span class="text-xs font-bold text-amber-800">★ VIP</span>
                                    <span class="text-[11px] text-amber-700 mt-0.5">Rp 850.000 / bln</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Harga Sewa per Bulan (Rp) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-sm font-bold text-slate-400">Rp</span>
                            <input type="number" id="inputHarga" name="harga" value="650000" required placeholder="650000" class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-colors cursor-text caret-slate-900">
                        </div>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100 mt-6">
                        <button type="button" onclick="closeModal()" class="w-1/3 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-all">Batal</button>
                        <button type="submit" class="w-2/3 py-3 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                            <span>Simpan Kamar</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT KAMAR -->
    <div id="modalEditBox" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4 cursor-pointer" onclick="closeEditModal()">
            <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full max-w-lg p-6 sm:p-8 cursor-default" onclick="event.stopPropagation()">
                <div class="flex justify-between items-center pb-5 mb-5 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 border border-slate-200 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Edit Data Kamar</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Perbarui nomor, tipe, tarif sewa, atau status kamar.</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeEditModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                
                <form id="formEditKamar" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Kamar <span class="text-rose-500">*</span></label>
                        <input type="text" id="editNomor" name="nomor_kamar" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-colors cursor-text caret-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tipe Kamar <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" id="editTipeStandar" name="tipe_kamar" value="Standar" onchange="setHargaOtomatis(this.value, 'editHarga')" class="peer sr-only">
                                <div class="p-3 rounded-2xl border-2 border-slate-200 peer-checked:border-slate-900 peer-checked:bg-slate-50 transition-all flex flex-col items-start h-full">
                                    <span class="text-xs font-bold text-slate-900">Standar</span>
                                    <span class="text-[11px] text-slate-500 mt-0.5">Rp 650.000 / bln</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" id="editTipeVIP" name="tipe_kamar" value="VIP" onchange="setHargaOtomatis(this.value, 'editHarga')" class="peer sr-only">
                                <div class="p-3 rounded-2xl border-2 border-slate-200 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 transition-all flex flex-col items-start h-full">
                                    <span class="text-xs font-bold text-amber-800">★ VIP</span>
                                    <span class="text-[11px] text-amber-700 mt-0.5">Rp 850.000 / bln</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Harga Sewa per Bulan (Rp) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-sm font-bold text-slate-400">Rp</span>
                            <input type="number" id="editHarga" name="harga" required class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-colors cursor-text caret-slate-900">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status <span class="text-rose-500">*</span></label>
                        <select id="editStatusKamar" name="status" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-colors cursor-pointer">
                            <option value="Kosong">Kosong (Siap Huni)</option>
                            <option value="Terisi">Terisi</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100 mt-6">
                        <button type="button" onclick="closeEditModal()" class="w-1/3 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-all">Batal</button>
                        <button type="submit" class="w-2/3 py-3 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                            <span>Perbarui Kamar</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL HAPUS KAMAR -->
    <div id="modalDeleteBox" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4 cursor-pointer" onclick="closeDeleteModal()">
            <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full max-w-md p-6 sm:p-8 text-center cursor-default" onclick="event.stopPropagation()">
                <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-rose-200/60 shadow-2xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                </div>
                <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Hapus Kamar Kos?</h3>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                    Yakin ingin menghapus <span id="deleteNomorLabel" class="font-extrabold text-slate-900 bg-slate-100 px-2 py-0.5 rounded-md"></span>? Data unit kamar ini akan dihapus secara permanen.
                </p>
                <form id="formDeleteKamar" method="POST" class="flex items-center gap-3 mt-6">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeDeleteModal()" class="w-1/2 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-all">Batal</button>
                    <button type="submit" class="w-1/2 py-3 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm hover:shadow-md transition-all">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL UPDATE TARIF MASSAL -->
    <div id="modalUpdateTarifBox" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4 cursor-pointer" onclick="closeUpdateTarifModal()">
            <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full max-w-md p-6 sm:p-8 cursor-default" onclick="event.stopPropagation()">
                
                <!-- Header Modal -->
                <div class="flex justify-between items-center pb-5 mb-5 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200/60 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Update Tarif</h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">Ubah harga serentak per tipe kamar.</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeUpdateTarifModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                
                <form action="{{ route('admin.kamar.updateTarifMassal') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    
                    <!-- Pilih Tipe Kamar -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Tipe Kamar <span class="text-rose-500">*</span></label>
                        <select name="tipe_kamar" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-900 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-colors cursor-pointer">
                            <option value="" disabled selected>-- Pilih Tipe --</option>
                            <option value="Standar">Tipe Standar</option>
                            <option value="VIP">Tipe VIP</option>
                        </select>
                    </div>

                    <!-- Harga Sewa Baru -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-2">Harga Sewa Baru (Rp) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-sm font-bold text-slate-400">Rp</span>
                            <input type="number" name="harga_baru" required placeholder="Contoh: 900000" class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-colors cursor-text caret-slate-900">
                        </div>
                        
                        <!-- Peringatan Estetik -->
                        <div class="mt-3 p-3 bg-amber-50 border border-amber-200/60 rounded-xl flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            <p class="text-[10px] text-amber-700 font-semibold leading-relaxed">
                                Tindakan ini akan mengubah harga semua kamar pada tipe yang dipilih secara massal dan permanen.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100 mt-6">
                        <button type="button" onclick="closeUpdateTarifModal()" class="w-1/3 py-3 px-4 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition-all">Batal</button>
                        <button type="submit" class="w-2/3 py-3 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                            <span>Terapkan Tarif</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SCRIPT JS -->
    <script>
        const overlay = document.getElementById('modalOverlay');
        let currentStatusFilter = 'all';

        function showModal(modalId) {
            const m = document.getElementById(modalId);
            const content = m.querySelector('.bg-white');
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
            const content = m.querySelector('.bg-white');
            overlay.classList.add('opacity-0');
            if (content) {
                content.classList.remove('modal-enter-active');
                content.classList.add('modal-leave-active');
            }
            setTimeout(() => {
                overlay.classList.add('hidden');
                m.classList.add('hidden');
                if (content) {
                    content.classList.remove('modal-leave-active');
                    content.classList.add('modal-enter');
                }
            }, 200);
        }

        function openModal() { 
            const rows = document.querySelectorAll('.kamar-table-row');
            let maxNum = 0;
            rows.forEach(row => {
                const str = row.getAttribute('data-nomor'); 
                const numMatch = str.match(/\d+/); 
                if (numMatch) {
                    const num = parseInt(numMatch[0]);
                    if (num > maxNum) maxNum = num;
                }
            });
            const nextNum = maxNum + 1;
            const formattedNum = nextNum < 10 ? '0' + nextNum : nextNum;
            const inputNomor = document.getElementById('storeNomor');
            if(inputNomor) { inputNomor.value = 'Kamar ' + formattedNum; }
            showModal('modalBox'); 
        }
        function closeModal() { hideModal('modalBox'); }

        function openEditModal(id, nomor, tipe, harga, status) {
            document.getElementById('formEditKamar').action = `/admin/kamar/${id}`;
            document.getElementById('editNomor').value = nomor;
            if (tipe === 'VIP') {
                document.getElementById('editTipeVIP').checked = true;
            } else {
                document.getElementById('editTipeStandar').checked = true;
            }
            document.getElementById('editHarga').value = harga;
            document.getElementById('editStatusKamar').value = status;
            showModal('modalEditBox');
        }
        function closeEditModal() { hideModal('modalEditBox'); }

        function openDeleteModal(id, nomor) {
            document.getElementById('formDeleteKamar').action = `/admin/kamar/${id}`;
            document.getElementById('deleteNomorLabel').innerText = nomor;
            showModal('modalDeleteBox');
        }
        function closeDeleteModal() { hideModal('modalDeleteBox'); }

        function openUpdateTarifModal() { showModal('modalUpdateTarifBox'); }
        function closeUpdateTarifModal() { hideModal('modalUpdateTarifBox'); }

        function closeAllModals() {
            closeModal();
            closeEditModal();
            closeDeleteModal();
            closeUpdateTarifModal();
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAllModals();
                const dropdown = document.getElementById('profilDropdown');
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    toggleDropdown();
                }
            }
        });

        function setHargaOtomatis(tipe, inputId) {
            const inputTarget = document.getElementById(inputId);
            if(tipe === 'Standar') { 
                inputTarget.value = 650000; 
            } else if(tipe === 'VIP') { 
                inputTarget.value = 850000; 
            }
        }

        function setStatusFilter(status) {
            currentStatusFilter = status;
            applyKamarFilter();
            
            const btnAll = document.getElementById('filterStatusAll');
            const btnKosong = document.getElementById('filterStatusKosong');
            const btnTerisi = document.getElementById('filterStatusTerisi');
            const activeClass = 'status-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-white shadow-xs transition-all shrink-0';
            const inactiveClass = 'status-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0';
            if(btnAll) btnAll.className = (status === 'all') ? activeClass : inactiveClass;
            if(btnKosong) btnKosong.className = (status === 'Kosong') ? activeClass : inactiveClass;
            if(btnTerisi) btnTerisi.className = (status === 'Terisi') ? activeClass : inactiveClass;
        }

        function clearSearch() {
            document.getElementById('kamarSearchInput').value = '';
            document.getElementById('tipeFilterSelect').value = 'all';
            setStatusFilter('all');
        }

        function applyKamarFilter() {
            const query = (document.getElementById('kamarSearchInput').value || '').trim().toLowerCase();
            const tipeFilter = document.getElementById('tipeFilterSelect').value;
            const clearBtn = document.getElementById('clearSearchBtn');

            if (query.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }

            const tableRows = document.querySelectorAll('.kamar-table-row');
            let visibleCount = 0;

            tableRows.forEach(row => {
                const searchStr = row.getAttribute('data-search') || '';
                const tipe = row.getAttribute('data-tipe') || '';
                const status = row.getAttribute('data-status') || '';
                
                const matchesQuery = query === '' || searchStr.includes(query);
                const matchesStatus = currentStatusFilter === 'all' || status === currentStatusFilter;
                const matchesTipe = tipeFilter === 'all' || tipe === tipeFilter;

                if (matchesQuery && matchesStatus && matchesTipe) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const noResults = document.getElementById('noResultsMessage');
            if (visibleCount === 0 && tableRows.length > 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('.count-up').forEach(counter => {
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

            const alertSuccess = document.getElementById('alertSuccess');
            if (alertSuccess) {
                setTimeout(() => {
                    alertSuccess.style.opacity = '0';
                    alertSuccess.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => alertSuccess.remove(), 500);
                }, 5000);
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