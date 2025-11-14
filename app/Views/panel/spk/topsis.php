<?= $this->extend('panel/layouts/base_panel'); ?>

<?= $this->section('content'); ?>
<section class="space-y-8">
    <header class="rounded-3xl bg-white/80 backdrop-blur glass-panel border border-slate-200 shadow-floating px-6 py-8 lg:px-10 lg:py-12">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-8">
            <div class="space-y-4 max-w-3xl">
                <a href="<?= base_url('panel/dashboard'); ?>" class="inline-flex items-center text-sm font-medium text-primary hover:text-primaryDark transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.78 4.22a.75.75 0 010 1.06L8.56 9.5H16a.75.75 0 010 1.5H8.56l4.22 4.22a.75.75 0 11-1.06 1.06l-5.5-5.5a.75.75 0 010-1.06l5.5-5.5a.75.75 0 011.06 0z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke Dashboard
                </a>
                <div>
                    <p class="text-xs uppercase tracking-[0.35em] text-primary/70 font-semibold">Hasil Metode TOPSIS</p>
                    <h1 class="mt-3 text-3xl lg:text-4xl font-semibold text-slate-900">Ranking Komoditas Berdasarkan Preferensi Ideal</h1>
                    <p class="mt-3 text-slate-600">Pantau hasil perhitungan TOPSIS, nilai preferensi, dan detail proses untuk memastikan rekomendasi paling optimal.</p>
                </div>
            </div>
            <div class="flex flex-col gap-3 w-full lg:w-auto">
                <button id="refreshTopsis" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary to-primaryDark px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/30 hover:shadow-xl transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992V4.356m0 0L18.1 7.27A8.25 8.25 0 105.904 18.75" />
                    </svg>
                    Hitung Ulang TOPSIS
                </button>
                <div class="rounded-2xl border border-slate-200 bg-white/70 px-5 py-4 text-xs text-slate-500">
                    <p>Pastikan nilai kriteria terbaru telah tersimpan untuk hasil akurat.</p>
                </div>
            </div>
        </div>
        <div id="topsisAlert" class="mt-6 hidden rounded-2xl border px-4 py-3 text-sm"></div>
    </header>

    <div class="rounded-3xl bg-white/90 border border-slate-200 shadow-floating overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Tabel Ranking TOPSIS</h2>
                <p class="text-sm text-slate-500">Lihat posisi komoditas berdasarkan nilai preferensi terbesar ke terkecil.</p>
            </div>
            <span class="inline-flex items-center gap-2 text-xs uppercase tracking-[0.2em] text-slate-400">
                <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Tersinkron otomatis
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/80">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Komoditas</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nilai Preferensi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Posisi</th>
                    </tr>
                </thead>
                <tbody id="topsisTableBody" class="divide-y divide-slate-100 bg-white/60 text-sm text-slate-600"></tbody>
            </table>
        </div>
    </div>

    <section class="space-y-6">
        <h2 class="text-xl font-semibold text-slate-900">Detail Perhitungan</h2>
        <div id="topsisDetails" class="grid gap-5 lg:grid-cols-2">
            <?php
                $detailSections = [
                    ['id' => 'normalisasi', 'title' => 'Normalisasi Matriks', 'description' => 'Menampilkan matriks normalisasi untuk setiap kriteria.'],
                    ['id' => 'pembobotan', 'title' => 'Matriks Ternormalisasi Terbobot', 'description' => 'Nilai matriks setelah dikalikan bobot kriteria.'],
                    ['id' => 'jarak', 'title' => 'Jarak Terhadap Solusi Ideal', 'description' => 'Jarak ke solusi ideal positif dan negatif untuk tiap komoditas.'],
                    ['id' => 'skor', 'title' => 'Skor Preferensi Final', 'description' => 'Nilai akhir yang menentukan urutan ranking.'],
                ];
            ?>
            <?php foreach ($detailSections as $section): ?>
                <article class="detail-card rounded-3xl border border-slate-200 bg-white/80 shadow-floating overflow-hidden" data-section="<?= esc($section['id']); ?>">
                    <button class="detail-toggle w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800"><?= esc($section['title']); ?></h3>
                            <p class="text-xs text-slate-500 mt-1"><?= esc($section['description']); ?></p>
                        </div>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-primary/10 text-primary transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </span>
                    </button>
                    <div class="detail-content hidden border-t border-slate-100 bg-white/70 px-6 py-5 text-sm text-slate-600 space-y-3"></div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</section>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tableBody = document.getElementById('topsisTableBody');
        const alertBox = document.getElementById('topsisAlert');
        const refreshButton = document.getElementById('refreshTopsis');
        const detailCards = document.querySelectorAll('.detail-card');
        const endpoint = '<?= base_url('/spk/topsis'); ?>';
        const initialResults = <?= json_encode($results ?? []); ?>;
        const initialDetails = <?= json_encode($details ?? []); ?>;

        const showAlert = (message, type = 'success') => {
            alertBox.textContent = message;
            alertBox.className = `mt-6 rounded-2xl border px-4 py-3 text-sm ${type === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-600' : 'border-rose-200 bg-rose-50 text-rose-600'}`;
            alertBox.classList.remove('hidden');
            alertBox.animate([
                { opacity: 0, transform: 'translateY(-4px)' },
                { opacity: 1, transform: 'translateY(0)' }
            ], { duration: 280, easing: 'ease-out', fill: 'forwards' });
        };

        const formatNumber = (value) => {
            if (typeof value !== 'number') return value ?? '-';
            return value.toFixed(4);
        };

        const renderTable = (rows = []) => {
            tableBody.innerHTML = '';
            if (!rows.length) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                            <div class="flex flex-col items-center gap-3">
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </span>
                                <p class="font-medium">Belum ada hasil perhitungan.</p>
                                <p class="text-sm text-slate-400">Klik "Hitung Ulang TOPSIS" untuk memulai analisis.</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            rows.forEach((row, index) => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-primary/5 transition';
                tr.innerHTML = `
                    <td class="px-6 py-4 text-sm text-slate-500">${index + 1}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-slate-700">${row.nama_komoditas ?? '-'}</td>
                    <td class="px-6 py-4 text-sm text-slate-500">${formatNumber(row.nilai_preferensi)}</td>
                    <td class="px-6 py-4 text-sm text-slate-500">${row.posisi ?? index + 1}</td>
                `;
                tableBody.appendChild(tr);
            });
        };

        const renderDetails = (data = {}) => {
            detailCards.forEach((card) => {
                const section = card.dataset.section;
                const container = card.querySelector('.detail-content');
                const content = data[section];

                if (!container) return;
                if (!content || (Array.isArray(content) && !content.length) || (typeof content === 'object' && !Object.keys(content).length)) {
                    container.innerHTML = '<p class="text-sm text-slate-400">Belum ada data untuk ditampilkan.</p>';
                    continue;
                }

                if (Array.isArray(content)) {
                    container.innerHTML = `
                        <div class="space-y-2">
                            ${content.map((item) => `<div class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs">${item}</div>`).join('')}
                        </div>
                    `;
                } else if (typeof content === 'object') {
                    const entries = Object.entries(content);
                    container.innerHTML = `
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-xs text-slate-600">
                                <tbody>
                                    ${entries.map(([key, value]) => `
                                        <tr class="border-b border-slate-100">
                                            <th class="py-2 pr-4 text-left font-semibold text-slate-500">${key}</th>
                                            <td class="py-2 text-slate-600">${Array.isArray(value) ? value.join(', ') : formatNumber(value)}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;
                } else {
                    container.innerHTML = `<p class="text-sm text-slate-600">${content}</p>`;
                }
            });
        };

        const toggleCard = (card) => {
            const content = card.querySelector('.detail-content');
            const icon = card.querySelector('svg');
            if (!content || !icon) return;
            const isOpen = !content.classList.contains('hidden');
            if (isOpen) {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            } else {
                content.classList.remove('hidden');
                content.animate([
                    { opacity: 0, transform: 'translateY(-6px)' },
                    { opacity: 1, transform: 'translateY(0)' }
                ], { duration: 260, easing: 'ease-out', fill: 'forwards' });
                icon.style.transform = 'rotate(45deg)';
            }
        };

        detailCards.forEach((card, index) => {
            const toggleBtn = card.querySelector('.detail-toggle');
            if (!toggleBtn) return;
            toggleBtn.addEventListener('click', () => toggleCard(card));
            if (index === 0) {
                toggleCard(card);
            }
        });

        const hydrate = (data) => {
            renderTable(data?.ranking || []);
            renderDetails(data?.details || {});
        };

        const fetchData = () => {
            refreshButton.classList.add('opacity-70', 'pointer-events-none');
            fetch(endpoint, { headers: { 'Accept': 'application/json' } })
                .then((res) => {
                    if (!res.ok) throw new Error('Gagal memuat hasil TOPSIS.');
                    return res.json();
                })
                .then((data) => {
                    hydrate(data);
                    showAlert('Hasil TOPSIS berhasil diperbarui.', 'success');
                })
                .catch((error) => {
                    showAlert(error.message || 'Terjadi kesalahan saat mengambil data.', 'error');
                })
                .finally(() => {
                    refreshButton.classList.remove('opacity-70', 'pointer-events-none');
                });
        };

        hydrate({ ranking: initialResults ?? [], details: initialDetails ?? {} });
        refreshButton.addEventListener('click', fetchData);
    });
</script>
<?= $this->endSection(); ?>
