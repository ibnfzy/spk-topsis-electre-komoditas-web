<?= $this->extend('panel/layouts/base_panel'); ?>

<?= $this->section('content'); ?>
<section class="grid gap-6 lg:grid-cols-[1.2fr,0.8fr] items-start">
    <div class="rounded-3xl bg-gradient-to-br from-white via-white to-slate-100/70 shadow-lg shadow-slate-200/40 border border-slate-100 px-8 py-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-3">
                <p class="text-sm font-medium tracking-[0.35em] text-primary/70 uppercase">Ringkasan Sistem</p>
                <h2 class="text-3xl font-semibold text-slate-900 leading-tight">Selamat datang di Panel Analisis Komoditas Tambak</h2>
                <p class="text-slate-500 max-w-2xl">Pantau metrik penting untuk penilaian komoditas tambak dengan metode TOPSIS dan ELECTRE. Data statistik diperbarui secara real-time untuk membantu keputusan lebih akurat.</p>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-primary/20 blur-3xl rounded-full"></div>
                <div class="relative rounded-3xl bg-white px-6 py-5 shadow-floating border border-white/60">
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-[0.25em]">Status Sistem</p>
                    <p class="mt-2 flex items-center gap-2 text-sm font-semibold text-primary">
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Stabil &amp; Terkalibrasi
                    </p>
                    <p class="mt-3 text-xs text-slate-500 leading-relaxed">Terakhir diperbarui <?= esc(date('d M Y, H:i')); ?> WIB</p>
                </div>
            </div>
        </div>
    </div>
    <div class="rounded-3xl bg-white shadow-lg shadow-slate-200/40 border border-slate-100 p-8 space-y-5">
        <p class="text-sm font-semibold text-slate-700">Aktivitas Terakhir</p>
        <ul class="space-y-4 text-sm text-slate-500">
            <li class="flex items-start gap-3">
                <span class="mt-1 h-2 w-2 rounded-full bg-emerald-400"></span>
                <span>Sinkronisasi data komoditas berhasil dilakukan.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="mt-1 h-2 w-2 rounded-full bg-blue-400"></span>
                <span>Perhitungan TOPSIS dan ELECTRE terbaru tersimpan.</span>
            </li>
            <li class="flex items-start gap-3">
                <span class="mt-1 h-2 w-2 rounded-full bg-orange-400"></span>
                <span>Pembaruan bobot kriteria telah diterapkan.</span>
            </li>
        </ul>
        <a href="#" class="inline-flex items-center gap-2 text-sm font-medium text-primary hover:text-primaryDark transition">
            Lihat seluruh log aktivitas
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
            </svg>
        </a>
    </div>
</section>

<section class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
    <?php $statItems = [
        [
            'label' => 'Jumlah Kriteria',
            'value' => $stats['kriteria'] ?? 0,
            'description' => 'Parameter penilaian utama',
            'icon' => 'M12 6v12m6-6H6',
        ],
        [
            'label' => 'Komoditas Tambak',
            'value' => $stats['komoditas'] ?? 0,
            'description' => 'Data kandidat rekomendasi',
            'icon' => 'M4.5 6.75h15m-15 4.5h15m-15 4.5h15',
        ],
        [
            'label' => 'Bobot Kriteria',
            'value' => $stats['bobot_kriteria'] ?? 0,
            'description' => 'Bobot preferensi terdaftar',
            'icon' => 'M12 3v18m9-9H3',
        ],
        [
            'label' => 'Nilai Kriteria',
            'value' => $stats['nilai_kriteria'] ?? 0,
            'description' => 'Penilaian komoditas per kriteria',
            'icon' => 'M4.5 12.75l6 6 9-13.5',
        ],
    ]; ?>
    <?php foreach ($statItems as $item): ?>
        <article class="group rounded-3xl bg-white shadow-lg shadow-slate-200/40 border border-slate-100 px-6 py-7 transition transform hover:-translate-y-1 hover:shadow-floating">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-[0.25em]"><?= esc($item['label']); ?></p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900"><?= esc(number_format((float) $item['value'])); ?></p>
                    <p class="mt-2 text-sm text-slate-500"><?= esc($item['description']); ?></p>
                </div>
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?= $item['icon']; ?>" />
                    </svg>
                </span>
            </div>
        </article>
    <?php endforeach; ?>
</section>

<section class="grid gap-6 lg:grid-cols-[1.2fr,0.8fr]">
    <div class="rounded-3xl bg-white shadow-lg shadow-slate-200/40 border border-slate-100 p-8 space-y-6">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-800">Tren Penilaian</h3>
            <span class="text-xs uppercase text-slate-400 tracking-[0.25em]">Per 30 hari terakhir</span>
        </div>
        <div class="grid gap-4 sm:grid-cols-3 text-sm text-slate-600">
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Rata-Rata Nilai</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900"><?= esc($insights['avg_score'] ?? '0,00'); ?></p>
                <p class="mt-1 text-xs text-emerald-500">+2.3% dibanding periode lalu</p>
            </div>
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Komoditas Unggulan</p>
                <p class="mt-2 text-lg font-semibold text-slate-900"><?= esc($insights['top_commodity'] ?? 'Belum tersedia'); ?></p>
                <p class="mt-1 text-xs text-slate-500">Berdasarkan skor metode gabungan</p>
            </div>
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Metode Terpopuler</p>
                <p class="mt-2 text-lg font-semibold text-slate-900"><?= esc($insights['popular_method'] ?? 'TOPSIS'); ?></p>
                <p class="mt-1 text-xs text-slate-500">Digunakan pada 68% penilaian</p>
            </div>
        </div>
        <div class="rounded-2xl border border-dashed border-primary/30 bg-primary/5 px-6 py-5 text-sm text-primary/80">
            <p class="font-medium">Gunakan fitur analitik lanjutan untuk melihat korelasi antar kriteria dan rekomendasi otomatis.</p>
        </div>
    </div>
    <div class="rounded-3xl bg-white shadow-lg shadow-slate-200/40 border border-slate-100 p-8 space-y-6">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-800">Tugas Cepat</h3>
            <a href="#" class="text-sm font-medium text-primary hover:text-primaryDark transition">Lihat semua</a>
        </div>
        <ul class="space-y-4 text-sm text-slate-600">
            <li class="flex items-start gap-3">
                <span class="mt-1 h-2 w-2 rounded-full bg-primary"></span>
                <div>
                    <p class="font-medium text-slate-700">Tambah data kriteria baru</p>
                    <p class="text-xs text-slate-400">Perbarui parameter penilaian untuk metode terbaru.</p>
                </div>
            </li>
            <li class="flex items-start gap-3">
                <span class="mt-1 h-2 w-2 rounded-full bg-amber-400"></span>
                <div>
                    <p class="font-medium text-slate-700">Validasi bobot preferensi</p>
                    <p class="text-xs text-slate-400">Pastikan bobot telah disetujui oleh tim analis.</p>
                </div>
            </li>
            <li class="flex items-start gap-3">
                <span class="mt-1 h-2 w-2 rounded-full bg-emerald-400"></span>
                <div>
                    <p class="font-medium text-slate-700">Jalankan simulasi rekomendasi</p>
                    <p class="text-xs text-slate-400">Bandingkan hasil TOPSIS dan ELECTRE.</p>
                </div>
            </li>
        </ul>
        <button class="w-full rounded-2xl bg-primary text-white py-3 font-medium shadow shadow-primary/30 hover:bg-primaryDark transition">Mulai Analisis</button>
    </div>
</section>
<?= $this->endSection(); ?>
