@if (session('success'))
    <div role="status"
         class="mb-6 flex items-start gap-3 rounded-xl border border-done/25 bg-done-soft px-4 py-3 text-sm text-done sm:mb-8">
        <svg viewBox="0 0 20 20" class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="m4 10.5 3.5 3.5L16 6" />
        </svg>

        <p class="leading-6">{{ session('success') }}</p>
    </div>
@endif

@if ($errors->any())
    <div role="alert"
         class="mb-6 rounded-xl border border-accent/25 bg-accent-soft px-4 py-4 text-sm text-accent-deep sm:mb-8">
        <p class="font-semibold">Ada yang perlu diperiksa.</p>

        <ul class="mt-2 list-inside list-disc space-y-1 marker:text-accent/60">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
