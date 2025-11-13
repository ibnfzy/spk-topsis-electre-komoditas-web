<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SPK Komoditas Tambak Air Payau</title>
    <meta name="description" content="Sistem pendukung keputusan komoditas tambak air payau dengan metode TOPSIS dan ELECTRE">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="bg-slate-900 text-white antialiased">
    <div class="relative overflow-hidden min-h-screen">
        <div class="absolute inset-0 bg-gradient-to-br from-sky-500/10 via-emerald-500/5 to-transparent"></div>
        <header class="relative">
            <nav class="max-w-7xl mx-auto flex items-center justify-between px-6 py-6">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-sky-500 to-emerald-400 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                        <span class="text-xl font-semibold">SPK</span>
                    </div>
                    <div>
                        <p class="text-lg font-semibold">SPK Komoditas Tambak</p>
                        <p class="text-sm text-slate-300">TOPSIS &amp; ELECTRE</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-6 text-sm text-slate-300">
                    <a href="#metode" class="transition hover:text-white">Metode</a>
                    <a href="#fitur" class="transition hover:text-white">Fitur</a>
                    <a href="#tentang" class="transition hover:text-white">Tentang</a>
                    <a href="<?= base_url('login'); ?>" class="inline-flex items-center rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-slate-900 shadow-lg shadow-emerald-500/30 transition hover:-translate-y-1 hover:bg-emerald-400">Masuk</a>
                </div>
            </nav>
        </header>

        <main class="relative">
            <section class="max-w-6xl mx-auto px-6 pt-10 pb-24">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-1 text-sm text-emerald-200">
                            <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Sistem Pendukung Keputusan Modern
                        </span>
                        <h1 class="text-4xl md:text-5xl font-bold leading-tight text-white">
                            Tentukan Komoditas Tambak Air Payau Terbaik dengan Analisis Cerdas
                        </h1>
                        <p class="text-lg text-slate-300">
                            Platform kami membantu pengambil keputusan memilih jenis komoditas unggulan untuk tambak air payau dengan menggabungkan kekuatan metode <span class="font-semibold text-white">TOPSIS</span> dan <span class="font-semibold text-white">ELECTRE</span>. Dapatkan rekomendasi berdasarkan data yang akurat dan objektif.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="<?= base_url('login'); ?>" class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-500 px-6 py-3 text-base font-semibold text-slate-900 shadow-xl shadow-emerald-500/40 transition hover:-translate-y-1 hover:bg-emerald-400">
                                Mulai Analisis
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                </svg>
                            </a>
                            <a href="#tentang" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/20 px-6 py-3 text-base font-semibold text-white transition hover:border-white/40">
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute -top-10 -right-12 h-64 w-64 rounded-full bg-emerald-500/20 blur-3xl"></div>
                        <div class="relative rounded-3xl bg-white/5 p-8 backdrop-blur-xl border border-white/10 shadow-2xl shadow-sky-900/40" style="animation: float-slow 6s ease-in-out infinite;">
                            <div class="grid grid-cols-2 gap-6 text-sm text-slate-200">
                                <div class="space-y-2">
                                    <p class="text-xs uppercase tracking-wide text-emerald-200">Metode</p>
                                    <p class="font-semibold text-white">TOPSIS</p>
                                    <p class="text-slate-400">Menilai alternatif berdasarkan kedekatan relatif dengan solusi ideal.</p>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-xs uppercase tracking-wide text-emerald-200">Metode</p>
                                    <p class="font-semibold text-white">ELECTRE</p>
                                    <p class="text-slate-400">Membandingkan alternatif dengan pendekatan outranking komprehensif.</p>
                                </div>
                                <div class="col-span-2 rounded-2xl border border-white/10 bg-gradient-to-r from-sky-500/20 to-emerald-500/20 p-5">
                                    <p class="text-xs uppercase tracking-wide text-emerald-100">Output</p>
                                    <p class="mt-2 text-lg font-semibold text-white">Rekomendasi Komoditas</p>
                                    <p class="text-slate-300">Analisis menyeluruh yang mempertimbangkan kriteria kualitas air, biaya operasional, risiko penyakit, dan potensi keuntungan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="metode" class="max-w-6xl mx-auto px-6 pb-24">
                <div class="grid lg:grid-cols-3 gap-10">
                    <div class="col-span-1 space-y-4">
                        <h2 class="text-3xl font-bold text-white">Metode Analitis yang Terbukti</h2>
                        <p class="text-slate-300">Kami mengombinasikan dua metode pengambilan keputusan multi-kriteria untuk menghasilkan rekomendasi yang solid dan dapat dipertanggungjawabkan.</p>
                    </div>
                    <div class="lg:col-span-2 grid md:grid-cols-2 gap-6">
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-xl shadow-sky-900/30 transition hover:-translate-y-2 hover:border-emerald-400/40">
                            <h3 class="text-xl font-semibold text-white">Technique for Order Preference by Similarity to Ideal Solution (TOPSIS)</h3>
                            <p class="mt-4 text-slate-300">Mengukur jarak setiap alternatif terhadap solusi ideal positif dan negatif, sehingga memudahkan pemilihan komoditas dengan performa terbaik.</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-xl shadow-sky-900/30 transition hover:-translate-y-2 hover:border-emerald-400/40">
                            <h3 class="text-xl font-semibold text-white">Elimination et Choix Traduisant la Réalité (ELECTRE)</h3>
                            <p class="mt-4 text-slate-300">Menggunakan analisis outranking untuk mengidentifikasi komoditas yang konsisten unggul berdasarkan bobot kriteria yang relevan.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="fitur" class="max-w-6xl mx-auto px-6 pb-24">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-white">Fitur Utama Sistem</h2>
                    <p class="mt-4 text-lg text-slate-300">Dirancang untuk membantu analis, penyuluh perikanan, dan pelaku usaha menentukan strategi budidaya yang optimal.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-lg shadow-sky-900/30 transition hover:-translate-y-2 hover:border-emerald-400/40">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-500/20 text-emerald-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Input Kriteria Fleksibel</h3>
                        <p class="mt-3 text-slate-300">Sesuaikan kriteria seperti salinitas, suhu air, biaya pakan, hingga permintaan pasar sesuai kondisi lokasi tambak Anda.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-lg shadow-sky-900/30 transition hover:-translate-y-2 hover:border-emerald-400/40">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-500/20 text-emerald-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18M9 3v18m6-18v18M3 9h18M3 15h18" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Visualisasi Hasil</h3>
                        <p class="mt-3 text-slate-300">Pantau perbandingan alternatif dengan grafik interaktif dan laporan yang mudah dipahami untuk presentasi cepat.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-lg shadow-sky-900/30 transition hover:-translate-y-2 hover:border-emerald-400/40">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-500/20 text-emerald-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m-9 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v16" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Laporan Komprehensif</h3>
                        <p class="mt-3 text-slate-300">Hasilkan dokumentasi lengkap mengenai perhitungan dan rekomendasi untuk dijadikan acuan tindak lanjut.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-lg shadow-sky-900/30 transition hover:-translate-y-2 hover:border-emerald-400/40">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-500/20 text-emerald-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0-15l3 3m-3-3l-3 3" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Perhitungan Otomatis</h3>
                        <p class="mt-3 text-slate-300">Proses perhitungan bobot, normalisasi, hingga ranking dilakukan secara otomatis dan akurat.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-lg shadow-sky-900/30 transition hover:-translate-y-2 hover:border-emerald-400/40">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-500/20 text-emerald-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.57 0 4.979.722 7.121 1.967M8.25 9a3.75 3.75 0 107.5 0 3.75 3.75 0 00-7.5 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Manajemen Pengguna</h3>
                        <p class="mt-3 text-slate-300">Kelola akses pengguna untuk memastikan integritas data dan kolaborasi tim yang terkontrol.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-lg shadow-sky-900/30 transition hover:-translate-y-2 hover:border-emerald-400/40">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-500/20 text-emerald-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 6.75H17.25M15 4.5L17.25 6.75 15 9m-3.75 10.5H6.75M9 19.5l-2.25-2.25L9 15" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">Integrasi Data Eksternal</h3>
                        <p class="mt-3 text-slate-300">Impor data lingkungan dan produksi dari sumber terpercaya untuk memperkaya analisis Anda.</p>
                    </div>
                </div>
            </section>

            <section id="tentang" class="relative max-w-5xl mx-auto px-6 pb-24">
                <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-sky-500/20 via-slate-900 to-emerald-500/20 p-10 shadow-2xl shadow-sky-900/40">
                    <div class="absolute -top-12 -left-16 h-48 w-48 rounded-full bg-sky-500/20 blur-3xl"></div>
                    <div class="absolute -bottom-14 -right-14 h-56 w-56 rounded-full bg-emerald-500/20 blur-3xl"></div>
                    <div class="relative space-y-6 text-slate-100">
                        <h2 class="text-3xl font-bold text-white">Tentang Platform</h2>
                        <p>
                            Sistem pendukung keputusan ini dikembangkan untuk mendukung pengelolaan tambak air payau yang berkelanjutan. Dengan mengintegrasikan penilaian kuantitatif dan preferensi ahli, platform memberikan rekomendasi komoditas seperti udang vaname, bandeng, atau rumput laut yang sesuai dengan kondisi lingkungan dan target produksi.
                        </p>
                        <p>
                            Metode TOPSIS memastikan komoditas terpilih memiliki performa paling mendekati kriteria ideal, sedangkan ELECTRE memperkuat keputusan dengan analisis outranking yang mempertimbangkan dominasi dan konsistensi antar alternatif.
                        </p>
                        <div class="pt-4">
                            <a href="<?= base_url('login'); ?>" class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-base font-semibold text-slate-900 transition hover:-translate-y-1 hover:bg-slate-200">
                                Masuk untuk Mengelola Data
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9l3 3m0 0l-3 3m3-3H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="relative border-t border-white/5 bg-slate-950/60 py-8">
            <div class="max-w-6xl mx-auto px-6 flex flex-col gap-3 text-center md:flex-row md:items-center md:justify-between">
                <p class="text-sm text-slate-400">&copy; <?= date('Y'); ?> Sistem Pendukung Keputusan Komoditas Tambak Air Payau.</p>
                <p class="text-sm text-slate-500">Ditenagai oleh metode TOPSIS &amp; ELECTRE untuk keputusan yang lebih baik.</p>
            </div>
        </footer>
    </div>
</body>
</html>
