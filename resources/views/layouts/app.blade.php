<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f3f0e8">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <title>@yield('title', 'Daftar tugas') — Kel</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-full flex-col">

    <a href="#main"
       class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-ink focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-paper">
        Lewati ke konten
    </a>

    <header class="sticky top-0 z-40 border-b border-line/80 bg-paper/85 backdrop-blur-md">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-3 px-5 sm:h-20 sm:px-8">

            <a href="{{ route('todos.index') }}" class="group flex items-center gap-3" aria-label="Kel — beranda">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[11px] bg-ink text-paper transition-colors duration-200 group-hover:bg-accent">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M7.5 5v14" />
                        <path d="M17 5 8.5 13" />
                        <path d="M8.5 13l4 4L17 10" />
                    </svg>
                </span>

                <span class="flex min-w-0 flex-col">
                    <span class="font-serif text-[27px] leading-none tracking-tight">Kel<span class="text-accent">.</span></span>
                    <span class="mt-1 font-mono text-[9px] uppercase tracking-[0.24em] text-muted">Catatan tugas</span>
                </span>
            </a>

            <nav class="flex items-center gap-1 sm:gap-2" aria-label="Navigasi utama">
                <a href="{{ route('todos.index') }}"
                   class="btn btn-ghost hidden sm:inline-flex {{ request()->routeIs('todos.index') ? 'text-ink' : '' }}">
                    Tugas
                </a>

                <a href="{{ route('todos.create') }}" class="btn btn-primary">
                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" aria-hidden="true">
                        <path d="M10 4v12M4 10h12" />
                    </svg>
                    <span class="sm:hidden">Baru</span>
                    <span class="hidden sm:inline">Tugas baru</span>
                </a>
            </nav>

        </div>
    </header>

    <main id="main" class="mx-auto w-full max-w-6xl flex-1 px-5 py-10 sm:px-8 sm:py-14">
        @include('partials.alerts')

        @yield('content')
    </main>

    <footer class="mt-auto border-t border-line/80">
        <div class="mx-auto flex max-w-6xl flex-col gap-3 px-5 py-7 sm:flex-row sm:items-center sm:justify-between sm:px-8">
            <p class="font-serif text-lg leading-none text-ink">Kel<span class="text-accent">.</span></p>

            <p class="meta">Dibuat dengan Laravel · Blade · SQLite</p>

            <p class="meta flex items-center gap-2">
                <span class="h-1.5 w-1.5 rounded-full bg-done" aria-hidden="true"></span>
                Siap dipakai
            </p>
        </div>
    </footer>

</body>
</html>
