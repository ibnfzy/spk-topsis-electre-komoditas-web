<?= $this->extend('panel/layouts/base_panel'); ?>

<?= $this->section('content'); ?>
<section class="space-y-8">
    <header class="rounded-3xl bg-white/80 backdrop-blur glass-panel border border-slate-200 shadow-floating px-6 py-8 lg:px-10 lg:py-12">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-8">
            <div class="space-y-5 max-w-3xl">
                <a href="<?= base_url('panel/dashboard'); ?>" class="inline-flex items-center text-sm font-medium text-primary hover:text-primaryDark transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.78 4.22a.75.75 0 010 1.06L8.56 9.5H16a.75.75 0 010 1.5H8.56l4.22 4.22a.75.75 0 11-1.06 1.06l-5.5-5.5a.75.75 0 010-1.06l5.5-5.5a.75.75 0 011.06 0z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke Dashboard
                </a>
                <div>
                    <p class="text-xs uppercase tracking-[0.35em] text-primary/70 font-semibold">
                        <?= isset($isEditing) && $isEditing ? 'Edit Matrix Nilai' : 'Input Nilai Kriteria'; ?>
                    </p>
                    <h1 class="mt-3 text-3xl lg:text-4xl font-semibold text-slate-900">
                        <?= esc($pageTitle ?? 'Matrix Penilaian Komoditas'); ?>
                    </h1>
                    <p class="mt-3 text-slate-600">
                        <?= isset($isEditing) && $isEditing
                            ? 'Perbarui seluruh nilai kriteria dalam satu tampilan matrix.'
                            : 'Masukkan nilai performa setiap komoditas untuk seluruh kriteria penilaian dalam satu tampilan tabel yang mudah diedit.';
                        ?>
                    </p>
                </div>
            </div>
            <div class="rounded-2xl bg-primary text-white px-6 py-4 shadow-floating space-y-1">
                <p class="text-xs uppercase tracking-[0.3em] text-white/80">Status</p>
                <p class="text-lg font-semibold">
                    <?= isset($isEditing) && $isEditing ? 'Mode Edit Matrix' : 'Draft Penilaian'; ?>
                </p>
                <p class="text-sm text-white/70">
                    <?= isset($isEditing) && $isEditing ? 'Periksa kembali perubahan sebelum menyimpan.' : 'Pastikan seluruh nilai terisi sebelum menyimpan.'; ?>
                </p>
            </div>
        </div>
        <div id="matrixAlert" class="mt-6 hidden rounded-2xl border px-4 py-3 text-sm"></div>
    </header>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px] lg:grid-cols-[minmax(0,1fr)_320px] lg:items-start">
        <div class="rounded-3xl bg-white/90 border border-slate-200 shadow-floating overflow-hidden">
            <div class="overflow-x-auto">
            <?php
                $komoditasList = $komoditasOptions ?? $komoditasList ?? [];
                $kriteriaList = $kriteriaOptions ?? $kriteriaList ?? [];
                $nilaiMatrix = $nilaiMatrix ?? [];
            ?>
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/80">
                    <tr>
                        <th class="sticky left-0 bg-slate-50/90 backdrop-blur px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Komoditas</th>
                        <?php foreach ($kriteriaList as $kriteria): ?>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 min-w-[160px]">
                                <?= esc($kriteria['nama_kriteria'] ?? $kriteria['kode'] ?? 'Kriteria'); ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white/60">
                    <?php if (!empty($komoditasList)): ?>
                        <?php foreach ($komoditasList as $komoditas): ?>
                            <?php $komoditasId = $komoditas['id'] ?? $komoditas['komoditas_id'] ?? null; ?>
                            <tr class="hover:bg-primary/5 transition">
                                <th scope="row" class="sticky left-0 bg-white px-6 py-4 text-sm font-semibold text-slate-700 shadow-[2px_0_0_rgba(15,23,42,0.04)]">
                                    <div class="flex flex-col">
                                        <span><?= esc($komoditas['nama_komoditas'] ?? $komoditas['nama'] ?? 'Komoditas'); ?></span>
                                        <span class="text-xs font-normal text-slate-400">ID: <?= esc($komoditasId ?? '-'); ?></span>
                                    </div>
                                </th>
                                <?php foreach ($kriteriaList as $kriteria): ?>
                                    <?php $kriteriaId = $kriteria['id'] ?? $kriteria['kriteria_id'] ?? null; ?>
                                    <?php $currentValue = $nilaiMatrix[$komoditasId][$kriteriaId] ?? null; ?>
                                    <td class="px-6 py-4 align-middle">
                                        <div class="relative">
                                            <input
                                                type="number"
                                                min="0"
                                                step="0.01"
                                                data-komoditas="<?= esc($komoditasId); ?>"
                                                data-kriteria="<?= esc($kriteriaId); ?>"
                                                name="nilai[<?= esc($komoditasId); ?>][<?= esc($kriteriaId); ?>]"
                                                value="<?= esc($currentValue ?? ''); ?>"
                                                class="w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-2.5 text-sm text-slate-600 focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                                placeholder="0.00"
                                            >
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= count($kriteriaList) + 1; ?>" class="px-6 py-10 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </span>
                                    <p class="font-medium">Belum ada data komoditas.</p>
                                    <p class="text-sm text-slate-400">Tambahkan data komoditas dan kriteria terlebih dahulu.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
        <aside class="rounded-3xl border border-slate-200 bg-white/90 shadow-floating p-6 space-y-4" aria-live="polite">
            <div class="flex items-start gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 17.25v.008h.008V17.25H12zm0-10.5V6.75m0 0a.375.375 0 110-.75.375.375 0 010 .75zM12 6.75v6" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12a8.25 8.25 0 1116.5 0 8.25 8.25 0 01-16.5 0z" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-[0.35em] text-primary/70 font-semibold">Tips</p>
                    <h2 class="text-lg font-semibold text-slate-900">Panduan Nilai Kriteria</h2>
                    <p class="text-sm text-slate-500">Gunakan panduan ini sebelum mengisi matrix agar nilai antar komoditas konsisten.</p>
                </div>
            </div>
            <button id="tipsToggle" type="button" aria-expanded="true" aria-controls="tipsContent" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:border-primary hover:text-primary transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tampilkan/Sembunyikan Tips</span>
            </button>
            <div id="tipsContent" class="space-y-4 text-sm text-slate-600">
                <ul class="list-disc space-y-2 pl-5">
                    <li>Gunakan rentang nilai 1-10: 1 menunjukkan kondisi terburuk, 5 menandakan kondisi terbaik yang umum dijumpai pada studi tambak air payau.</li>
                    <li>Kualitas air (salinitas, pH, DO) diberi nilai tinggi bila mendekati standar optimal komoditas yang diolah.</li>
                    <li>Kondisi tanah mendapat nilai tinggi jika tekstur stabil, tidak mengandung sulfat berlebih, dan siap mendukung budidaya.</li>
                    <li>Nilai infrastruktur berdasarkan kedekatan dengan jalan utama, pasar, serta kemudahan logistik pendukung.</li>
                    <li>Risiko lingkungan diberi nilai tinggi ketika lokasi minim ancaman banjir, erosi, maupun cuaca ekstrem.</li>
                </ul>
                <p class="text-slate-500">Catatan: Nilai bersifat panduan dan merujuk pada Tarunamulia (2024), Hardianto (2022), Rossignoli (2023), serta Apine (2023) yang menekankan kualitas tanah-air, efisiensi lahan, aspek teknis akses lingkungan, dan faktor risiko keberlanjutan.</p>
                <p class="text-slate-500">Seluruh nilai akan diproses otomatis dalam perhitungan TOPSIS dan ELECTRE sehingga konsistensi input sangat penting.</p>
            </div>
        </aside>
    </div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="rounded-2xl border border-slate-200 bg-white/80 px-5 py-4 text-sm text-slate-600">
            Pastikan nilai berada pada rentang yang telah disepakati tim analis.
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="<?= base_url('panel/nilai-kriteria'); ?>" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 transition">Batal</a>
            <button id="saveMatrix" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-gradient-to-r from-primary to-primaryDark text-white font-semibold shadow-lg shadow-primary/30 hover:shadow-xl hover:-translate-y-0.5 transition">
                <?= isset($isEditing) && $isEditing ? 'Perbarui Nilai' : 'Simpan Nilai'; ?>
            </button>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const saveButton = document.getElementById('saveMatrix');
        const alertBox = document.getElementById('matrixAlert');
        const inputs = Array.from(document.querySelectorAll('input[data-komoditas][data-kriteria]'));
        const endpoint = '<?= esc($matrixEndpoint ?? base_url('panel/nilai-kriteria/matrix')); ?>';
        const tipsToggle = document.getElementById('tipsToggle');
        const tipsContent = document.getElementById('tipsContent');
        let tipsVisible = true;

        tipsToggle?.addEventListener('click', () => {
            tipsVisible = !tipsVisible;
            if (tipsContent) {
                tipsContent.classList.toggle('hidden', !tipsVisible);
            }
            tipsToggle.setAttribute('aria-expanded', tipsVisible ? 'true' : 'false');
        });

        const showAlert = (message, type = 'success') => {
            alertBox.textContent = message;
            alertBox.className = `mt-6 rounded-2xl border px-4 py-3 text-sm ${type === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-600' : 'border-rose-200 bg-rose-50 text-rose-600'}`;
            alertBox.classList.remove('hidden');
            alertBox.animate([
                { opacity: 0, transform: 'translateY(-4px)' },
                { opacity: 1, transform: 'translateY(0)' }
            ], { duration: 280, easing: 'ease-out', fill: 'forwards' });
        };

        const collectPayload = () => {
            const payload = {};
            inputs.forEach((input) => {
                const komoditasId = input.dataset.komoditas;
                const kriteriaId = input.dataset.kriteria;
                if (!komoditasId || !kriteriaId) return;

                payload[komoditasId] = payload[komoditasId] || {};
                const value = input.value.trim();
                payload[komoditasId][kriteriaId] = value === '' ? null : Number(value);
            });
            return payload;
        };

        saveButton?.addEventListener('click', () => {
            if (!inputs.length) {
                showAlert('Tidak ada nilai yang dapat disimpan.', 'error');
                return;
            }

            const payload = { nilai: collectPayload() };
            saveButton.classList.add('opacity-70', 'pointer-events-none');

            fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            })
                .then((res) => {
                    if (!res.ok) throw new Error('Gagal menyimpan nilai.');
                    return res.json().catch(() => ({}));
                })
                .then(() => {
                    showAlert('Nilai kriteria berhasil disimpan.', 'success');
                })
                .catch((error) => {
                    showAlert(error.message || 'Terjadi kesalahan saat menyimpan nilai.', 'error');
                })
                .finally(() => {
                    saveButton.classList.remove('opacity-70', 'pointer-events-none');
                });
        });
    });
</script>
<?= $this->endSection(); ?>
