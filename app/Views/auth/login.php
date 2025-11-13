<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | SPK Komoditas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.7s ease-out;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-950 relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute -top-10 -left-10 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-sky-500/20 blur-3xl"></div>
        <div class="absolute top-1/2 left-1/3 h-40 w-40 rounded-full bg-purple-500/10 blur-3xl"></div>
    </div>

    <main class="relative flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center text-white">
                <h1 class="text-3xl font-semibold tracking-tight fade-in-up">Sistem Pendukung Keputusan</h1>
                <p class="mt-2 text-slate-300 fade-in-up" style="animation-delay: 0.1s; animation-fill-mode: both;">
                    Masuk untuk mengelola data komoditas dan analisis metode TOPSIS & ELECTRE.
                </p>
            </div>

            <section class="fade-in-up" style="animation-delay: 0.2s; animation-fill-mode: both;">
                <div class="rounded-2xl border border-white/10 bg-slate-900/80 p-8 shadow-2xl backdrop-blur">
                    <?php $errors = session('errors') ?? []; ?>
                    <?php if (session('message')) : ?>
                        <div class="mb-4 rounded-lg border border-emerald-400/40 bg-emerald-500/10 p-3 text-sm text-emerald-200">
                            <?= esc(session('message')) ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session('error')) : ?>
                        <div class="mb-4 rounded-lg border border-rose-400/40 bg-rose-500/10 p-3 text-sm text-rose-200">
                            <?= esc(session('error')) ?>
                        </div>
                    <?php endif; ?>
                    <?php if (! empty($errors)) : ?>
                        <div class="mb-4 rounded-lg border border-amber-400/40 bg-amber-500/10 p-3 text-sm text-amber-200">
                            <ul class="list-disc space-y-1 pl-5">
                                <?php foreach ($errors as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('login') ?>" method="post" class="space-y-6">
                        <?= csrf_field() ?>
                        <div class="space-y-2">
                            <label for="username" class="block text-sm font-medium text-slate-200">Nama Pengguna</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 1115 0v.75H4.5v-.75z" />
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    value="<?= old('username') ?>"
                                    class="w-full rounded-xl border border-white/10 bg-slate-950/60 py-3 pl-11 pr-4 text-slate-100 placeholder:text-slate-500 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400/60"
                                    placeholder="Masukkan nama pengguna"
                                    autocomplete="username"
                                    required
                                >
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-slate-200">Kata Sandi</label>
                            <div class="relative group">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-indigo-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0V10.5M5.25 10.5h13.5m-1.5 0V18a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 015.25 18v-7.5" />
                                    </svg>
                                </span>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="w-full rounded-xl border border-white/10 bg-slate-950/60 py-3 pl-11 pr-12 text-slate-100 placeholder:text-slate-500 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400/60"
                                    placeholder="Masukkan kata sandi"
                                    autocomplete="current-password"
                                    required
                                >
                                <button type="button" data-password-toggle class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition hover:text-indigo-300 focus:outline-none">
                                    <svg data-password-toggle-icon="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg data-password-toggle-icon="hide" xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.86-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9.75l-7.5 7.5m0-7.5l7.5 7.5" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="group relative flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-500 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-2 focus:ring-offset-slate-900">
                            <span>Masuk</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.querySelectorAll('[data-password-toggle]').forEach(function (toggleButton) {
            toggleButton.addEventListener('click', function () {
                const passwordInput = toggleButton.parentElement.querySelector('input');
                const showIcon = toggleButton.querySelector('[data-password-toggle-icon="show"]');
                const hideIcon = toggleButton.querySelector('[data-password-toggle-icon="hide"]');

                const isHidden = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isHidden ? 'text' : 'password');
                showIcon.classList.toggle('hidden', !isHidden);
                hideIcon.classList.toggle('hidden', isHidden);
            });
        });
    </script>
</body>
</html>
