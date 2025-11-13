<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Panel SPK Komoditas Tambak'); ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        primaryDark: '#1d4ed8',
                        accent: '#0f172a',
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        floating: '0 20px 45px -15px rgba(15, 23, 42, 0.25)',
                    },
                    keyframes: {
                        'fade-in-up': {
                            '0%': { opacity: 0, transform: 'translateY(10px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' },
                        },
                    },
                    animation: {
                        'fade-in-up': 'fade-in-up 0.6s ease-out both',
                    },
                },
            },
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-feature-settings: "liga" 1, "kern" 1;
        }
        .glass-panel {
            backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 font-sans">
    <div class="flex min-h-screen">
        <?= $this->include('panel/partials/sidebar'); ?>
        <div class="flex-1 flex flex-col">
            <?= $this->include('panel/partials/navbar'); ?>
            <main class="flex-1 p-6 lg:p-10">
                <div class="space-y-8 animate-fade-in-up">
                    <?= $this->renderSection('content'); ?>
                </div>
            </main>
        </div>
    </div>
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <?= $this->renderSection('scripts'); ?>
</body>
</html>
