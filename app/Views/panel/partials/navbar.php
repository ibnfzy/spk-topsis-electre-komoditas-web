<header class="sticky top-0 z-30 bg-slate-50/80 backdrop-blur border-b border-slate-200/60">
    <div class="flex items-center justify-between px-6 lg:px-10 py-4">
        <div class="flex items-center gap-3 lg:hidden">
            <button type="button" class="p-2 rounded-xl bg-white shadow shadow-slate-200 text-slate-500 hover:text-primary transition" hx-get="#">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                </svg>
            </button>
            <h2 class="text-lg font-semibold text-slate-900">Panel SPK</h2>
        </div>
        <div class="hidden lg:flex items-center gap-3">
            <div class="relative">
                <input type="search" placeholder="Cari data..." class="w-64 rounded-2xl border-0 bg-white/70 shadow shadow-slate-200 focus:ring-2 focus:ring-primary/40 px-4 py-2 text-sm text-slate-600 placeholder:text-slate-400">
                <span class="absolute inset-y-0 right-3 flex items-center text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                    </svg>
                </span>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-xl bg-white shadow shadow-slate-200 text-sm text-slate-500">
                <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="font-medium">Sistem Aktif</span>
            </div>
            <button class="relative flex items-center gap-3 rounded-2xl bg-white px-3 py-2 shadow shadow-slate-200 hover:shadow-floating transition-all">
                <span class="h-10 w-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.25a8.25 8.25 0 1115 0v.75H4.5v-.75z" />
                    </svg>
                </span>
                <div class="text-left">
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Administrator</p>
                    <p class="text-sm font-semibold text-slate-700">Nama Pengguna</p>
                </div>
            </button>
        </div>
    </div>
</header>
