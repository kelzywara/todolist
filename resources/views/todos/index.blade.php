@extends('layouts.app')

@section('title', 'Daftar tugas')

@section('content')

@php
    $total = $todos->count();
    $completed = $todos->where('is_completed', true)->count();
    $open = $total - $completed;
    $rate = $total > 0 ? (int) round(($completed / $total) * 100) : 0;
@endphp

<section class="grid gap-10 lg:grid-cols-[minmax(0,1.5fr)_minmax(0,1fr)] lg:items-end lg:gap-14">

    <div>
        <div class="flex items-center gap-3">
            <span class="h-px w-8 bg-accent" aria-hidden="true"></span>
            <p class="eyebrow">{{ now()->locale('id')->translatedFormat('l, j F Y') }}</p>
        </div>

        <h1 class="mt-5 max-w-2xl font-serif text-[2.65rem] leading-[0.98] tracking-[-0.015em] sm:text-6xl lg:text-[4.5rem]">
            Beri ruang untuk
            <em class="whitespace-nowrap italic text-accent">yang penting.</em>
        </h1>

        <p class="mt-5 max-w-lg text-[15px] leading-7 text-ink-soft">
            Satu tempat tenang untuk mencatat, mengerjakan, dan menyelesaikan hal-hal yang benar-benar penting.
        </p>
    </div>

    <aside class="surface-card p-5 sm:p-6" aria-label="Ringkasan progres">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="eyebrow">Progres</p>
                <p class="mt-2 font-serif text-4xl leading-none">
                    {{ $rate }}<span class="ml-1 font-sans text-base font-medium text-muted">%</span>
                </p>
            </div>
            <p class="meta pb-1">{{ $completed }} dari {{ $total }} selesai</p>
        </div>

        <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-paper-deep"
             role="img"
             aria-label="{{ $rate }}% tugas selesai">
            <div class="h-full rounded-full bg-done transition-[width] duration-500" style="width: {{ $rate }}%"></div>
        </div>

        <dl class="mt-5 grid grid-cols-3 divide-x divide-line border-t border-line pt-4">
            <div class="pr-3">
                <dt class="meta">Terbuka</dt>
                <dd class="mt-1.5 font-serif text-3xl leading-none">{{ $open }}</dd>
            </div>
            <div class="px-3">
                <dt class="meta">Selesai</dt>
                <dd class="mt-1.5 font-serif text-3xl leading-none text-done">{{ $completed }}</dd>
            </div>
            <div class="pl-3">
                <dt class="meta">Total</dt>
                <dd class="mt-1.5 font-serif text-3xl leading-none">{{ $total }}</dd>
            </div>
        </dl>
    </aside>

</section>

<section class="mt-12 sm:mt-16">

    <div class="flex flex-wrap items-end justify-between gap-3 border-b border-line pb-4">
        <h2 class="font-serif text-3xl leading-none sm:text-4xl">
            Daftar tugas
            <span class="ml-1 align-middle font-sans text-sm font-medium text-muted">({{ $total }})</span>
        </h2>

        <p class="meta">{{ $open }} terbuka · {{ $completed }} selesai</p>
    </div>

    @forelse ($todos as $todo)

        <article class="group flex items-start gap-3 border-b border-line py-5 transition-colors duration-200 hover:bg-surface/60 sm:gap-5 sm:py-6">

            <form action="{{ route('todos.toggle', $todo) }}" method="POST" class="shrink-0 pt-1">
                @csrf
                @method('PATCH')

                <button type="submit"
                        aria-pressed="{{ $todo->is_completed ? 'true' : 'false' }}"
                        aria-label="{{ $todo->is_completed ? 'Tandai belum selesai: '.$todo->title : 'Tandai selesai: '.$todo->title }}"
                        class="flex h-6 w-6 items-center justify-center rounded-full border transition-colors duration-200 {{ $todo->is_completed ? 'border-done bg-done text-paper' : 'border-line-strong bg-transparent text-transparent hover:border-done hover:text-done' }}">
                    <svg viewBox="0 0 20 20" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m4 10.5 3.5 3.5L16 6" />
                    </svg>
                </button>
            </form>

            <div class="min-w-0 flex-1">

                <div class="flex items-start justify-between gap-3">
                    <h3 class="min-w-0 text-[17px] font-semibold leading-snug sm:text-lg">
                        <a href="{{ route('todos.show', $todo) }}"
                           class="break-words transition-colors duration-200 hover:text-accent-deep {{ $todo->is_completed ? 'text-muted line-through decoration-line-strong' : 'text-ink' }}">
                            {{ $todo->title }}
                        </a>
                    </h3>

                    <div class="hidden shrink-0 items-center gap-1 sm:flex">
                        <a href="{{ route('todos.edit', $todo) }}"
                           class="btn btn-ghost h-9 w-9 p-0"
                           aria-label="Edit {{ $todo->title }}">
                            <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M13.2 4.3 15.7 6.8 8.2 14.3H5.7v-2.5l7.5-7.5Z" />
                            </svg>
                        </a>

                        <form action="{{ route('todos.destroy', $todo) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus tugas ini? Tindakan ini tidak bisa dibatalkan.')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-ghost h-9 w-9 p-0 hover:bg-accent-soft hover:text-accent-deep"
                                    aria-label="Hapus {{ $todo->title }}">
                                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M4 6h12M8 6V4.5h4V6m-6 0 .6 9.5h6.8L14 6M8.5 9v4M11.5 9v4" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                @if ($todo->description)
                    <p class="mt-1.5 line-clamp-2 max-w-2xl text-sm leading-6 text-ink-soft">{{ $todo->description }}</p>
                @endif

                <div class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1.5">
                    <span class="meta">#{{ str_pad($todo->id, 3, '0', STR_PAD_LEFT) }}</span>
                    <span class="h-3 w-px bg-line" aria-hidden="true"></span>

                    @if ($todo->is_completed)
                        <span class="meta text-done">Selesai</span>
                    @else
                        <span class="meta text-accent-deep">Terbuka</span>
                    @endif

                    <span class="h-3 w-px bg-line" aria-hidden="true"></span>

                    <time class="meta" datetime="{{ $todo->created_at->toDateString() }}">
                        {{ $todo->created_at->locale('id')->translatedFormat('j M Y') }}
                    </time>
                </div>

                <div class="mt-3 flex items-center gap-1 sm:hidden">
                    <a href="{{ route('todos.edit', $todo) }}" class="btn btn-ghost px-2.5 py-1.5 text-xs">
                        <svg viewBox="0 0 20 20" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M13.2 4.3 15.7 6.8 8.2 14.3H5.7v-2.5l7.5-7.5Z" />
                        </svg>
                        Edit
                    </a>

                    <form action="{{ route('todos.destroy', $todo) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus tugas ini? Tindakan ini tidak bisa dibatalkan.')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-ghost px-2.5 py-1.5 text-xs hover:bg-accent-soft hover:text-accent-deep">
                            <svg viewBox="0 0 20 20" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M4 6h12M8 6V4.5h4V6m-6 0 .6 9.5h6.8L14 6M8.5 9v4M11.5 9v4" />
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        </article>

    @empty

        <div class="surface-card mt-6 flex flex-col items-start gap-6 p-6 sm:flex-row sm:items-center sm:justify-between sm:p-8">
            <div class="flex items-start gap-4">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-paper-deep text-accent-deep">
                    <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 5h10M9 12h10M9 19h10" />
                        <path d="m4 5 .9.9L6.5 4.3M4 12l.9.9 1.6-1.6M4 19l.9.9 1.6-1.6" />
                    </svg>
                </span>

                <div>
                    <h3 class="font-serif text-2xl leading-tight">Masih kosong.</h3>
                    <p class="mt-1 max-w-sm text-sm leading-6 text-ink-soft">
                        Belum ada tugas. Mulai dengan satu hal kecil yang bisa kamu selesaikan hari ini.
                    </p>
                </div>
            </div>

            <a href="{{ route('todos.create') }}" class="btn btn-primary w-full sm:w-auto">
                <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" aria-hidden="true">
                    <path d="M10 4v12M4 10h12" />
                </svg>
                Tugas pertama
            </a>
        </div>

    @endforelse

</section>

@endsection
