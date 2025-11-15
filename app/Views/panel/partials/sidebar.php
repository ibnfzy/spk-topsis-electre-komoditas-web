<?php
    $uri     = service('uri');
    $segment = trim($uri->getPath(), '/');
    $menus   = [
        [
            'label' => 'Dashboard',
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v9.75A1.5 1.5 0 006 21h12a1.5 1.5 0 001.5-1.5V9.75" /></svg>',
            'link'  => base_url('panel'),
            'match' => 'panel',
        ],
        [
            'label' => 'Komoditas',
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5M3.75 9h16.5m-16.5 3.75h16.5m-16.5 3.75h16.5" /></svg>',
            'link'  => base_url('panel/komoditas'),
            'match' => 'panel/komoditas',
        ],
        [
            'label' => 'Kriteria',
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" /></svg>',
            'link'  => base_url('panel/kriteria'),
            'match' => 'panel/kriteria',
        ],
        [
            'label' => 'Bobot Kriteria',
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3" /></svg>',
            'link'  => base_url('panel/bobot-kriteria'),
            'match' => 'panel/bobot-kriteria',
        ],
        [
            'label' => 'Nilai Kriteria',
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>',
            'link'  => base_url('panel/nilai-kriteria'),
            'match' => 'panel/nilai-kriteria',
        ],
        [
            'label' => 'Hasil TOPSIS',
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 17.25l3.75-3.75 3 3 6-6" /></svg>',
            'link'  => base_url('panel/spk/topsis'),
            'match' => 'panel/spk/topsis',
        ],
        [
            'label' => 'Hasil ELECTRE',
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
            'link'  => base_url('panel/spk/electre'),
            'match' => 'panel/spk/electre',
        ],
        [
            'label' => 'Perbandingan SPK',
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 4.5v15m0 0h15M4.5 12h10.5m0 0L12 9m3 3l-3 3" /></svg>',
            'link'  => base_url('panel/spk/bandingkan'),
            'match' => 'panel/spk/bandingkan',
        ],
    ];
?>
<aside class="hidden lg:flex lg:flex-col lg:w-64 xl:w-72 bg-white/90 glass-panel border-r border-slate-200/80 shadow-lg shadow-slate-200/40">
    <div class="px-6 pt-8 pb-6 border-b border-slate-200/80">
        <div class="flex items-center gap-3">
            <div class="h-11 w-11 rounded-2xl bg-primary/10 text-primary flex items-center justify-center shadow-floating">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M11.25 2.25a.75.75 0 011.5 0v1.012a6.75 6.75 0 015.988 5.988H19.5a.75.75 0 010 1.5h-1.012a6.75 6.75 0 01-5.988 5.988V21a.75.75 0 01-1.5 0v-1.012a6.75 6.75 0 01-5.988-5.988H4.5a.75.75 0 010-1.5h1.012a6.75 6.75 0 015.988-5.988z" />
                </svg>
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-slate-400">SPK PANEL</p>
                <h1 class="text-lg font-semibold text-slate-900">Komoditas Tambak</h1>
            </div>
        </div>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <?php foreach ($menus as $item):
            $isActive = $segment === trim($item['match'], '/');
        ?>
            <a href="<?= $item['link']; ?>"
               class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= $isActive ? 'bg-primary text-white shadow-floating' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80'; ?>">
                <span class="flex items-center justify-center w-9 h-9 rounded-lg <?= $isActive ? 'bg-white/20 text-white' : 'bg-slate-100 text-primary group-hover:bg-primary/10 group-hover:text-primary'; ?>">
                    <?= $item['icon']; ?>
                </span>
                <span class="font-medium tracking-tight"><?= esc($item['label']); ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
    <div class="px-6 py-6 border-t border-slate-200/70">
        <div class="rounded-2xl bg-gradient-to-br from-primary to-primaryDark text-white p-4 shadow-floating">
            <p class="text-sm font-medium leading-relaxed">Optimalkan proses keputusan budidaya tambak dengan metode TOPSIS & ELECTRE.</p>
        </div>
    </div>
</aside>
