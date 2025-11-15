<?= $this->extend('panel/layouts/base_panel'); ?>

<?= $this->section('content'); ?>
<section class="space-y-10">
    <header class="rounded-3xl bg-gradient-to-br from-white via-white/90 to-slate-100/60 border border-white/80 shadow-floating p-8 lg:p-10">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
            <div class="space-y-5 max-w-2xl">
                <a href="<?= base_url('panel/dashboard'); ?>" class="inline-flex items-center text-sm font-medium text-primary hover:text-primaryDark transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.78 4.22a.75.75 0 010 1.06L8.56 9.5H16a.75.75 0 010 1.5H8.56l4.22 4.22a.75.75 0 11-1.06 1.06l-5.5-5.5a.75.75 0 010-1.06l5.5-5.5a.75.75 0 011.06 0z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke Dashboard
                </a>
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-primary/70 font-semibold">Sistem Pendukung Keputusan</p>
                    <h1 class="mt-3 text-3xl lg:text-4xl font-semibold text-slate-900">Dashboard SPK Komoditas Tambak Air Payau</h1>
                    <p class="mt-3 text-slate-600">Pantau ringkasan metrik utama dan jalankan analisis TOPSIS maupun ELECTRE secara instan dari satu tempat.</p>
                </div>
            </div>
            <div class="rounded-3xl bg-white border border-slate-100 shadow-floating px-8 py-6 text-sm text-slate-600 space-y-3">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-[0.25em]">Status Sistem</p>
                        <p class="text-sm font-semibold text-slate-800">Stabil &amp; Siap Analisis</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-dashed border-slate-200">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Terakhir Sinkron</p>
                        <p class="text-sm font-medium text-slate-700"><?= esc(date('d M Y • H:i')); ?> WIB</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Pengguna Aktif</p>
                        <p class="text-sm font-medium text-slate-700">Tim SPK Tambak</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="dashboardAlert" class="mt-6 hidden rounded-2xl border px-4 py-3 text-sm"></div>
    </header>

    <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <?php
            $statCards = [
                [
                    'label' => 'Jumlah Komoditas',
                    'value' => $stats['komoditas'] ?? 0,
                    'description' => 'Data kandidat yang siap dianalisis',
                    'icon' => 'M20.25 7.5l-8.954 3.58a1.125 1.125 0 01-.842 0L2.25 7.5M20.25 7.5v8.25',
                ],
                [
                    'label' => 'Jumlah Kriteria',
                    'value' => $stats['kriteria'] ?? 0,
                    'description' => 'Parameter penilaian yang aktif',
                    'icon' => 'M12 4.5v15m7.5-7.5h-15',
                ],
                [
                    'label' => 'Total Nilai Kriteria',
                    'value' => $stats['nilai_kriteria'] ?? 0,
                    'description' => 'Penilaian komoditas yang tersimpan',
                    'icon' => 'M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5',
                ],
                [
                    'label' => 'Total Perhitungan',
                    'value' => $stats['perhitungan'] ?? 0,
                    'description' => 'Riwayat proses TOPSIS & ELECTRE',
                    'icon' => 'M12 8.25v7.5m3.75-3.75h-7.5',
                ],
            ];
        ?>
        <?php foreach ($statCards as $card): ?>
            <article class="group rounded-3xl bg-white/80 backdrop-blur glass-panel border border-slate-100 px-6 py-7 shadow-floating transition transform hover:-translate-y-1 hover:shadow-2xl">
                <div class="flex items-center justify-between gap-6">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-[0.3em]"><?= esc($card['label']); ?></p>
                        <p class="mt-4 text-3xl font-semibold text-slate-900"><?= esc(number_format((float) ($card['value'] ?? 0))); ?></p>
                        <p class="mt-2 text-sm text-slate-500"><?= esc($card['description']); ?></p>
                    </div>
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="<?= $card['icon']; ?>" />
                        </svg>
                    </span>
                </div>
            </article>
        <?php endforeach; ?>
    </section>

    <section class="grid gap-6 lg:grid-cols-[1.1fr,0.9fr]">
        <div class="rounded-3xl bg-white/90 backdrop-blur glass-panel border border-slate-100 shadow-floating p-8 space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Tombol Cepat</h2>
                    <p class="text-sm text-slate-500">Mulai proses perhitungan metode pilihan Anda.</p>
                </div>
                <div class="flex items-center gap-2 text-xs text-slate-400 uppercase tracking-[0.25em]">
                    <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Real-time Request
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                <button data-action="topsis" class="dashboard-action group rounded-2xl border border-primary/20 bg-primary/10 px-5 py-6 text-left shadow-inner hover:bg-primary hover:text-white transition">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-primary/20 text-primary group-hover:bg-white/20 group-hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v7.5M3 3h7.5M3 3l7.5 7.5m0 0V21m0-10.5H21M10.5 10.5L21 21" />
                        </svg>
                    </span>
                    <span class="mt-4 block text-lg font-semibold">Hitung TOPSIS</span>
                    <span class="mt-2 block text-sm text-slate-500 group-hover:text-white/80">Lakukan peringkat berbasis preferensi ideal.</span>
                </button>
                <button data-action="electre" class="dashboard-action group rounded-2xl border border-amber-200 bg-amber-50/80 px-5 py-6 text-left shadow-inner hover:bg-amber-400 hover:text-slate-900 transition">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-600 group-hover:bg-amber-200/60 group-hover:text-amber-900 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l3.75-3.75m0 0L12 18 19.5 6.75m-11.25 9L19.5 6.75M8.25 15.75L4.5 12" />
                        </svg>
                    </span>
                    <span class="mt-4 block text-lg font-semibold">Hitung ELECTRE</span>
                    <span class="mt-2 block text-sm text-slate-500 group-hover:text-slate-800/80">Analisis outranking untuk dominasi alternatif.</span>
                </button>
                <button data-action="bandingkan" class="dashboard-action group rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-6 text-left shadow-inner hover:bg-emerald-500 hover:text-white transition">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 group-hover:bg-white/20 group-hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 4.5V12m0 0v7.5m0-7.5h7.5M4.5 12h15" />
                        </svg>
                    </span>
                    <span class="mt-4 block text-lg font-semibold">Bandingkan Metode</span>
                    <span class="mt-2 block text-sm text-slate-500 group-hover:text-white/80">Temukan korelasi hasil TOPSIS dan ELECTRE.</span>
                </button>
            </div>

            <?php
                $resultLinks = [
                    [
                        'label' => 'Hasil TOPSIS',
                        'description' => 'Lihat ranking preferensi terbaru.',
                        'href' => base_url('panel/spk/topsis'),
                        'color' => 'primary',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 15.75 9 9.75l4.5 4.5L21 6" /></svg>',
                    ],
                    [
                        'label' => 'Hasil ELECTRE',
                        'description' => 'Telaah matriks outranking komoditas.',
                        'href' => base_url('panel/spk/electre'),
                        'color' => 'amber',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" /></svg>',
                    ],
                    [
                        'label' => 'Perbandingan SPK',
                        'description' => 'Analisis korelasi TOPSIS & ELECTRE.',
                        'href' => base_url('panel/spk/bandingkan'),
                        'color' => 'emerald',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12m-12 4.5h12m-12 4.5h12M3.75 6.75h.008v.008H3.75V6.75zm0 4.5h.008v.008H3.75v-.008zm0 4.5h.008v.008H3.75v-.008z" /></svg>',
                    ],
                ];
            ?>
            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <?php foreach ($resultLinks as $link): ?>
                    <a href="<?= $link['href']; ?>"
                       class="group flex flex-col rounded-2xl border border-<?= esc($link['color']); ?>/20 bg-white/80 px-5 py-5 shadow-floating transition hover:-translate-y-1 hover:shadow-xl">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-<?= esc($link['color']); ?>/10 text-<?= esc($link['color']); ?> group-hover:bg-<?= esc($link['color']); ?> group-hover:text-white transition">
                            <?= $link['icon']; ?>
                        </span>
                        <span class="mt-4 text-base font-semibold text-slate-900"><?= esc($link['label']); ?></span>
                        <span class="mt-1 text-sm text-slate-500 group-hover:text-slate-600/90"><?= esc($link['description']); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <aside class="rounded-3xl bg-white/80 border border-slate-100 shadow-floating p-8 space-y-8">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Aktivitas Analitik</h2>
                <p class="text-sm text-slate-500">Rekap singkat proses dan insight terbaru.</p>
            </div>
            <ul class="space-y-5 text-sm text-slate-600">
                <?php $logItems = $logs ?? [
                    ['label' => 'Perhitungan TOPSIS berhasil dijalankan', 'time' => '5 menit lalu'],
                    ['label' => 'ELECTRE diperbarui dengan bobot terbaru', 'time' => '1 jam lalu'],
                    ['label' => 'Perbandingan metode menghasilkan korelasi kuat', 'time' => 'Kemarin']
                ]; ?>
                <?php foreach ($logItems as $item): ?>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-primary/70"></span>
                        <div>
                            <p class="font-medium text-slate-700"><?= esc($item['label']); ?></p>
                            <p class="text-xs text-slate-400"><?= esc($item['time']); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="rounded-2xl border border-dashed border-primary/30 bg-primary/5 px-6 py-5 text-sm text-primary/80">
                <p class="font-medium">Gunakan analisis korelasi untuk memvalidasi konsistensi rekomendasi antar metode.</p>
            </div>
        </aside>
    </section>
</section>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const alertBox = document.getElementById('dashboardAlert');
        const buttons = document.querySelectorAll('.dashboard-action');

        const endpointMap = {
            topsis: '<?= base_url('panel/spk/topsis'); ?>',
            electre: '<?= base_url('panel/spk/electre'); ?>',
            bandingkan: '<?= base_url('panel/spk/bandingkan'); ?>',
        };

        const showAlert = (message, type = 'success') => {
            alertBox.textContent = message;
            alertBox.className = `mt-6 rounded-2xl border px-4 py-3 text-sm ${type === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-600'}`;
            alertBox.classList.remove('hidden');
            alertBox.animate([
                { opacity: 0, transform: 'translateY(-6px)' },
                { opacity: 1, transform: 'translateY(0)' }
            ], { duration: 300, easing: 'ease-out', fill: 'forwards' });
        };

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                const action = button.dataset.action;
                const url = endpointMap[action];
                if (!url) return;

                button.classList.add('ring-2', 'ring-primary/40');
                button.setAttribute('disabled', 'disabled');

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error('Permintaan tidak dapat diproses.');
                        }
                        return response.json();
                    })
                    .then((payload) => {
                        if (payload?.status !== 'success') {
                            throw new Error(payload?.message || 'Proses SPK gagal dijalankan.');
                        }
                        showAlert(`Permintaan ${action.toUpperCase()} berhasil dikirim. Silakan cek hasilnya.`, 'success');
                    })
                    .catch((error) => {
                        showAlert(error.message || 'Terjadi kesalahan saat mengirim permintaan.', 'error');
                    })
                    .finally(() => {
                        button.classList.remove('ring-2', 'ring-primary/40');
                        button.removeAttribute('disabled');
                    });
            });
        });
    });
</script>
<?= $this->endSection(); ?>
