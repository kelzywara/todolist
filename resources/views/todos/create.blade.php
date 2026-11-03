@extends('layouts.app')

@section('title', 'Tugas baru')

@section('content')

<div class="grid gap-10 lg:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)] lg:gap-14">

    <div class="lg:sticky lg:top-28 lg:self-start">
        <p class="eyebrow flex items-center gap-2">
            <span class="h-1.5 w-1.5 rounded-full bg-accent" aria-hidden="true"></span>
            Tugas baru
        </p>

        <h1 class="mt-4 font-serif text-[2.65rem] leading-[0.98] tracking-[-0.015em] sm:text-6xl">
            Mulai dari
            <em class="italic text-accent">satu hal.</em>
        </h1>

        <p class="mt-5 max-w-sm text-[15px] leading-7 text-ink-soft">
            Tulis dengan jelas, kerjakan dengan tenang. Kamu bisa mengubah detailnya kapan saja.
        </p>

        <ul class="mt-8 hidden space-y-4 border-t border-line pt-6 lg:block">
            <li class="flex gap-3">
                <span class="font-mono text-[11px] leading-6 text-accent-deep">01</span>
                <p class="text-sm leading-6 text-ink-soft">Awali judul dengan kata kerja supaya jelas.</p>
            </li>
            <li class="flex gap-3">
                <span class="font-mono text-[11px] leading-6 text-accent-deep">02</span>
                <p class="text-sm leading-6 text-ink-soft">Satu tugas, satu hasil yang bisa dicek.</p>
            </li>
            <li class="flex gap-3">
                <span class="font-mono text-[11px] leading-6 text-accent-deep">03</span>
                <p class="text-sm leading-6 text-ink-soft">Jangan menunggu sempurna untuk memulai.</p>
            </li>
        </ul>
    </div>

    <div class="surface-card overflow-hidden">
        <div class="flex items-center justify-between border-b border-line px-5 py-4 sm:px-7">
            <p class="meta">Detail tugas</p>
            <span class="font-mono text-[11px] uppercase tracking-[0.16em] text-muted">Baru</span>
        </div>

        <form action="{{ route('todos.store') }}" method="POST" class="space-y-6 p-5 sm:p-7">
            @csrf

            <div>
                <label for="title" class="field-label">
                    Judul tugas <span class="text-accent-deep" aria-hidden="true">*</span>
                </label>

                <input
                    id="title"
                    name="title"
                    type="text"
                    maxlength="255"
                    value="{{ old('title') }}"
                    placeholder="Contoh: Laporan bulanan"
                    class="field @error('title') is-invalid @enderror"
                    required
                    autocomplete="off"
                >

                @error('title')
                    <p class="mt-2 text-xs text-accent-deep">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex items-baseline justify-between gap-3">
                    <label for="description" class="field-label">Deskripsi</label>
                    <span class="meta">Opsional</span>
                </div>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    maxlength="5000"
                    placeholder="Tuliskan detail, target, atau langkah pengerjaannya..."
                    class="field resize-y @error('description') is-invalid @enderror"
                >{{ old('description') }}</textarea>

                <div class="mt-2 flex items-start justify-between gap-3">
                    @error('description')
                        <p class="text-xs text-accent-deep">{{ $message }}</p>
                    @else
                        <span></span>
                    @enderror

                    <p class="meta shrink-0">Maks. 5.000 karakter</p>
                </div>
            </div>

            <div class="rounded-xl border border-line bg-paper/50 p-4">
                <label for="is_completed" class="flex cursor-pointer items-start gap-3">
                    <input
                        id="is_completed"
                        type="checkbox"
                        name="is_completed"
                        value="1"
                        @checked(old('is_completed', false))
                        class="mt-0.5 h-5 w-5 shrink-0 cursor-pointer rounded accent-done"
                    >

                    <span>
                        <span class="block text-sm font-semibold text-ink">Tandai sudah selesai</span>
                        <span class="mt-0.5 block text-xs leading-5 text-muted">
                            Aktifkan kalau tugas ini memang sudah kamu kerjakan.
                        </span>
                    </span>
                </label>
            </div>

            <div class="flex flex-col gap-3 border-t border-line pt-6 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('todos.index') }}" class="btn btn-secondary w-full sm:w-auto">
                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15 10H5m0 0 4-4m-4 4 4 4" />
                    </svg>
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary w-full sm:w-auto">
                    Simpan tugas
                    <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 14 14 6M7 6h7v7" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
