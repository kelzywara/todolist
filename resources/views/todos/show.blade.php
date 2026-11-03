@extends('layouts.app')

@section('title', $todo->title)

@section('content')

<div class="mx-auto max-w-4xl">

    <a href="{{ route('todos.index') }}"
       class="meta inline-flex items-center gap-2 transition-colors duration-200 hover:text-ink">
        <svg viewBox="0 0 20 20" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M15 10H5m0 0 4-4m-4 4 4 4" />
        </svg>
        Semua tugas
    </a>

    <div class="mt-6 flex flex-wrap items-center gap-x-3 gap-y-2">
        @if ($todo->is_completed)
            <span class="inline-flex items-center gap-1.5 rounded-full border border-done/20 bg-done-soft px-2.5 py-1 font-mono text-[10px] uppercase tracking-[0.14em] text-done">
                <span class="h-1.5 w-1.5 rounded-full bg-done" aria-hidden="true"></span>
                Selesai
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 rounded-full border border-accent/20 bg-accent-soft px-2.5 py-1 font-mono text-[10px] uppercase tracking-[0.14em] text-accent-deep">
                <span class="h-1.5 w-1.5 rounded-full bg-accent" aria-hidden="true"></span>
                Terbuka
            </span>
        @endif

        <span class="meta">#{{ str_pad($todo->id, 3, '0', STR_PAD_LEFT) }}</span>

        <span class="h-3 w-px bg-line" aria-hidden="true"></span>

        <time class="meta" datetime="{{ $todo->created_at->toDateString() }}">
            Dibuat {{ $todo->created_at->locale('id')->translatedFormat('j M Y') }}
        </time>
    </div>

    <h1 class="mt-4 max-w-3xl break-words font-serif text-[2.5rem] leading-[1.05] tracking-[-0.015em] sm:text-6xl">
        {{ $todo->title }}
    </h1>

    <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,1.6fr)_minmax(0,1fr)] lg:gap-10">

        <div>
            <h2 class="meta">Deskripsi</h2>

            <div class="surface-card mt-3 p-5 sm:p-7">
                @if ($todo->description)
                    <p class="prose-body">{{ $todo->description }}</p>
                @else
                    <p class="text-sm italic text-muted">Belum ada deskripsi untuk tugas ini.</p>
                @endif
            </div>
        </div>

        <aside class="space-y-4">
            <div class="surface-card p-5">
                <h2 class="meta">Ringkasan</h2>

                <dl class="mt-4 space-y-3">
                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-xs text-muted">Status</dt>
                        <dd class="text-xs font-semibold {{ $todo->is_completed ? 'text-done' : 'text-accent-deep' }}">
                            {{ $todo->is_completed ? 'Selesai' : 'Belum selesai' }}
                        </dd>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-xs text-muted">Dibuat</dt>
                        <dd class="font-mono text-[11px] text-ink">
                            {{ $todo->created_at->locale('id')->translatedFormat('j M Y') }}
                        </dd>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-xs text-muted">Diperbarui</dt>
                        <dd class="font-mono text-[11px] text-ink">
                            {{ $todo->updated_at->locale('id')->translatedFormat('j M Y') }}
                        </dd>
                    </div>
                </dl>

                <form action="{{ route('todos.toggle', $todo) }}" method="POST" class="mt-5 border-t border-line pt-4">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="btn btn-secondary w-full">
                        @if ($todo->is_completed)
                            Tandai belum selesai
                        @else
                            Tandai selesai
                        @endif
                    </button>
                </form>
            </div>

            <div class="flex flex-col gap-2">
                <a href="{{ route('todos.edit', $todo) }}" class="btn btn-primary w-full">
                    Edit tugas
                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 14 14 6M7 6h7v7" />
                    </svg>
                </a>

                <form action="{{ route('todos.destroy', $todo) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus tugas ini? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger w-full">Hapus tugas</button>
                </form>
            </div>
        </aside>

    </div>

</div>

@endsection
