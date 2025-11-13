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
                    <p class="text-xs uppercase tracking-[0.35em] text-emerald-600 font-semibold">Perbandingan Metode</p>
                    <h1 class="mt-3 text-3xl lg:text-4xl font-semibold text-slate-900">Korelasi Ranking TOPSIS vs ELECTRE</h1>
                    <p class="mt-3 text-slate-600">Analisis koefisien Spearman untuk melihat seberapa konsisten rekomendasi antar metode.</p>
                </div>
            </div>
            <div class="flex flex-col gap-3 w-full lg:w-auto">
                <button id="compareNow" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-300/60 hover:shadow-xl transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Bandingkan Sekarang
                </button>
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-xs text-emerald-700">
                    <p>Gunakan fitur ini untuk memvalidasi konsistensi keputusan sebelum finalisasi rekomendasi.</p>
                </div>
            </div>
        </div>
        <div id="compareAlert" class="mt-6 hidden rounded-2xl border px-4 py-3 text-sm"></div>
    </header>

    <section class="grid gap-6 lg:grid-cols-[0.9fr,1.1fr] items-start">
        <div class="rounded-3xl bg-white/90 border border-slate-200 shadow-floating p-7 space-y-6">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Nilai Korelasi Spearman (ρ)</h2>
                <p class="text-sm text-slate-500">Menggambarkan kekuatan hubungan antar ranking TOPSIS dan ELECTRE.</p>
            </div>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-6 py-5 text-center">
                <p class="text-sm text-emerald-600 uppercase tracking-[0.2em]">Nilai ρ</p>
                <p id="rhoValue" class="mt-2 text-4xl font-semibold text-emerald-700">0.000</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white/70 px-6 py-5">
                <p class="text-sm font-semibold text-slate-700">Interpretasi</p>
                <p id="rhoInterpretation" class="mt-2 text-sm text-slate-500">Belum ada interpretasi. Jalankan perbandingan untuk melihat insight.</p>
            </div>
        </div>
        <div class="rounded-3xl bg-white/90 border border-slate-200 shadow-floating p-7 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Perbandingan Ranking</h2>
                    <p class="text-sm text-slate-500">Visualisasi peringkat komoditas dari kedua metode.</p>
                </div>
                <span class="inline-flex items-center gap-2 text-xs uppercase tracking-[0.2em] text-slate-400">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Live Update
                </span>
            </div>
            <div class="relative h-[320px]">
                <canvas id="comparisonChart"></canvas>
            </div>
        </div>
    </section>
</section>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const endpoint = '<?= base_url('/spk/bandingkan'); ?>';
        const compareButton = document.getElementById('compareNow');
        const alertBox = document.getElementById('compareAlert');
        const rhoValue = document.getElementById('rhoValue');
        const rhoInterpretation = document.getElementById('rhoInterpretation');
        const ctx = document.getElementById('comparisonChart').getContext('2d');
        const initialData = <?= json_encode($comparison ?? []); ?>;

        let chartInstance = null;

        const showAlert = (message, type = 'success') => {
            alertBox.textContent = message;
            alertBox.className = `mt-6 rounded-2xl border px-4 py-3 text-sm ${type === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-600' : 'border-rose-200 bg-rose-50 text-rose-600'}`;
            alertBox.classList.remove('hidden');
            alertBox.animate([
                { opacity: 0, transform: 'translateY(-4px)' },
                { opacity: 1, transform: 'translateY(0)' }
            ], { duration: 280, easing: 'ease-out', fill: 'forwards' });
        };

        const buildChart = (labels = [], topsisData = [], electreData = []) => {
            if (chartInstance) {
                chartInstance.destroy();
            }
            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Ranking TOPSIS',
                            data: topsisData,
                            backgroundColor: 'rgba(37, 99, 235, 0.6)',
                            borderRadius: 12,
                        },
                        {
                            label: 'Ranking ELECTRE',
                            data: electreData,
                            backgroundColor: 'rgba(16, 185, 129, 0.6)',
                            borderRadius: 12,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                stepSize: 1,
                            },
                            grid: {
                                color: 'rgba(148, 163, 184, 0.2)',
                            },
                        },
                        x: {
                            grid: {
                                display: false,
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'round',
                            },
                        },
                    },
                    animation: {
                        duration: 700,
                        easing: 'easeOutQuart',
                    },
                },
            });
        };

        const hydrate = (data = {}) => {
            const rho = typeof data.rho === 'number' ? data.rho : parseFloat(data.rho || 0);
            rhoValue.textContent = isNaN(rho) ? '0.000' : rho.toFixed(3);
            rhoInterpretation.textContent = data.interpretasi || 'Belum ada interpretasi. Jalankan perbandingan untuk melihat insight.';

            const labels = (data.labels || data.daftar_komoditas || []);
            const topsisRanking = (data.ranking_topsis || data.topsis || []).map(Number);
            const electreRanking = (data.ranking_electre || data.electre || []).map(Number);

            if (labels.length && topsisRanking.length && electreRanking.length) {
                buildChart(labels, topsisRanking, electreRanking);
            } else {
                buildChart(['Data'], [0], [0]);
            }
        };

        const fetchComparison = () => {
            compareButton.classList.add('opacity-70', 'pointer-events-none');
            fetch(endpoint, { headers: { 'Accept': 'application/json' } })
                .then((res) => {
                    if (!res.ok) throw new Error('Gagal memuat perbandingan.');
                    return res.json();
                })
                .then((data) => {
                    hydrate(data);
                    showAlert('Perbandingan metode berhasil diperbarui.', 'success');
                })
                .catch((error) => {
                    showAlert(error.message || 'Terjadi kesalahan saat mengambil data.', 'error');
                })
                .finally(() => {
                    compareButton.classList.remove('opacity-70', 'pointer-events-none');
                });
        };

        hydrate(initialData || {});
        compareButton.addEventListener('click', fetchComparison);
    });
</script>
<?= $this->endSection(); ?>
