<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Portal - Kosan Pak Lalan</title>
    
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

        /* Typewriter Cursor */
        .typing-cursor::after {
            content: '|';
            color: #38bdf8;
            animation: blink 0.9s step-start infinite;
        }
        @keyframes blink { 50% { opacity: 0; } }

        /* Transisi Konten Dalam Form */
        .slide-active #login-content {
            opacity: 0;
            pointer-events: none;
            transform: translateX(-1.5rem) scale(0.97);
            transition-delay: 0ms;
            z-index: 0;
        }
        .slide-active #forgot-content {
            opacity: 1;
            pointer-events: auto;
            transform: translateX(0) scale(1);
            transition-delay: 200ms;
            z-index: 10;
        }
        
        /* Default state form */
        #forgot-content {
            opacity: 0;
            pointer-events: none;
            transform: translateX(1.5rem) scale(0.97);
            transition-delay: 0ms;
            z-index: 0;
        }
        #login-content {
            opacity: 1;
            transform: translateX(0) scale(1);
            transition-delay: 200ms;
            z-index: 10;
        }
    </style>
</head>
<body class="bg-[#FAFAFA] text-slate-800 antialiased selection:bg-slate-900 selection:text-white overflow-x-hidden min-h-screen">
    
    <!-- WRAPPER UTAMA -->
    <div id="main-wrapper" class="min-h-screen relative w-full flex">
        
        <!-- ========================================== -->
        <!-- SISI KIRI: PANEL FORM (Animasi Geser Dihapus) -->
        <!-- ========================================== -->
        <div id="form-panel" class="absolute top-0 left-0 w-full lg:w-1/2 min-h-screen lg:h-screen flex flex-col justify-center items-center p-6 sm:p-10 z-30 overflow-y-auto">
            
            <!-- Link Balik ke Beranda -->
            <div class="w-full max-w-md mb-6 flex justify-between items-center">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-900 text-xs font-semibold rounded-xl border border-slate-200/80 shadow-sm transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Balik ke Beranda</span>
                </a>
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                    Portal Masuk
                </span>
            </div>

            <!-- CARD FORM MINIMALISM -->
            <div class="w-full max-w-md bg-white p-8 sm:p-10 rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/50 relative z-10">
                
                <!-- Brand Header -->
                <div class="flex items-center gap-3.5 pb-6 mb-6 border-b border-slate-100">
                    <div class="w-11 h-11 bg-slate-900 text-white rounded-xl flex items-center justify-center font-bold text-base shadow-sm shrink-0">
                        KL
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900 tracking-tight leading-none">KOSAN LALAN</h1>
                        <span class="text-xs text-slate-400 font-medium mt-0.5 inline-block">Sistem Manajemen Kos</span>
                    </div>
                </div>

                <!-- WRAPPER KONTEN (Pakai Grid Trick) -->
                <div class="relative w-full grid" style="grid-template-columns: 1fr;">
                    
                    <!-- ================================== -->
                    <!-- 1. KONTEN LOGIN -->
                    <!-- ================================== -->
                    <div id="login-content" class="row-start-1 col-start-1 w-full transition-all duration-500 ease-out">
                        <div class="mb-6">
                            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Masuk Portal</h2>
                            <p class="text-slate-500 font-normal mt-1 text-sm">Ketik username & kata sandi akun Anda.</p>
                        </div>

                        <!-- Status Alert -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        @if (session('sukses'))
                            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-3">
                                <span class="w-6 h-6 rounded-full bg-emerald-200 text-emerald-800 flex items-center justify-center shrink-0 text-xs font-bold">✓</span>
                                <p>{{ session('sukses') }}</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="space-y-5">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Username</label>
                                <input type="text" name="username" value="{{ old('username') }}" required autofocus placeholder="Masukkan username Anda" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
                                <x-input-error :messages="$errors->get('username')" class="mt-2 text-rose-600 bg-rose-50 border border-rose-200 px-3 py-1.5 rounded-lg text-xs font-medium" />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi</label>
                                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-600 bg-rose-50 border border-rose-200 px-3 py-1.5 rounded-lg text-xs font-medium" />
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="remember" class="w-4 h-4 border-slate-300 rounded text-slate-900 focus:ring-slate-900 cursor-pointer">
                                    <span class="ml-2 text-xs text-slate-600 font-medium group-hover:text-slate-900 transition-colors">Ingat Saya</span>
                                </label>
                                
                                <!-- TRIGGER GANTI KE LUPA SANDI -->
                                <button type="button" onclick="toggleSlide()" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition-colors">
                                    Lupa Sandi?
                                </button>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                                    <span>Masuk Sekarang</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- ================================== -->
                    <!-- 2. KONTEN LUPA PASSWORD -->
                    <!-- ================================== -->
                    <div id="forgot-content" class="row-start-1 col-start-1 w-full transition-all duration-500 ease-out flex flex-col justify-center relative">
                        
                        <div class="mb-6">
                            <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700 uppercase tracking-wider mb-2">
                                Bantuan Akun
                            </span>
                            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Lupa Kata Sandi?</h2>
                            <p class="text-slate-500 font-normal mt-1 text-sm">Hubungi Admin Kos Lalan untuk bantuan reset kata sandi akun Anda.</p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 mb-6">
                            <p class="text-xs text-slate-600 leading-relaxed mb-4 text-center">
                                Klik tombol di bawah untuk langsung menghubungi Admin melalui WhatsApp resmi.
                            </p>
                            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Kos%20Lalan,%20saya%20ingin%20meminta%20bantuan%20reset%20password." target="_blank" class="w-full flex items-center justify-center gap-2.5 py-3.5 bg-[#25D366] hover:bg-[#20bd5a] text-white text-sm font-bold rounded-xl shadow-sm transition-all">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                <span>Chat Admin via WhatsApp</span>
                            </a>
                        </div>
                        
                        <button type="button" onclick="toggleSlide()" class="w-full py-3 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-all">
                            ← Kembali ke Login
                        </button>
                    </div>

                </div> <!-- End Wrapper Konten -->
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SISI KANAN: PANEL GAMBAR (Animasi Geser Dihapus) -->
        <!-- ========================================== -->
        <div id="image-panel" class="hidden lg:block absolute top-0 right-0 w-1/2 h-screen z-20 pointer-events-none border-l border-slate-200/80">
            
            <div class="absolute inset-0 pointer-events-auto bg-slate-950 flex flex-col items-center justify-center p-12 text-center overflow-hidden">
                <!-- Background Image with Gradient Overlay -->
                <img src="{{ asset('images/kos.jpeg') }}" alt="Bangunan Kos Lalan" class="absolute inset-0 w-full h-full object-cover z-0 opacity-25 filter blur-[1px]">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/70 to-slate-950/90"></div>
                
                <!-- Glassmorphic Card Showcase -->
                <div class="relative z-20 p-10 max-w-lg text-white bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl shadow-2xl text-left">
                    <!-- Typewriter Text Header -->
                    <h2 id="typewriter-text" class="typing-cursor text-3xl sm:text-4xl font-extrabold tracking-tight mb-4 leading-snug text-white min-h-[96px] whitespace-pre-line"></h2>
                    
                    <p class="text-sm text-slate-300 font-normal leading-relaxed border-t border-white/10 pt-4">
                        Sistem informasi modern untuk memantau kamar, penghuni, tagihan, serta pengaduan secara <span class="text-white font-semibold">real-time</span> khusus Kos Lalan.
                    </p>

                    <!-- Feature Badges -->
                    <div class="mt-6 pt-4 border-t border-white/10 grid grid-cols-2 gap-3">
                        <div class="bg-white/5 border border-white/10 p-3 rounded-2xl">
                            <div class="text-xs font-semibold text-white">Akses Cepat</div>
                            <div class="text-[11px] text-slate-400">Langsung ke Dashboard</div>
                        </div>
                        <div class="bg-white/5 border border-white/10 p-3 rounded-2xl">
                            <div class="text-xs font-semibold text-white">Terintegrasi</div>
                            <div class="text-[11px] text-slate-400">Admin & Penghuni</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- SCRIPT ANIMASI & EFEK MESIN TIK -->
    <script>
        // FUNGSI GANTI KONTEN FORM
        function toggleSlide() {
            const wrapper = document.getElementById('main-wrapper');
            wrapper.classList.toggle('slide-active');
        }

        // MESIN TIK SMOOTH
        document.addEventListener('DOMContentLoaded', function() {
            const textToType = "Kelola Kos Cerdas,\nNyaman & Terpadu.";
            const targetElement = document.getElementById('typewriter-text');
            
            let i = 0;
            let isDeleting = false;

            function typeWriterSmooth() {
                let currentText = textToType.substring(0, i);
                targetElement.textContent = currentText;

                let typeSpeed = isDeleting ? 40 : 80;

                if (!isDeleting && i === textToType.length) {
                    typeSpeed = 2500; 
                    isDeleting = true; 
                } else if (isDeleting && i === 0) {
                    isDeleting = false; 
                    typeSpeed = 500; 
                }

                if (isDeleting) { i--; } else { i++; }
                setTimeout(typeWriterSmooth, typeSpeed);
            }

            setTimeout(typeWriterSmooth, 400); 
        });
    </script>
</body>
</html>