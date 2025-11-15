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
                    <p class="text-xs uppercase tracking-[0.35em] text-amber-600 font-semibold">Hasil Metode ELECTRE</p>
                    <h1 class="mt-3 text-3xl lg:text-4xl font-semibold text-slate-900">Analisis Outranking Komoditas Tambak</h1>
                    <p class="mt-3 text-slate-600">Telusuri matriks concordance, discordance, dan outranking untuk memahami dominasi antar alternatif secara menyeluruh.</p>
                </div>
            </div>
            <div class="flex flex-col gap-3 w-full lg:w-auto">
                <button id="refreshElectre" type="button" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 px-5 py-3 text-sm font-semibold text-slate-900 shadow-lg shadow-amber-200/60 hover:shadow-xl transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992V4.356m0 0L18.1 7.27A8.25 8.25 0 105.904 18.75" />
                    </svg>
                    Hitung Ulang ELECTRE
                </button>
                <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-xs text-amber-700">
                    <p>Gunakan hasil ini untuk memverifikasi urutan rekomendasi bersama TOPSIS.</p>
                </div>
            </div>
        </div>
        <div id="electreAlert" class="mt-6 hidden rounded-2xl border px-4 py-3 text-sm"></div>
    </header>

    <div class="rounded-3xl bg-white/90 border border-slate-200 shadow-floating overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Tabel Ranking ELECTRE</h2>
                <p class="text-sm text-slate-500">Posisi komoditas berdasarkan nilai outranking tertinggi.</p>
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
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nilai Outranking</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Posisi</th>
                    </tr>
                </thead>
                <tbody id="electreTableBody" class="divide-y divide-slate-100 bg-white/60 text-sm text-slate-600"></tbody>
            </table>
        </div>
    </div>

    <section class="space-y-6">
        <h2 class="text-xl font-semibold text-slate-900">Detail Matriks ELECTRE</h2>
        <div id="electreDetails" class="grid gap-5 lg:grid-cols-2">
            <?php
                $detailSections = [
                    ['id' => 'concordance', 'title' => 'Matriks Concordance', 'description' => 'Menunjukkan tingkat dominasi berdasarkan bobot yang mendukung.'],
                    ['id' => 'discordance', 'title' => 'Matriks Discordance', 'description' => 'Menggambarkan tingkat penolakan antar alternatif.'],
                    ['id' => 'outranking', 'title' => 'Matriks Outranking', 'description' => 'Hasil gabungan concordance dan discordance.'],
                    ['id' => 'hasil', 'title' => 'Hasil Akhir ELECTRE', 'description' => 'Ringkasan rekomendasi akhir metode ELECTRE.'],
                ];
            ?>
            <?php foreach ($detailSections as $section): ?>
                <article class="detail-card rounded-3xl border border-amber-200 bg-amber-50/70 shadow-floating overflow-hidden" data-section="<?= esc($section['id']); ?>">
                    <button class="detail-toggle w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800"><?= esc($section['title']); ?></h3>
                            <p class="text-xs text-slate-500 mt-1"><?= esc($section['description']); ?></p>
                        </div>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-amber-200/60 text-amber-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </span>
                    </button>
                    <div class="detail-content hidden border-t border-amber-100 bg-white/80 px-6 py-5 text-sm text-slate-600 space-y-3"></div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</section>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tableBody = document.getElementById('electreTableBody');
        const alertBox = document.getElementById('electreAlert');
        const refreshButton = document.getElementById('refreshElectre');
        const detailCards = document.querySelectorAll('#electreDetails .detail-card');
        const dataEndpoint = '<?= base_url('panel/spk/electre/data'); ?>';
        const calculateEndpoint = '<?= base_url('panel/spk/electre/hitung'); ?>';
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

        const getOutrankingValue = (row) => {
            const rawValue = row?.nilai_outranking ?? row?.nilai_akhir ?? row?.nilai;
            if (typeof rawValue === 'number') {
                return rawValue;
            }

            const parsed = Number.parseFloat(rawValue);
            return Number.isFinite(parsed) ? parsed : rawValue;
        };

        const renderTable = (rows = []) => {
            tableBody.innerHTML = '';
            if (!rows.length) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                            <div class="flex flex-col items-center gap-3">
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </span>
                                <p class="font-medium">Belum ada hasil ELECTRE.</p>
                                <p class="text-sm text-slate-400">Klik "Hitung Ulang ELECTRE" untuk memulai analisis.</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            rows.forEach((row, index) => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-amber-50 transition';
                const outranking = getOutrankingValue(row);
                const position = row.posisi ?? row.ranking ?? (index + 1);
                tr.innerHTML = `
                    <td class="px-6 py-4 text-sm text-slate-500">${index + 1}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-slate-700">${row.nama_komoditas ?? '-'}</td>
                    <td class="px-6 py-4 text-sm text-slate-500">${formatNumber(outranking)}</td>
                    <td class="px-6 py-4 text-sm text-slate-500">${position}</td>
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
                    return;
                }

                if (Array.isArray(content)) {
                    container.innerHTML = `
                        <div class="space-y-2">
                            ${content.map((item) => `<div class="rounded-xl border border-amber-200 bg-white px-4 py-2 text-xs">${item}</div>`).join('')}
                        </div>
                    `;
                } else if (typeof content === 'object') {
                    const entries = Object.entries(content);
                    container.innerHTML = `
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-xs text-slate-600">
                                <tbody>
                                    ${entries.map(([key, value]) => `
                                        <tr class="border-b border-amber-100">
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

        const loadData = () => {
            fetch(dataEndpoint, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then((res) => {
                    if (!res.ok) throw new Error('Gagal memuat data ELECTRE.');
                    return res.json();
                })
                .then((payload) => {
                    if (payload?.status !== 'success') {
                        throw new Error(payload?.message || 'Tidak dapat menampilkan data ELECTRE.');
                    }

                    hydrate(payload.data || {});
                })
                .catch((error) => {
                    console.error(error);
                    showAlert(error.message || 'Terjadi kesalahan saat memuat data.', 'error');
                });
        };

        const runCalculation = () => {
            if (!refreshButton) {
                return;
            }

            refreshButton.classList.add('opacity-70', 'pointer-events-none');
            fetch(calculateEndpoint, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then((res) => {
                    if (!res.ok) throw new Error('Gagal memproses perhitungan ELECTRE.');
                    return res.json();
                })
                .then((payload) => {
                    if (payload?.status !== 'success') {
                        throw new Error(payload?.message || 'Proses ELECTRE gagal dijalankan.');
                    }

                    hydrate(payload.data || {});
                    showAlert(payload?.message || 'Hasil ELECTRE berhasil diperbarui.', 'success');
                })
                .catch((error) => {
                    showAlert(error.message || 'Terjadi kesalahan saat mengambil data.', 'error');
                })
                .finally(() => {
                    refreshButton.classList.remove('opacity-70', 'pointer-events-none');
                });
        };

        hydrate({ ranking: initialResults ?? [], details: initialDetails ?? {} });
        loadData();
        if (refreshButton) {
            refreshButton.addEventListener('click', runCalculation);
        }
    });
</script>
<?= $this->endSection(); ?>
