<?= $this->extend('panel/layouts/base_panel'); ?>

<?= $this->section('content'); ?>
<section class="space-y-6">
    <div class="bg-white/80 backdrop-blur glass-panel border border-slate-200 rounded-2xl shadow-floating p-6 lg:p-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <h1 class="text-2xl lg:text-3xl font-semibold text-slate-900"><?= esc($pageTitle); ?></h1>
                <p class="mt-2 text-slate-500 max-w-2xl"><?= esc($description); ?></p>
            </div>
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center">
                <a
                    id="manageMatrixButton"
                    data-has-values="<?= isset($hasValues) && $hasValues ? '1' : '0'; ?>"
                    data-add-url="<?= base_url('panel/nilai-kriteria/tambah'); ?>"
                    data-edit-url="<?= base_url('panel/nilai-kriteria/edit'); ?>"
                    href="<?= base_url((isset($hasValues) && $hasValues) ? 'panel/nilai-kriteria/edit' : 'panel/nilai-kriteria/tambah'); ?>"
                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-primary to-primaryDark text-white font-medium shadow-lg shadow-primary/30 hover:shadow-xl hover:-translate-y-0.5 transition-all"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span id="manageMatrixText"><?= (isset($hasValues) && $hasValues) ? 'Edit Nilai' : 'Tambah Nilai'; ?></span>
                </a>
                <button
                    id="clearMatrixButton"
                    data-endpoint="<?= base_url('panel/nilai-kriteria/clear'); ?>"
                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-rose-200 bg-rose-50 text-rose-500 font-medium shadow-floating hover:bg-rose-100 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    <?= (isset($hasValues) && $hasValues) ? '' : 'disabled'; ?>
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Kosongkan Nilai
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white/70 backdrop-blur glass-panel border border-slate-200 rounded-2xl shadow-floating">
        <div class="p-6 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="relative w-full lg:max-w-sm">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 103.473 9.743l3.642 3.642a.75.75 0 101.06-1.06l-3.642-3.642A5.5 5.5 0 009 3.5zM5.5 9a3.5 3.5 0 117 0 3.5 3.5 0 01-7 0z" clip-rule="evenodd" />
                    </svg>
                </span>
                <input id="searchInput" type="search" placeholder="Cari nilai kriteria..." class="w-full rounded-xl border border-slate-200 bg-white/80 py-2.5 pl-10 pr-4 text-slate-700 placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" />
            </div>
            <div class="text-sm text-slate-500">
                <span id="tableMeta">Menampilkan nilai per komoditas</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/60">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Komoditas</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Kriteria</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nilai</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="divide-y divide-slate-100 bg-white/60"></tbody>
            </table>
        </div>
        <div class="p-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 border-t border-slate-100">
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <span>Halaman</span>
                <div id="pagination" class="inline-flex items-center gap-1"></div>
            </div>
            <div class="flex items-center gap-3">
                <button id="prevPage" class="inline-flex items-center px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:border-primary hover:text-primary transition-all disabled:opacity-40 disabled:cursor-not-allowed">Sebelumnya</button>
                <button id="nextPage" class="inline-flex items-center px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:border-primary hover:text-primary transition-all disabled:opacity-40 disabled:cursor-not-allowed">Berikutnya</button>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const endpoint = '<?= base_url('panel/nilai-kriteria?format=json'); ?>';
        const tableBody = document.getElementById('tableBody');
        const searchInput = document.getElementById('searchInput');
        const pagination = document.getElementById('pagination');
        const prevPage = document.getElementById('prevPage');
        const nextPage = document.getElementById('nextPage');
        const tableMeta = document.getElementById('tableMeta');
        const pageSize = 6;
        let dataset = [];
        let filtered = [];
        let currentPage = 1;
        const manageButton = document.getElementById('manageMatrixButton');
        const manageText = document.getElementById('manageMatrixText');
        const clearButton = document.getElementById('clearMatrixButton');
        const clearEndpoint = clearButton?.dataset.endpoint;

        const toast = (message, type = 'success') => {
            const wrapper = document.createElement('div');
            wrapper.className = `fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-3 rounded-2xl shadow-lg text-white transition-all duration-300 ${type === 'success' ? 'bg-emerald-500/90' : 'bg-rose-500/90'}`;
            wrapper.innerHTML = `
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        ${type === 'success'
                            ? '<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />'
                            : '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12V16.5zm0-9h.008v.008H12V7.5z" />'}
                    </svg>
                </span>
                <span class="font-medium">${message}</span>
            `;
            document.body.appendChild(wrapper);
            setTimeout(() => {
                wrapper.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => wrapper.remove(), 250);
            }, 2200);
        };

        const setManageButtonMode = (hasData) => {
            if (!manageButton || !manageText) return;
            const addUrl = manageButton.dataset.addUrl;
            const editUrl = manageButton.dataset.editUrl;
            manageButton.dataset.hasValues = hasData ? '1' : '0';
            manageButton.setAttribute('href', hasData ? editUrl : addUrl);
            manageText.textContent = hasData ? 'Edit Nilai' : 'Tambah Nilai';
        };

        const toggleClearButton = (hasData) => {
            if (!clearButton) return;
            clearButton.disabled = !hasData;
        };

        const renderRows = () => {
            tableBody.innerHTML = '';
            const hasDataset = dataset.length > 0;
            if (!filtered.length) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                            <div class="flex flex-col items-center gap-3">
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </span>
                                <p class="font-medium">Belum ada data nilai.</p>
                                <p class="text-sm text-slate-400">Mulai dengan menambahkan kombinasi nilai baru.</p>
                            </div>
                        </td>
                    </tr>
                `;
                tableMeta.textContent = hasDataset ? 'Data tidak ditemukan' : 'Belum ada data nilai';
                setManageButtonMode(hasDataset);
                toggleClearButton(hasDataset);
                return;
            }

            const start = (currentPage - 1) * pageSize;
            const pageItems = filtered.slice(start, start + pageSize);

            pageItems.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-primary/5 transition-colors';
                row.innerHTML = `
                    <td class="px-6 py-4 text-sm text-slate-500">${start + index + 1}</td>
                    <td class="px-6 py-4 text-sm font-medium text-slate-700">${item.nama_komoditas ?? '-'}</td>
                    <td class="px-6 py-4 text-sm text-slate-500">${item.nama_kriteria ?? '-'}</td>
                    <td class="px-6 py-4 text-sm text-slate-500">${item.nilai ?? '-'}</td>
                `;
                tableBody.appendChild(row);
            });

            const totalPages = Math.ceil(filtered.length / pageSize) || 1;
            tableMeta.textContent = `Menampilkan ${pageItems.length} dari ${filtered.length} nilai`;
            prevPage.disabled = currentPage === 1;
            nextPage.disabled = currentPage === totalPages;
            renderPagination(totalPages);
            setManageButtonMode(dataset.length > 0);
            toggleClearButton(dataset.length > 0);
        };

        const renderPagination = (totalPages) => {
            pagination.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.textContent = i;
                button.className = `h-8 w-8 rounded-lg text-sm font-medium transition-all ${i === currentPage ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-slate-500 hover:bg-slate-100'}`;
                button.addEventListener('click', () => {
                    currentPage = i;
                    renderRows();
                });
                pagination.appendChild(button);
            }
        };

        const applyFilter = () => {
            const keyword = searchInput.value.trim().toLowerCase();
            filtered = dataset.filter(item => {
                return [item.nama_komoditas, item.nama_kriteria, item.nilai]
                    .filter(Boolean)
                    .some(value => String(value).toLowerCase().includes(keyword));
            });
            currentPage = 1;
            renderRows();
        };

        const fetchData = () => {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center">
                        <div class="flex flex-col items-center gap-3 text-slate-400 animate-pulse">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3" />
                                </svg>
                            </span>
                            <p class="text-sm">Memuat data nilai kriteria...</p>
                        </div>
                    </td>
                </tr>`;

            fetch(endpoint, { headers: { 'Accept': 'application/json' } })
                .then(response => response.json())
                .then(json => {
                    dataset = Array.isArray(json.data) ? json.data : [];
                    filtered = [...dataset];
                    currentPage = 1;
                    renderRows();
                })
                .catch(() => {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-rose-500">
                                Gagal memuat data. Silakan coba lagi.
                            </td>
                        </tr>`;
                    tableMeta.textContent = 'Gagal memuat data';
                });
        };

        clearButton?.addEventListener('click', () => {
            if (!clearEndpoint || clearButton.disabled) return;
            if (!confirm('Semua nilai akan dihapus. Lanjutkan?')) return;

            clearButton.classList.add('opacity-60', 'pointer-events-none');

            fetch(clearEndpoint, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
            })
                .then(res => res.json())
                .then(() => {
                    toast('Seluruh nilai dikosongkan');
                    dataset = [];
                    filtered = [];
                    currentPage = 1;
                    renderRows();
                    tableMeta.textContent = 'Data nilai kosong';
                })
                .catch(() => toast('Gagal mengosongkan nilai', 'error'))
                .finally(() => {
                    clearButton.classList.remove('opacity-60', 'pointer-events-none');
                });
        });

        prevPage.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderRows();
            }
        });

        nextPage.addEventListener('click', () => {
            const totalPages = Math.ceil(filtered.length / pageSize) || 1;
            if (currentPage < totalPages) {
                currentPage++;
                renderRows();
            }
        });

        searchInput.addEventListener('input', () => {
            applyFilter();
        });

        fetchData();
    });
</script>
<?= $this->endSection(); ?>
