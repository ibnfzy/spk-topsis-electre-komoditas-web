<?= $this->extend('panel/layouts/base_panel'); ?>

<?= $this->section('content'); ?>
<section class="space-y-8 max-w-3xl">
    <div class="bg-white/80 backdrop-blur glass-panel border border-slate-200 rounded-2xl shadow-floating p-6 lg:p-8">
        <div class="flex items-start justify-between gap-6 flex-wrap">
            <div>
                <a href="<?= base_url('panel/bobot-kriteria'); ?>" class="inline-flex items-center text-sm font-medium text-primary hover:text-primaryDark transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.78 4.22a.75.75 0 010 1.06L8.56 9.5H16a.75.75 0 010 1.5H8.56l4.22 4.22a.75.75 0 11-1.06 1.06l-5.5-5.5a.75.75 0 010-1.06l5.5-5.5a.75.75 0 011.06 0z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke daftar bobot
                </a>
                <h1 class="mt-4 text-3xl font-semibold text-slate-900"><?= esc($pageTitle); ?></h1>
                <p class="mt-2 text-slate-500 max-w-2xl">Atur bobot prioritas untuk setiap kriteria agar perhitungan lebih akurat.</p>
            </div>
            <div class="px-4 py-2 rounded-xl bg-primary/10 text-primary font-medium shadow-inner">Formulir Bobot</div>
        </div>
    </div>

    <form id="resourceForm" class="space-y-6 bg-white/70 backdrop-blur glass-panel border border-slate-200 rounded-2xl shadow-floating p-6 lg:p-8">
        <div class="space-y-2">
            <label for="kriteria_id" class="text-sm font-medium text-slate-700">Kriteria <span class="text-rose-500">*</span></label>
            <select id="kriteria_id" name="kriteria_id" class="w-full rounded-xl border border-slate-200 bg-white/80 px-4 py-3 text-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 transition" required>
                <option value="" disabled <?= empty($record['kriteria_id']) ? 'selected' : ''; ?>>Pilih kriteria</option>
                <?php foreach ($kriteriaOptions as $option): ?>
                    <option value="<?= esc($option['id']); ?>" <?= (string)($record['kriteria_id'] ?? '') === (string)$option['id'] ? 'selected' : ''; ?>><?= esc($option['nama_kriteria']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="space-y-2">
            <label for="bobot" class="text-sm font-medium text-slate-700">Nilai Bobot <span class="text-rose-500">*</span></label>
            <input type="number" step="0.01" min="0" id="bobot" name="bobot" value="<?= esc($record['bobot'] ?? ''); ?>" class="w-full rounded-xl border border-slate-200 bg-white/80 px-4 py-3 text-slate-700 placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition" placeholder="Contoh: 0.25" required>
            <p class="text-xs text-slate-400">Pastikan total bobot seluruh kriteria mencapai 1 atau 100% sesuai kebutuhan metode.</p>
        </div>
        <div id="formFeedback" class="hidden rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-600"></div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3">
            <a href="<?= base_url('panel/bobot-kriteria'); ?>" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 transition">Batal</a>
            <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-gradient-to-r from-primary to-primaryDark text-white font-semibold shadow-lg shadow-primary/30 hover:shadow-xl hover:-translate-y-0.5 transition">
                Simpan Bobot
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

        const showValidationAlert = (message) => {
            const existing = document.querySelector('.validation-alert');
            existing?.remove();
            const alert = document.createElement('div');
            alert.textContent = message;
            alert.role = 'alert';
            alert.className = 'validation-alert fixed top-6 right-6 z-50 max-w-sm rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700 shadow-lg transition-all duration-300';
            document.body.appendChild(alert);
            setTimeout(() => {
                alert.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => alert.remove(), 300);
            }, 2000);
        };

        const validateForm = () => {
            const kriteriaId = form.kriteria_id.value;
            const bobotValue = form.bobot.value.trim();
            const bobotNumber = Number(bobotValue);

            if (!kriteriaId) {
                showValidationAlert('Silakan pilih kriteria yang akan diberi bobot.');
                form.kriteria_id.focus();
                return false;
            }

            if (!bobotValue) {
                showValidationAlert('Nilai bobot wajib diisi.');
                form.bobot.focus();
                return false;
            }

            if (!Number.isFinite(bobotNumber)) {
                showValidationAlert('Nilai bobot harus berupa angka.');
                form.bobot.focus();
                return false;
            }

            if (bobotNumber <= 0 || bobotNumber > 1) {
                showValidationAlert('Nilai bobot harus berada pada rentang 0 < bobot ≤ 1.');
                form.bobot.focus();
                return false;
            }

            return true;
        };

        const showFeedback = (message, type = 'success') => {
            feedback.textContent = message;
            feedback.className = `rounded-xl px-4 py-3 text-sm border ${type === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-600' : 'border-rose-200 bg-rose-50 text-rose-600'}`;
            feedback.classList.remove('hidden');
        };

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            if (!validateForm()) {
                return;
            }
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
                    showFeedback('Bobot kriteria berhasil disimpan. Mengalihkan...', 'success');
                    setTimeout(() => {
                        window.location.href = '<?= base_url('panel/bobot-kriteria'); ?>';
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
