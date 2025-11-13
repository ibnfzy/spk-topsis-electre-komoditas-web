<?= $this->extend('panel/layouts/base_panel'); ?>

<?= $this->section('content'); ?>
<section class="space-y-8 max-w-3xl">
    <div class="bg-white/80 backdrop-blur glass-panel border border-slate-200 rounded-2xl shadow-floating p-6 lg:p-8">
        <div class="flex items-start justify-between gap-6 flex-wrap">
            <div>
                <a href="<?= base_url('panel/kriteria'); ?>" class="inline-flex items-center text-sm font-medium text-primary hover:text-primaryDark transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.78 4.22a.75.75 0 010 1.06L8.56 9.5H16a.75.75 0 010 1.5H8.56l4.22 4.22a.75.75 0 11-1.06 1.06l-5.5-5.5a.75.75 0 010-1.06l5.5-5.5a.75.75 0 011.06 0z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke daftar kriteria
                </a>
                <h1 class="mt-4 text-3xl font-semibold text-slate-900"><?= esc($pageTitle); ?></h1>
                <p class="mt-2 text-slate-500 max-w-2xl">Definisikan kriteria penilaian untuk mendukung analisis multi-kriteria.</p>
            </div>
            <div class="px-4 py-2 rounded-xl bg-primary/10 text-primary font-medium shadow-inner">Formulir Kriteria</div>
        </div>
    </div>

    <form id="resourceForm" class="space-y-6 bg-white/70 backdrop-blur glass-panel border border-slate-200 rounded-2xl shadow-floating p-6 lg:p-8">
        <div class="space-y-2">
            <label for="kode_kriteria" class="text-sm font-medium text-slate-700">Kode Kriteria <span class="text-rose-500">*</span></label>
            <input type="text" id="kode_kriteria" name="kode_kriteria" value="<?= esc($record['kode_kriteria'] ?? ''); ?>" class="w-full rounded-xl border border-slate-200 bg-white/80 px-4 py-3 text-slate-700 placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition" placeholder="Contoh: C1" required>
        </div>
        <div class="space-y-2">
            <label for="nama_kriteria" class="text-sm font-medium text-slate-700">Nama Kriteria <span class="text-rose-500">*</span></label>
            <input type="text" id="nama_kriteria" name="nama_kriteria" value="<?= esc($record['nama_kriteria'] ?? ''); ?>" class="w-full rounded-xl border border-slate-200 bg-white/80 px-4 py-3 text-slate-700 placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition" placeholder="Contoh: Tingkat Pertumbuhan" required>
        </div>
        <div class="space-y-2">
            <label for="jenis" class="text-sm font-medium text-slate-700">Jenis Kriteria <span class="text-rose-500">*</span></label>
            <select id="jenis" name="jenis" class="w-full rounded-xl border border-slate-200 bg-white/80 px-4 py-3 text-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 transition" required>
                <option value="" disabled <?= empty($record['jenis']) ? 'selected' : ''; ?>>Pilih jenis kriteria</option>
                <option value="benefit" <?= ($record['jenis'] ?? '') === 'benefit' ? 'selected' : ''; ?>>Benefit (Semakin besar semakin baik)</option>
                <option value="cost" <?= ($record['jenis'] ?? '') === 'cost' ? 'selected' : ''; ?>>Cost (Semakin kecil semakin baik)</option>
            </select>
        </div>
        <div id="formFeedback" class="hidden rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-600"></div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3">
            <a href="<?= base_url('panel/kriteria'); ?>" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 transition">Batal</a>
            <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-gradient-to-r from-primary to-primaryDark text-white font-semibold shadow-lg shadow-primary/30 hover:shadow-xl hover:-translate-y-0.5 transition">
                Simpan Kriteria
            </button>
        </div>
    </form>
</section>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('resourceForm');
        const feedback = document.getElementById('formFeedback');
        const submitUrl = '<?= $formAction; ?>';
        const method = '<?= strtoupper($submitMethod); ?>';

        const showFeedback = (message, type = 'success') => {
            feedback.textContent = message;
            feedback.className = `rounded-xl px-4 py-3 text-sm border ${type === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-600' : 'border-rose-200 bg-rose-50 text-rose-600'}`;
            feedback.classList.remove('hidden');
        };

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const formData = new FormData(form);
            const payload = {};
            formData.forEach((value, key) => {
                payload[key] = value;
            });

            fetch(submitUrl, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
                .then(async (response) => {
                    const data = await response.json().catch(() => ({}));
                    if (!response.ok) {
                        throw data;
                    }
                    return data;
                })
                .then(() => {
                    showFeedback('Kriteria berhasil disimpan. Mengalihkan...', 'success');
                    setTimeout(() => {
                        window.location.href = '<?= base_url('panel/kriteria'); ?>';
                    }, 1200);
                })
                .catch((error) => {
                    const message = error?.message || 'Terjadi kesalahan saat menyimpan data.';
                    showFeedback(message, 'error');
                });
        });
    });
</script>
<?= $this->endSection(); ?>
