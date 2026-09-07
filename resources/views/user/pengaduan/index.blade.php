<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lapor Keluhan - Kosan Pak Lalan</title>
    
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
                    <!-- RUMUS COMBO NOTIF (FULL DATABASE BERDASARKAN CONTROLLER YASA) -->
                    @php
                        $user = Auth::user();
                        $notifTagihan = 0;
                        
                        // 1. Hitung Notif Tagihan
                        $penghuniBadge = \App\Models\Penghuni::where('user_id', $user->id)->first();
                        if($penghuniBadge) {
                            $notifTagihan = \App\Models\Tagihan::where('penghuni_id', $penghuniBadge->id)
                                ->whereIn('status', ['Belum Lunas', 'Ditolak'])
                                ->count();
                        }

                        // 2. Hitung Notif Pengumuman (LANGSUNG CEK KE TABEL PIVOT)
                        $jumlahPengumuman = \App\Models\Pengumuman::where('status', 'Aktif')
                            ->whereDoesntHave('users', function($q) use ($user) {
                                $q->where('user_id', $user->id)->whereNotNull('read_at');
                            })->count();
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
                    
                    <!-- Lapor Keluhan (Aktif) -->
                    <a href="{{ route('user.pengaduan') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.pengaduan*') ? 'bg-slate-900 text-white shadow-sm shadow-slate-900/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('user.pengaduan*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <span>Lapor Keluhan</span>
                    </a>

                    <!-- pengumuman (DENGAN NOTIF RAPI) -->
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
                            <span class="text-slate-700">Pengumuman</span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight leading-tight mt-0.5">Semua Siaran Informasi</h2>
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
                                    {{ isset($penghuni) && $penghuni->kamar ? 'Kamar ' . trim(str_ireplace('kamar', '', $penghuni->kamar->nomor_kamar)) : 'Penghuni' }}
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
            <div class="flex-1 overflow-y-scroll p-6 sm:p-8 space-y-6">
                
                <!-- ALERT SUKSES / ERROR -->
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
                            <p class="font-bold">Ada beberapa kendala pengisian formulir:</p>
                            <ul class="mt-1 list-disc list-inside text-xs font-medium text-rose-700 space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <!-- 4 KARTU METRIK RINGKASAN KELUHAN (STATIS) -->
                @php
                    $totalKeluhan = count($pengaduans);
                    $totalMenunggu = collect($pengaduans)->where('status', 'Menunggu')->count();
                    $totalDiproses = collect($pengaduans)->where('status', 'Diproses')->count();
                    $totalSelesai = collect($pengaduans)->where('status', 'Selesai')->count();
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    
                    <!-- 1. Total Laporan -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Laporan</span>
                                <!-- Icon Bulat Statis -->
                                <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-200/80 flex items-center justify-center text-indigo-500 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalKeluhan }}</h3>
                                <span class="text-xs text-slate-400 font-medium">Tiket Terkirim</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Layanan:</span>
                            <span class="font-semibold text-slate-700">Fasilitas Kos</span>
                        </div>
                    </div>

                    <!-- 2. Menunggu Respon -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Menunggu Respon</span>
                                <!-- Icon Bulat Statis -->
                                <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200/80 flex items-center justify-center text-slate-500 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalMenunggu }}</h3>
                                <span class="text-xs text-slate-400 font-medium">Dalam Antrean</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Status:</span>
                            <span class="font-semibold text-slate-600">Pending Review</span>
                        </div>
                    </div>

                    <!-- 3. Sedang Diproses -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sedang Dikerjakan</span>
                                <!-- Icon Bulat Statis -->
                                <div class="w-10 h-10 rounded-full bg-amber-50 border border-amber-200/80 flex items-center justify-center text-amber-500 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.07a4.5 4.5 0 004.486-6.32l-3.27 3.27a1.5 1.5 0 01-2.122-2.122l3.27-3.27a4.5 4.5 0 00-6.32 4.486c.118.58.094 1.193-.07 1.743" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-3xl font-extrabold text-amber-600 tracking-tight">{{ $totalDiproses }}</h3>
                                <span class="text-xs text-slate-400 font-medium">Perbaikan Aktif</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                            <span class="text-slate-500">Penanganan:</span>
                            @if($totalDiproses > 0)
                                <span class="font-bold text-amber-600">Teknisi Bertugas &rarr;</span>
                            @else
                                <span class="font-semibold text-slate-600">Tidak Ada Kendala</span>
                            @endif
                        </div>
                    </div>

                    <!-- 4. Selesai Diperbaiki -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tuntas Diselesaikan</span>
                                <!-- Icon Bulat Statis -->
                                <div class="w-10 h-10 rounded-full bg-emerald-50 border border-emerald-200/80 flex items-center justify-center text-emerald-500 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-3xl font-extrabold text-emerald-600 tracking-tight">{{ $totalSelesai }}</h3>
                                <span class="text-xs text-slate-400 font-medium">Keluhan Selesai</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span>Status:</span>
                            <span class="font-semibold text-emerald-600">Teratasi 100%</span>
                        </div>
                    </div>

                </div>

                <!-- MAIN GRID: FORM PENGADUAN (KIRI) & RIWAYAT LAPORAN (KANAN) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start animate-fade-in delay-2">
                    
                    <!-- ========================================== -->
                    <!-- KOLOM KIRI: FORM LAPOR KELUHAN (4/12) -->
                    <!-- ========================================== -->
                    <div class="lg:col-span-5 xl:col-span-4 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-md sticky top-24">
                        
                        <div class="flex items-center gap-3 pb-5 mb-5 border-b border-slate-100">
                            <div class="w-10 h-10 rounded-2xl bg-slate-900 text-white flex items-center justify-center shrink-0 shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-900 tracking-tight leading-tight">Buat Laporan Baru</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Sampaikan kendala fasilitas ke pengelola</p>
                            </div>
                        </div>

                        <form action="{{ route('user.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            
                            <!-- Judul Laporan -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Judul Kendala <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="judul" required placeholder="Contoh: Keran Kamar Mandi Bocor" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
                            </div>

                            <!-- Deskripsi Laporan -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Rincian Kerusakan / Masalah <span class="text-rose-500">*</span>
                                </label>
                                <textarea name="deskripsi" required rows="4" placeholder="Jelaskan kendala secara detail agar teknisi dapat membawa peralatan yang tepat..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all resize-none"></textarea>
                            </div>

                            <!-- Lampiran Foto Bukti -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Foto Bukti Fisik <span class="text-xs text-slate-400 font-normal lowercase">(opsional)</span>
                                </label>
                                <input type="file" name="foto" id="inputFotoKeluhan" accept="image/*" onchange="previewUploadImage(this, 'previewFotoKeluhan')" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 cursor-pointer focus:outline-none">
                                <p class="text-[11px] text-slate-400 mt-1">Format: JPG, JPEG, PNG (Maks 2 MB).</p>
                            </div>

                            <!-- Preview Foto Mini -->
                            <div id="previewContainerKeluhan" class="hidden p-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-center relative">
                                <img id="previewFotoKeluhan" src="" alt="Pratinjau Foto" class="w-full h-auto max-h-36 object-contain rounded-xl bg-white mx-auto">
                            </div>

                            <!-- Tombol Kirim -->
                            <button type="submit" class="w-full mt-2 py-3 px-4 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2 group">
                                <span>Kirim Laporan Pengaduan</span>
                                <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                            </button>
                        </form>

                    </div>

                    <!-- ========================================== -->
                    <!-- KOLOM KANAN: RIWAYAT PENGADUAN (8/12) -->
                    <!-- ========================================== -->
                    <div class="lg:col-span-7 xl:col-span-8 space-y-5">
                        
                        <!-- Toolbar Filter & Search -->
                        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <!-- Search Box -->
                            <div class="relative flex-1 min-w-0">
                                <input type="text" id="pengaduanSearchInput" onkeyup="applyPengaduanFilter()" placeholder="Cari judul keluhan, deskripsi, atau tanggal..." class="w-full pl-9 pr-8 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                                <button type="button" id="clearPengaduanSearchBtn" onclick="clearPengaduanSearch()" class="hidden absolute right-3 top-2.5 text-slate-400 hover:text-slate-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>

                            <!-- Filter Tabs -->
                            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0 shrink-0">
                                <button type="button" onclick="setPengaduanStatusFilter('all')" id="btnFilterAll" class="pengaduan-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-white shadow-xs transition-all shrink-0">
                                    Semua ({{ $totalKeluhan }})
                                </button>
                                <button type="button" onclick="setPengaduanStatusFilter('Menunggu')" id="btnFilterMenunggu" class="pengaduan-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0">
                                    Menunggu ({{ $totalMenunggu }})
                                </button>
                                <button type="button" onclick="setPengaduanStatusFilter('Diproses')" id="btnFilterDiproses" class="pengaduan-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/80 hover:bg-amber-100 transition-all shrink-0 flex items-center gap-1.5">
                                    <span>Diproses ({{ $totalDiproses }})</span>
                                </button>
                                <button type="button" onclick="setPengaduanStatusFilter('Selesai')" id="btnFilterSelesai" class="pengaduan-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0">
                                    Selesai ({{ $totalSelesai }})
                                </button>
                            </div>
                        </div>

                        <!-- Daftar Tiket Pengaduan (Cards) -->
                        <div id="pengaduanListContainer" class="space-y-4">
                            @forelse($pengaduans as $item)
                            <div class="pengaduan-card bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md relative overflow-hidden group"
                                 data-status="{{ $item->status }}"
                                 data-search="{{ strtolower($item->judul . ' ' . $item->deskripsi . ' ' . $item->status . ' ' . \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y')) }}">
                                
                                <!-- Card Header -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-base font-extrabold text-slate-900 tracking-tight">
                                                {{ $item->judul }}
                                            </h4>
                                        </div>
                                        <div class="flex items-center gap-2 mt-1 text-[11px] text-slate-400 font-medium">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') }} WIB</span>
                                            <span>&bull;</span>
                                            <span>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                        </div>
                                    </div>

                                    <!-- Status Badges & Delete Button -->
                                    <div class="shrink-0 flex items-center gap-2">
                                        @if($item->status == 'Menunggu')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold shadow-2xs">
                                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                                <span>Menunggu Respon</span>
                                            </span>
                                        @elseif($item->status == 'Diproses')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-700 border border-amber-200/80 text-xs font-bold shadow-2xs">
                                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                                <span>Sedang Diproses</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-xs font-bold shadow-2xs">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                <span>Selesai Diperbaiki</span>
                                            </span>
                                        @endif
                                        
                                        <!-- TOMBOL HAPUS -->
                                        <button type="button" onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->judul) }}')" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-all" title="Hapus Laporan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Card Body (Deskripsi Keluhan) -->
                                <div class="py-4 space-y-3">
                                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/60 text-xs font-medium text-slate-700 leading-relaxed">
                                        {{ $item->deskripsi }}
                                    </div>

                                  <!-- Foto Bukti Lampiran -->
                                    @if($item->foto)
                                    <div class="pt-2">
                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Lampiran Bukti Foto:</span>
                                        <div class="flex items-center gap-3">
                                            @php 
                                                $pathFoto = str_replace('public/', '', $item->foto); 
                                                $urlFoto = asset('storage/' . $pathFoto);
                                            @endphp

                                            <div class="relative group/thumb cursor-pointer overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-50 w-28 h-20 shadow-2xs" onclick="openPreviewModal('{{ $urlFoto }}', '{{ addslashes($item->judul) }}', '{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}')">
                                                <img src="{{ $urlFoto }}" onerror="this.src='https://via.placeholder.com/150?text=Foto+Rusak'" alt="Foto Keluhan" class="w-full h-full object-cover group-hover/thumb:scale-105 transition-transform duration-300">
                                                <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg>
                                                </div>
                                            </div>
                                            <button type="button" onclick="openPreviewModal('{{ $urlFoto }}', '{{ addslashes($item->judul) }}', '{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}')" class="text-xs font-bold text-slate-700 hover:text-slate-900 underline underline-offset-4 decoration-slate-300">
                                                Lihat Gambar Penuh &rarr;
                                            </button>
                                        </div>
                                    </div>
                                    @endif  

                                <!-- Card Footer: Status Progress Bar Timeline -->
                                <div class="pt-3 border-t border-slate-100">
                                    <div class="flex items-center justify-between text-[11px] font-semibold text-slate-400 mb-1.5">
                                        <span>Progres Penanganan</span>
                                        <span class="font-bold text-slate-700">
                                            @if($item->status == 'Menunggu') 1/3 (Diterima)
                                            @elseif($item->status == 'Diproses') 2/3 (Pengerjaan)
                                            @else 3/3 (Tuntas)
                                            @endif
                                        </span>
                                    </div>
                                    <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden flex">
                                        <div class="h-full bg-slate-900 transition-all duration-500 {{ $item->status == 'Menunggu' ? 'w-1/3' : ($item->status == 'Diproses' ? 'w-2/3 bg-amber-500' : 'w-full bg-emerald-500') }}"></div>
                                    </div>
                                </div>

                            </div>
                            @empty
                            <div class="py-16 text-center bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8">
                                <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400 mx-auto mb-4">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-900">Tidak Ada Keluhan Aktif</h3>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Semua fasilitas kos berjalan normal. Jika ada kerusakan di kamar atau area kos, gunakan formulir di samping untuk melapor.</p>
                            </div>
                            @endforelse
                        </div>

                        <!-- No Result Alert (When Filter or Search is Empty) -->
                        <div id="noResultsPengaduan" class="hidden py-16 text-center bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8">
                            <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400 mx-auto mb-4">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-900">Laporan Tidak Ditemukan</h3>
                            <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Tidak ada tiket pengaduan yang sesuai dengan pencarian atau filter status yang Anda pilih.</p>
                            <button type="button" onclick="clearPengaduanSearch()" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-all">
                                Reset Filter
                            </button>
                        </div>

                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- ========================================== -->
    <!-- MODAL OVERLAY & MODAL PREVIEW FOTO -->
    <!-- ========================================== -->
    <!-- Overlay Global digunakan untuk Foto & Hapus -->
    <div id="modalOverlayGlobal" onclick="closeAllModals()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden transition-opacity opacity-0 duration-300"></div>

    <!-- Modal Preview Foto -->
    <div id="modalPreviewBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-lg hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 sm:p-8 text-center max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-slate-100">
                <div class="text-left">
                    <h3 class="text-base font-extrabold text-slate-900" id="labelPreviewJudul">Lampiran Foto Keluhan</h3>
                    <p class="text-xs text-slate-400 mt-0.5" id="labelPreviewTanggal"></p>
                </div>
                <button type="button" onclick="closePreviewModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200 mb-5">
                <img id="imgPreviewFull" src="" alt="Foto Kerusakan" class="w-full h-auto max-h-96 object-contain rounded-xl bg-white border border-slate-200 mx-auto">
            </div>

            <button type="button" onclick="closePreviewModal()" class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition-all">
                Tutup
            </button>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modalDeleteBox" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-sm hidden p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full p-6 text-center">
            <div class="w-16 h-16 rounded-2xl bg-rose-50 border border-rose-100 text-rose-500 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </div>
            <h3 class="text-lg font-extrabold text-slate-900 mb-1">Hapus Keluhan?</h3>
            <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin menghapus laporan <span id="deleteKeluhanTitle" class="font-bold text-slate-700"></span>? Laporan yang dihapus tidak dapat dikembalikan.</p>
            
            <form id="formDeleteKeluhan" method="POST" action="" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="w-1/2 py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm transition-all">Batal</button>
                <button type="submit" class="w-1/2 py-2.5 px-4 rounded-xl bg-rose-500 hover:bg-rose-600 text-white font-semibold text-sm shadow-sm transition-all">Ya, Hapus</button>
            </form>
        </div>
    </div>

    <!-- SCRIPT JS (FILTER, PREVIEW, DROPDOWN, SIDEBAR) -->
    <script>
        const overlayGlobal = document.getElementById('modalOverlayGlobal');
        let currentStatusFilter = 'all';

        // Fungsi Tutup Semua Modal jika area gelap di-klik
        function closeAllModals() {
            closePreviewModal();
            closeDeleteModal();
        }

        // Modal Konfirmasi Hapus
        function openDeleteModal(id, title) {
            document.getElementById('deleteKeluhanTitle').innerText = '"' + title + '"';
            document.getElementById('formDeleteKeluhan').action = `/user/pengaduan/${id}`;
            
            const modal = document.getElementById('modalDeleteBox');
            const content = modal.querySelector('div');

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

        function closeDeleteModal() {
            const modal = document.getElementById('modalDeleteBox');
            const content = modal.querySelector('div');

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

        // Modal Preview Foto
        function openPreviewModal(imgUrl, judul, tanggal) {
            document.getElementById('imgPreviewFull').src = imgUrl;
            document.getElementById('labelPreviewJudul').innerText = judul;
            document.getElementById('labelPreviewTanggal').innerText = 'Dilaporkan pada: ' + tanggal;
            
            const modal = document.getElementById('modalPreviewBox');
            const content = modal.querySelector('div');

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

        function closePreviewModal() {
            const modal = document.getElementById('modalPreviewBox');
            const content = modal.querySelector('div');

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

        // Live Upload Image Preview Helper
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

        // Filter Status Tabs
        function setPengaduanStatusFilter(status) {
            currentStatusFilter = status;

            const btnAll = document.getElementById('btnFilterAll');
            const btnMenunggu = document.getElementById('btnFilterMenunggu');
            const btnDiproses = document.getElementById('btnFilterDiproses');
            const btnSelesai = document.getElementById('btnFilterSelesai');

            const activeClass = 'pengaduan-filter-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-white shadow-xs transition-all shrink-0';
            const inactiveClass = 'pengaduan-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/80 transition-all shrink-0';

            if (btnAll) btnAll.className = (status === 'all') ? activeClass : inactiveClass;
            if (btnMenunggu) btnMenunggu.className = (status === 'Menunggu') ? activeClass : inactiveClass;
            if (btnDiproses) btnDiproses.className = (status === 'Diproses') ? activeClass : 'pengaduan-filter-btn px-3 py-1.5 rounded-xl text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/80 hover:bg-amber-100 transition-all shrink-0 flex items-center gap-1.5';
            if (btnSelesai) btnSelesai.className = (status === 'Selesai') ? activeClass : inactiveClass;

            applyPengaduanFilter();
        }

        function clearPengaduanSearch() {
            const input = document.getElementById('pengaduanSearchInput');
            if (input) input.value = '';
            setPengaduanStatusFilter('all');
        }

        // Live Filter & Search Engine
        function applyPengaduanFilter() {
            const query = (document.getElementById('pengaduanSearchInput')?.value || '').trim().toLowerCase();
            const clearBtn = document.getElementById('clearPengaduanSearchBtn');

            if (query.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }

            const cards = document.querySelectorAll('.pengaduan-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const searchStr = card.getAttribute('data-search') || '';
                const status = card.getAttribute('data-status') || '';

                const matchQuery = query === '' || searchStr.includes(query);
                const matchStatus = (currentStatusFilter === 'all') || (status === currentStatusFilter);

                if (matchQuery && matchStatus) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const noResults = document.getElementById('noResultsPengaduan');
            if (visibleCount === 0 && cards.length > 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        // Auto dismiss alert
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

        // Escape Key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAllModals();
                const dropdown = document.getElementById('profilDropdown');
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    toggleDropdown();
                }
            }
        });

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