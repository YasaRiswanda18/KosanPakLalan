<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kosan Pak Lalan - Eksklusif & Strategis</title>
    
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

        /* Modal Transition */
        .modal-enter {
            display: flex !important;
            animation: modalFadeIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.97) translateY(8px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-slate-900 selection:text-white overflow-x-hidden bg-[#FAFAFA]">

    <!-- ============================================== -->
    <!-- NAVBAR (MINIMALIST GLASS) -->
    <!-- ============================================== -->
    <header class="fixed w-full z-40 top-0 bg-white/85 backdrop-blur-md border-b border-slate-200/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-bold text-base shadow-sm group-hover:bg-slate-800 transition-colors">
                    KL
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-lg text-slate-900 tracking-tight group-hover:text-slate-700 transition-colors">KOSAN LALAN</span>
                    <span class="text-[11px] text-slate-400 font-medium tracking-wide uppercase">Eksklusif & Strategis</span>
                </div>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                    <span>Masuk Portal</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- ============================================== -->
    <!-- HERO SECTION (CLEAN MINIMALISM) -->
    <!-- ============================================== -->
    <section class="relative pt-36 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-slate-200/50 blur-[120px] rounded-full pointer-events-none -z-10"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <div class="lg:col-span-7 text-center lg:text-left">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.12] mb-6 min-h-[96px] sm:min-h-[110px] lg:min-h-[136px]">
                        <span id="typed-hero"></span>
                    </h1>
                    <p class="text-base sm:text-lg text-slate-600 font-normal leading-relaxed max-w-xl mx-auto lg:mx-0 mb-10">
                        Fasilitas lengkap, manajemen cerdas, dan lingkungan tenang untuk kenyamanan istirahat dan produktivitas Anda setiap hari.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                        <a href="#tipe-kamar" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm rounded-xl shadow-sm hover:shadow-lg hover:shadow-slate-900/10 transition-all duration-200">
                            <span>Lihat Kamar</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </a>
                        <a href="#kontak" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-sm rounded-xl border border-slate-200 shadow-sm hover:border-slate-300 transition-all duration-200">
                            <span>Lokasi & Kontak</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                        </a>
                    </div>
                    <div class="mt-12 pt-8 border-t border-slate-200/80 grid grid-cols-3 gap-4 max-w-md mx-auto lg:mx-0">
                        <div>
                            <div class="text-xl font-bold text-slate-900">100%</div>
                            <div class="text-xs text-slate-500 font-medium mt-0.5">Siap Huni</div>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-slate-900">Aman</div>
                            <div class="text-xs text-slate-500 font-medium mt-0.5">Lingkungan Tenang</div>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-slate-900">Strategis</div>
                            <div class="text-xs text-slate-500 font-medium mt-0.5">Akses Mudah</div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 relative mt-6 lg:mt-0">
                    <div class="relative rounded-3xl overflow-hidden bg-white p-2.5 border border-slate-200/80 shadow-xl shadow-slate-200/50 group">
                        <div class="relative rounded-2xl overflow-hidden h-[380px] lg:h-[480px]">
                            <img src="{{ asset('images/kosan.png') }}" alt="Depan Kosan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between bg-white/90 backdrop-blur-md border border-white/60 p-3.5 rounded-xl shadow-lg">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                                    <span class="text-xs font-bold text-slate-900 tracking-wide uppercase">Tampak Depan Kosan</span>
                                </div>
                                <span class="text-[11px] font-medium text-slate-500">Garut, Jawa Barat</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- GALERI & SUASANA (DENGAN SCROLL REVEAL) -->
    <!-- ============================================== -->
    <section class="py-24 bg-white border-y border-slate-200/80 overflow-hidden">
        <!-- Tambahin class scroll-reveal opacity-0 translate-y-12 -->
        <div class="max-w-7xl mx-auto px-6 scroll-reveal opacity-0 translate-y-12 transition-all duration-[1000ms] ease-out">
            <div class="max-w-2xl mx-auto text-center mb-16">
                <span class="text-xs font-bold tracking-widest text-slate-400 uppercase">Suasana Hunian</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-2 mb-4">Intip Suasana Kosan Lalan</h2>
                <p class="text-base text-slate-600">Bersih, rapi, dan fasilitas bersama selalu terawat demi kenyamanan setiap penghuni.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div class="md:col-span-2 md:row-span-2 group relative overflow-hidden rounded-2xl bg-slate-100 border border-slate-200/80 h-72 md:h-[460px]">
                    <img src="{{ asset('images/ruangan.png') }}" alt="ruangan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-slate-950/20 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5">
                        <span class="inline-block px-3 py-1 bg-white/90 backdrop-blur-md rounded-lg text-xs font-bold text-slate-900 mb-1.5 shadow-sm">Ruangan</span>
                        <p class="text-xs text-slate-200 font-medium">Pencahayaan maksimal dan sirkulasi udara aman</p>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-2xl bg-slate-100 border border-slate-200/80 h-56 md:h-[220px]">
                    <img src="{{ asset('images/dapur.png') }}" alt="Dapur" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="inline-block px-2.5 py-1 bg-white/90 backdrop-blur-md rounded-md text-xs font-bold text-slate-900 shadow-sm">Dapur</span>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-2xl bg-slate-100 border border-slate-200/80 h-56 md:h-[220px]">
                    <img src="{{ asset('images/wc.png') }}" alt="Kamar Mandi" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="inline-block px-2.5 py-1 bg-white/90 backdrop-blur-md rounded-md text-xs font-bold text-slate-900 shadow-sm">WC Bersih</span>
                    </div>
                </div>
                <div class="md:col-span-2 group relative overflow-hidden rounded-2xl bg-slate-100 border border-slate-200/80 h-56 md:h-[220px]">
                    <img src="{{ asset('images/parkiran.jpeg') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="inline-block px-2.5 py-1 bg-white/90 backdrop-blur-md rounded-md text-xs font-bold text-slate-900 shadow-sm">Parkiran Luas</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- TIPE KAMAR (DENGAN SCROLL REVEAL) -->
    <!-- ============================================== -->
    <section id="tipe-kamar" class="py-24 bg-[#FAFAFA] overflow-hidden">
        <!-- Tambahin class scroll-reveal opacity-0 translate-y-12 -->
        <div class="max-w-6xl mx-auto px-6 scroll-reveal opacity-0 translate-y-12 transition-all duration-[1000ms] ease-out">
            <div class="max-w-2xl mx-auto text-center mb-16">
                <span class="text-xs font-bold tracking-widest text-slate-400 uppercase">Tipe Kamar</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-2 mb-4">Pilihan Kamar Kamu</h2>
                <p class="text-base text-slate-600">Klik kartu untuk melihat rincian fasilitas super lengkapnya.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 items-stretch">
                <!-- CARD 1: STANDAR ROOM -->
                <div onclick="bukaModal('modal-standar')" class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-xl hover:border-slate-300 transition-all duration-300 cursor-pointer group flex flex-col">
                    <div class="h-64 grid grid-cols-3 gap-1 bg-slate-100 p-1 relative overflow-hidden">
                        <div class="col-span-2 relative overflow-hidden rounded-l-2xl">
                            <img src="{{ asset('images/ruanganstandar.png') }}">
                        </div>
                        <div class="col-span-1 grid grid-rows-2 gap-1">
                            <div class="relative overflow-hidden rounded-tr-2xl">
                                <img src="{{ asset('images/kamarstandar.png') }}">
                            </div>
                            <div class="relative overflow-hidden rounded-br-2xl">
                                <img src="{{ asset('images/wc.png') }}">
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-slate-900/30 backdrop-blur-[2px] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="bg-white/95 text-slate-900 text-xs font-bold px-4 py-2 rounded-xl shadow-lg flex items-center gap-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform">
                                <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <span>Lihat Detail Fasilitas</span>
                            </span>
                        </div>
                    </div>
                    <div class="p-8 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">3x3 Meter</span>
                                <span class="text-xs font-medium text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-200/60">Tersedia</span>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-900 mb-2">Standar Kos</h3>
                            <p class="text-sm text-slate-500 mb-6">Pilihan hemat dan nyaman.</p>
                        </div>
                        <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-slate-400 uppercase font-medium">Harga Sewa</span>
                                <div class="text-2xl font-extrabold text-slate-900">Rp 650.000 <span class="text-xs font-normal text-slate-500">/ bulan</span></div>
                            </div>
                            <span class="w-10 h-10 rounded-xl bg-slate-50 group-hover:bg-slate-900 group-hover:text-white text-slate-700 flex items-center justify-center border border-slate-200 group-hover:border-slate-900 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: VIP ROOM -->
                <div onclick="bukaModal('modal-vip')" class="bg-white rounded-3xl border-2 border-slate-900/90 overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer group flex flex-col relative">
                    <div class="absolute top-4 left-4 z-20 bg-slate-900 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md flex items-center gap-1.5">
                    </div>
                    <div class="h-64 grid grid-cols-3 gap-1 bg-slate-100 p-1 relative overflow-hidden">
                        <div class="col-span-2 relative overflow-hidden rounded-l-2xl">
                            <img src="{{ asset('images/ruangan.png') }}" alt="Ruangan Kamar" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        </div>
                        <div class="col-span-1 grid grid-rows-2 gap-1">
                            <div class="relative overflow-hidden rounded-tr-2xl">
                                <img src="{{ asset('images/kamar.png') }}" alt="Living Area" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            </div>
                            <div class="relative overflow-hidden rounded-br-2xl">
                                <img src="{{ asset('images/wc.png') }}" alt="WC Dalam" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-slate-900/30 backdrop-blur-[2px] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="bg-white/95 text-slate-900 text-xs font-bold px-4 py-2 rounded-xl shadow-lg flex items-center gap-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform">
                                <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <span>Lihat Detail Fasilitas</span>
                            </span>
                        </div>
                    </div>
                    <div class="p-8 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">4x4 Meter</span>
                                <span class="text-xs font-medium text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-md border border-amber-200/60">Eksklusif</span>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-900 mb-2">Kos VIP</h3>
                            <p class="text-sm text-slate-500 mb-6">Ruangan ekstra luas</p>
                        </div>
                        <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-slate-400 uppercase font-medium">Harga Sewa</span>
                                <div class="text-2xl font-extrabold text-slate-900">Rp 850.000 <span class="text-xs font-normal text-slate-500">/ bulan</span></div>
                            </div>
                            <span class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- LOKASI & KONTAK (DENGAN SCROLL REVEAL) -->
    <!-- ============================================== -->
    <section id="kontak" class="py-24 bg-white border-t border-slate-200/80 overflow-hidden">
        <div class="max-w-6xl mx-auto px-6">
            <!-- Tambahin class scroll-reveal opacity-0 translate-y-12 -->
            <div class="grid lg:grid-cols-12 gap-12 items-center scroll-reveal opacity-0 translate-y-12 transition-all duration-[1000ms] ease-out">
                
                <div class="lg:col-span-6">
                    <span class="text-xs font-bold tracking-widest text-slate-400 uppercase">Hubungi Pengelola</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-2 mb-4">Minat Ngekos?</h2>
                    <p class="text-base text-slate-600 mb-8 leading-relaxed">
                        Jangan sampai kehabisan kamar! Langsung hubungi Pak Lalan via WhatsApp untuk janjian survei lokasi sekarang juga.
                    </p>
                    
                    <div class="mb-8 p-5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200/80 text-slate-700 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Lokasi Kita</h4>
                            <p class="text-sm text-slate-600 mt-1 leading-relaxed">
                                Jl. Cijati Asri Jayawaras Kec. Tarogong Kidul, Kabupaten Garut, Jawa Barat 44151<br>
                                <span class="text-slate-500 font-medium">Perumahan Cijati Asri Kosan Pak Lalan</span>
                            </p>
                        </div>
                    </div>

                    <a href="https://wa.me/6282110163205?text=Halo%20Pak%20Lalan,%20saya%20tertarik%20dengan%20kamar%20kosannya." target="_blank" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-[#25D366] hover:bg-[#20bd5a] text-white font-bold text-sm tracking-wide rounded-xl shadow-sm hover:shadow-md transition-all duration-200 w-full sm:w-auto">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        <span>CHAT WHATSAPP</span>
                    </a>
                </div>

                <div class="lg:col-span-6">
                    <div class="h-[380px] w-full rounded-3xl overflow-hidden border border-slate-200/80 bg-white p-2 shadow-sm">
                        <div class="w-full h-full rounded-2xl overflow-hidden relative">
                            <iframe src="https://www.google.com/maps/embed?pb=!4v1786828455189!6m8!1m7!1s6277B_FKrK8irFHeZO4qgw!2m2!1d-7.208838030695027!2d107.8933190213667!3f153.82080548712665!4f-18.106931647398326!5f0.7820865974627469" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- FOOTER -->
    <!-- ============================================== -->
    <footer class="bg-slate-900 py-12 text-center text-white scroll-reveal opacity-0 translate-y-12 transition-all duration-[1000ms] ease-out">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center font-bold text-sm text-white">
                    KL
                </div>
                <span class="font-bold text-sm tracking-tight text-white">KOSAN LALAN © 2026</span>
            </div>
            <p class="text-xs text-slate-400 font-medium">Sistem Manajemen Kos - Hunian Bersih, Rapi, & Nyaman.</p>
        </div>
    </footer>

    <!-- (KODINGAN MODAL POP-UP KAMAR TETAP AMAN DI SINI) -->
    <!-- Modal Standar -->
    <div id="modal-standar" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 transition-all">
        <div class="bg-white rounded-3xl w-full max-w-2xl border border-slate-200 shadow-2xl relative overflow-hidden flex flex-col max-h-[90vh]">
            <button onclick="tutupModal('modal-standar')" class="absolute top-4 right-4 z-20 w-9 h-9 bg-white/90 hover:bg-white text-slate-700 hover:text-slate-900 rounded-full flex items-center justify-center shadow-md backdrop-blur-sm transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
            <div class="h-60 grid grid-cols-3 gap-1 bg-slate-100 shrink-0">
                <div class="col-span-2 relative overflow-hidden"><img src="{{ asset('images/ruanganstandar.png') }}" alt="Kamar" class="w-full h-full object-cover"><span class="absolute bottom-3 left-3 bg-slate-900/80 backdrop-blur-md text-white text-[11px] font-semibold px-2.5 py-1 rounded-md">ruangan</span></div>
                <div class="col-span-1 grid grid-rows-2 gap-1"><div class="relative overflow-hidden"><img src="{{ asset('images/kamarstandar.png') }}" alt="Dapur" class="w-full h-full object-cover"><span class="absolute bottom-2 left-2 bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-semibold px-2 py-0.5 rounded-md">kamar</span></div><div class="relative overflow-hidden"><img src="{{ asset('images/wc.png') }}" alt="WC" class="w-full h-full object-cover"><span class="absolute bottom-2 left-2 bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-semibold px-2 py-0.5 rounded-md">WC</span></div></div>
            </div>
            <div class="p-8 overflow-y-auto">
                <div class="flex items-center justify-between mb-2"><span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">Ukuran 3x3 Meter</span><span class="text-xs font-medium text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-200/60">Tersedia</span></div>
                <h3 class="text-3xl font-extrabold text-slate-900 mb-1">Standar Kos</h3>
                <p class="text-2xl font-bold text-emerald-600 mb-6">Rp 650.000 <span class="text-sm font-normal text-slate-500">/ bulan</span></p>
                <div class="bg-slate-50 border border-slate-200/80 p-6 rounded-2xl mb-6">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Fasilitas Kamar</h4>
                    <ul class="grid grid-cols-2 gap-3.5 text-slate-700 text-sm font-medium">
                        <li class="flex items-center gap-2.5"><span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg></span>Ruangan besar</li>
                        <li class="flex items-center gap-2.5"><span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg></span>tempat dapur</li>
                        <li class="flex items-center gap-2.5"><span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg></span>WC dalam</li>
                        <li class="flex items-center gap-2.5"><span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg></span>Free  Air</li>
                    </ul>
                </div>
                <a href="https://wa.me/6281234567890?text=Halo%20Pak%20Lalan,%20saya%20tertarik%20dengan%20kamar%20Standar%20Room." target="_blank" class="w-full py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm rounded-xl transition-colors flex items-center justify-center gap-2"><span>Tanya Ketersediaan Standar Room</span><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg></a>
            </div>
        </div>
    </div>

    <!-- Modal VIP -->
    <div id="modal-vip" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 transition-all">
        <div class="bg-white rounded-3xl w-full max-w-2xl border border-slate-200 shadow-2xl relative overflow-hidden flex flex-col max-h-[90vh]">
            <button onclick="tutupModal('modal-vip')" class="absolute top-4 right-4 z-20 w-9 h-9 bg-white/90 hover:bg-white text-slate-700 hover:text-slate-900 rounded-full flex items-center justify-center shadow-md backdrop-blur-sm transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
            <div class="h-60 grid grid-cols-3 gap-1 bg-slate-100 shrink-0">
                <div class="col-span-2 relative overflow-hidden"><img src="{{ asset('images/ruangan.png') }}" alt="Ruangan" class="w-full h-full object-cover"><span class="absolute bottom-3 left-3 bg-slate-900/80 backdrop-blur-md text-white text-[11px] font-semibold px-2.5 py-1 rounded-md">Ruangan</span></div>
                <div class="col-span-1 grid grid-rows-2 gap-1"><div class="relative overflow-hidden"><img src="{{ asset('images/kamar.png') }}" alt="Living Area" class="w-full h-full object-cover"><span class="absolute bottom-2 left-2 bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-semibold px-2 py-0.5 rounded-md">Kamar Area</span></div><div class="relative overflow-hidden"><img src="{{ asset('images/wc.png') }}" alt="WC Dalam" class="w-full h-full object-cover"><span class="absolute bottom-2 left-2 bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-semibold px-2 py-0.5 rounded-md">WC Dalam</span></div></div>
            </div>
            <div class="p-8 overflow-y-auto">
                <div class="flex items-center justify-between mb-2"><span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">Ukuran 4x4 Meter</span><span class="text-xs font-medium text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-md border border-amber-200/60"></span></div>
                <h3 class="text-3xl font-extrabold text-slate-900 mb-1">VIP Kos </h3>
                <p class="text-2xl font-bold text-slate-900 mb-6">Rp 850.000 <span class="text-sm font-normal text-slate-500">/ bulan</span></p>
                <div class="bg-slate-50 border border-slate-200/80 p-6 rounded-2xl mb-6">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Fasilitas Eksklusif</h4>
                    <ul class="grid grid-cols-2 gap-3.5 text-slate-700 text-sm font-medium">
                        <li class="flex items-center gap-2.5"><span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg></span>Ruangan Besar</li>
                        <li class="flex items-center gap-2.5"><span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg></span>ada tempat dapur</li>
                        <li class="flex items-center gap-2.5"><span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg></span>WC Dalam Eksklusif</li>
                        <li class="flex items-center gap-2.5"><span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg></span>Free  Air</li>
                    </ul>
                </div>
                <a href="https://wa.me/6281234567890?text=Halo%20Pak%20Lalan,%20saya%20tertarik%20dengan%20kamar%20VIP%20Room." target="_blank" class="w-full py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm rounded-xl transition-colors flex items-center justify-center gap-2"><span>Tanya Ketersediaan VIP Kos</span><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg></a>
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- SCRIPT LOGIKA HALAMAN & ANIMASI -->
    <!-- ============================================== -->
    
    <!-- 1. Script Preloader (Muncul Pas Buka Web) -->
    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            setTimeout(() => {
                preloader.classList.add('opacity-0');
                setTimeout(() => { preloader.style.display = 'none'; }, 700); 
            }, 800);
        });
    </script>

    <!-- 2. Script Fade-Up Animation Pas di Scroll -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Settingan kapan pop-up nya kepicu (threshold 0.15 = 15% elemen udah masuk layar)
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15 
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Kalo masuk layar, hapus class sembunyi, tambah class nampil
                        entry.target.classList.remove('opacity-0', 'translate-y-12');
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        // Biar cuma animasi sekali, habis itu berhenti dipantau
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Nyari semua elemen yang punya class 'scroll-reveal' buat dianimasiin
            const revealElements = document.querySelectorAll('.scroll-reveal');
            revealElements.forEach(el => observer.observe(el));
        });
    </script>

    <!-- 3. Script Modal Detail Kamar -->
    <script>
        function bukaModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('modal-enter');
                document.body.style.overflow = 'hidden';
            }
        }
        function tutupModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('modal-enter');
                document.body.style.overflow = 'auto';
            }
        }
        window.addEventListener('click', function(event) {
            if (event.target.id === 'modal-standar') tutupModal('modal-standar');
            if (event.target.id === 'modal-vip') tutupModal('modal-vip');
        });
        window.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                tutupModal('modal-standar');
                tutupModal('modal-vip');
            }
        });
    </script>

    <!-- 4. Typed.js untuk Animasi Mesin Ketik di Header -->
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var typed = new Typed('#typed-hero', {
                strings: ['Tinggal Nyaman,<br><span class="text-slate-500 font-normal">Fokus Masa Depan!</span>'],
                typeSpeed: 60,
                backSpeed: 30,
                backDelay: 2500,
                startDelay: 500,
                loop: true,
                showCursor: true,
                cursorChar: '|'
            });
        });
    </script>

</body>
</html>