<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knihovna - Přehled knih</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Konfigurace Tailwindu pro vlastní odstíny modré (volitelné, ale doporučené)
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            light: '#e0f2fe', // sky-100
                            DEFAULT: '#0284c7', // sky-600
                            dark: '#0369a1', // sky-700
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white text-slate-900 font-sans min-h-screen">

    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-3xl">📚</span>
                <h1 class="text-2xl font-bold text-slate-950 tracking-tight">Knihovna<span class="text-brand"></span></h1>
            </div>
            
            <nav>
                <ul class="flex items-center space-x-2">
                    <li>
                        <a href="<?= BASE_URL ?>/index.php" class="bg-brand-light text-brand-dark px-4 py-2 rounded-lg font-semibold text-sm hover:bg-sky-200 transition">
                            Přehled
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=book/create" class="bg-brand text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-brand-dark transition shadow-sm flex items-center space-x-1.5">
                            <span>+</span> <span>Přidat knihu</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>