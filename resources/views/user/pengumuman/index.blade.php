<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informasi & Pengumuman - Portal Penghuni</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'], } } }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FAFAFA; }
        .animate-fade-in { animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .modal-enter { opacity: 0; transform: scale(0.96) translateY(8px); }
        .modal-enter-active { opacity: 1; transform: scale(1) translateY(0); transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); }
        .modal-leave { opacity: 1; transform: scale(1) translateY(0); }
        .modal-leave-active { opacity: 0; transform: scale(0.96) translateY(8px); transition: all 0.2s cubic-bezier(0.4, 0, 1, 1); }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #F1F5F9; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 9999px; }
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
                    
                <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
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
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-extrabold bg-rose-500 text-white rounded-full animate-pulse shadow-xs">
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

                    <!-- pengumuman (IKON TOA/SPEAKER) -->
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

        <!-- KONTEN UTAMA -->
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

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-6 sm:p-8 space-y-6">
                
                <!-- Header Banner -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm animate-fade-in flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Pusat Informasi Warga Kos</h1>
                        <p class="text-sm text-slate-500 mt-1 max-w-xl leading-relaxed">
                            Arsip pengumuman resmi dan pemberitahuan penting dari pengelola kosan. Klik kartu untuk membaca selengkapnya.
                        </p>
                    </div>
                    <div class="px-4 py-2 bg-slate-100 rounded-2xl text-xs font-bold text-slate-700 border border-slate-200/60 shrink-0">
                        Total Aktif: {{ $pengumumans->total() }} Siaran
                    </div>
                </div>

                <!-- Hidden Textarea Trick untuk menangani line-break aman -->
                @foreach($pengumumans as $p)
                    <textarea id="detail_judul_{{ $p->id }}" class="hidden">{{ $p->judul }}</textarea>
                    <textarea id="detail_kategori_{{ $p->id }}" class="hidden">{{ $p->kategori }}</textarea>
                    <textarea id="detail_waktu_{{ $p->id }}" class="hidden">{{ $p->created_at->translatedFormat('d F Y - H:i') }}</textarea>
                    <textarea id="detail_isi_{{ $p->id }}" class="hidden">{{ $p->isi_pengumuman }}</textarea>
                @endforeach

                <!-- Grid Pengumuman Full (Anti Menumpuk dengan Pagination) -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 animate-fade-in">
                    @forelse($pengumumans as $p)
                    <div onclick="openDetailModal({{ $p->id }})" class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col h-full cursor-pointer group">
                        
                        <div class="flex items-start justify-between mb-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-[10px] font-bold uppercase tracking-wider
                                {{ $p->kategori == 'Penting' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 
                                   ($p->kategori == 'Tagihan' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 
                                   'bg-sky-50 text-sky-700 border border-sky-200') }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $p->kategori == 'Penting' ? 'bg-rose-500 animate-pulse' : ($p->kategori == 'Tagihan' ? 'bg-emerald-500' : 'bg-sky-500') }}"></span>
                                {{ $p->kategori }}
                            </span>
                            <span class="text-[10px] font-semibold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">{{ $p->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="flex-1 mb-4">
                            <h4 class="text-base font-bold text-slate-900 leading-snug mb-2 group-hover:text-indigo-600 transition-colors">{{ $p->judul }}</h4>
                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">{{ $p->isi_pengumuman }}</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-slate-700">
                            <span class="text-indigo-600 group-hover:underline flex items-center gap-1">
                                Baca Selengkapnya 
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full bg-white rounded-3xl border border-dashed border-slate-300 p-12 text-center shadow-sm">
                        <h4 class="text-base font-bold text-slate-900">Belum Ada Pengumuman</h4>
                        <p class="text-xs text-slate-500 mt-1">Saat ini belum ada siaran informasi yang aktif dari pengelola kosan.</p>
                    </div>
                    @endforelse
                </div>

                <!-- PAGINATION LINKS -->
                <div class="mt-8 pt-4 pb-12 flex justify-center">
                    {{ $pengumumans->links() }}
                </div>

            </div>
        </main>
    </div>

    <!-- ========================================== -->
    <!-- MODAL DETAIL PENGUMUMAN (POP-UP) -->
    <!-- ========================================== -->
    <div id="modalOverlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden transition-opacity opacity-0 duration-300"></div>
    
    <div id="modalDetailBox" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4 cursor-pointer" onclick="closeDetailModal()">
            <div class="bg-white rounded-3xl shadow-2xl border border-slate-200/80 overflow-hidden modal-enter w-full max-w-xl p-6 sm:p-8 cursor-default" onclick="event.stopPropagation()">
                
                <div class="flex justify-between items-start pb-4 mb-4 border-b border-slate-100 gap-4">
                    <div>
                        <div id="modalBadgeKategori" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-[10px] font-bold uppercase tracking-wider mb-2"></div>
                        <h3 id="modalJudul" class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight leading-snug"></h3>
                        <p id="modalWaktu" class="text-xs text-slate-400 mt-1"></p>
                    </div>
                    <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="py-2 max-h-[60vh] overflow-y-auto pr-2">
                    <p id="modalIsi" class="text-sm text-slate-700 leading-relaxed whitespace-pre-line"></p>
                </div>

                <div class="pt-5 border-t border-slate-100 mt-6 flex justify-end">
                    <button type="button" onclick="closeDetailModal()" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition-all">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT JS -->
    <script>
        const overlay = document.getElementById('modalOverlay');
        const modalBox = document.getElementById('modalDetailBox');

        function openDetailModal(id) {
            const judul = document.getElementById('detail_judul_' + id).value;
            const kategori = document.getElementById('detail_kategori_' + id).value;
            const waktu = document.getElementById('detail_waktu_' + id).value;
            const isi = document.getElementById('detail_isi_' + id).value;

            document.getElementById('modalJudul').innerText = judul;
            document.getElementById('modalWaktu').innerText = 'Dipublikasikan pada: ' + waktu;
            document.getElementById('modalIsi').innerText = isi;

            const badge = document.getElementById('modalBadgeKategori');
            badge.innerText = kategori;
            if (kategori === 'Penting') {
                badge.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-rose-50 text-rose-700 border border-rose-200 text-[10px] font-bold uppercase tracking-wider';
            } else if (kategori === 'Tagihan') {
                badge.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold uppercase tracking-wider';
            } else {
                badge.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-sky-50 text-sky-700 border border-sky-200 text-[10px] font-bold uppercase tracking-wider';
            }

            overlay.classList.remove('hidden');
            modalBox.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                modalBox.querySelector('.bg-white').classList.remove('modal-leave-active');
                modalBox.querySelector('.bg-white').classList.add('modal-enter-active');
            }, 10);
        }

        function closeDetailModal() {
            const content = modalBox.querySelector('.bg-white');
            overlay.classList.add('opacity-0');
            content.classList.remove('modal-enter-active');
            content.classList.add('modal-leave-active');
            setTimeout(() => {
                overlay.classList.add('hidden');
                modalBox.classList.add('hidden');
                content.classList.remove('modal-leave-active');
            }, 200);
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeDetailModal();
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
    </script>
</body>
</html>