<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f8fafc">
    <title>Tracking Pesanan — Konvexa</title>
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon-konvexa.png') }}?v=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <header class="border-b border-slate-200/80 bg-white/90 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-5 sm:px-6">
            <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight" aria-label="Konvexa — beranda">
                Konvexa <span class="ml-1 border-l border-slate-300 pl-2 text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Apparel</span>
            </a>
            <a href="{{ route('home') }}" class="text-sm font-medium text-slate-500 transition hover:text-slate-950">
                <span class="sm:hidden">Beranda</span>
                <span class="hidden sm:inline">Kembali ke beranda</span>
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-5 py-12 sm:px-6 sm:py-16">
        <div class="text-center">
            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-sky-700">Order update</p>
            <h1 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">Tracking Pesanan</h1>
            <p class="mx-auto mt-3 max-w-lg text-sm leading-6 text-slate-500">
                Masukkan nomor pesanan dan nama pelanggan yang digunakan saat memesan.
            </p>
        </div>

        <form method="POST" action="{{ route('tracking.lookup') }}" class="mt-8 rounded-3xl border border-slate-200 bg-white p-5 shadow-[0_16px_48px_rgba(15,23,42,0.06)] sm:p-7">
            @csrf
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="order_number" class="text-sm font-semibold text-slate-800">Nomor pesanan</label>
                    <input
                        id="order_number"
                        name="order_number"
                        type="text"
                        value="{{ old('order_number') }}"
                        placeholder="Contoh: KVX2610112"
                        autocomplete="off"
                        required
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm uppercase outline-none transition placeholder:normal-case placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                    >
                    @error('order_number')
                        <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="customer_name" class="text-sm font-semibold text-slate-800">Nama pelanggan</label>
                    <input
                        id="customer_name"
                        name="customer_name"
                        type="text"
                        value="{{ old('customer_name') }}"
                        placeholder="Contoh: KEVIN"
                        autocomplete="off"
                        required
                        oninput="this.value = this.value.toUpperCase()"
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm uppercase outline-none transition placeholder:normal-case placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                    >
                    @error('customer_name')
                        <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit" class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-950 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                Cek progres pesanan
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M5 12h14m-6-6 6 6-6 6"/>
                </svg>
            </button>
        </form>

        @if ($searched && ! $orderTracking)
            <div role="status" class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm leading-6 text-amber-900">
                Pesanan tidak ditemukan. Periksa kembali nomor pesanan dan nama pelanggan Anda.
            </div>
        @endif

        @if ($orderTracking)
            <section aria-labelledby="tracking-result-title" class="mt-8 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_16px_48px_rgba(15,23,42,0.06)]">
                <div class="flex flex-col gap-3 border-b border-slate-100 bg-gradient-to-r from-slate-50 via-white to-sky-50/70 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                    <div>
                        <p class="text-xs font-medium text-slate-500">Nomor pesanan</p>
                        <h2 id="tracking-result-title" class="mt-1 text-xl font-semibold tracking-wide">{{ $orderTracking->order_number }}</h2>
                    </div>
                    <span class="inline-flex w-fit items-center gap-2 rounded-full bg-sky-50 px-3.5 py-2 text-xs font-semibold text-sky-800">
                        <span class="h-1.5 w-1.5 rounded-full bg-sky-500"></span>
                        {{ $orderTracking->status_label }}
                    </span>
                </div>

                <div class="px-5 py-6 sm:px-7 sm:py-7">
                    <p class="text-sm font-semibold text-slate-900">
                        {{ $orderTracking->status === 'dapat_diambil' ? 'Pesanan Anda siap diambil.' : 'Progres produksi pesanan Anda' }}
                    </p>
                    <ol class="mt-6">
                        @foreach ($statuses as $status => $label)
                            @php
                                $statusIndex = $loop->index;
                                $isComplete = $statusIndex < $currentStatusIndex;
                                $isCurrent = $statusIndex === $currentStatusIndex;
                            @endphp
                            <li class="relative flex gap-4 pb-6 last:pb-0">
                                @if (! $loop->last)
                                    <span class="absolute left-[13px] top-7 h-[calc(100%-8px)] w-px {{ $isComplete ? 'bg-sky-400' : 'bg-slate-200' }}" aria-hidden="true"></span>
                                @endif
                                <span class="relative z-10 flex h-7 w-7 shrink-0 items-center justify-center rounded-full border text-xs font-semibold {{ $isComplete ? 'border-sky-500 bg-sky-500 text-white' : ($isCurrent ? 'border-sky-600 bg-white text-sky-700 ring-4 ring-sky-100' : 'border-slate-200 bg-white text-slate-400') }}">
                                    @if ($isComplete)
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 4 4L19 6"/>
                                        </svg>
                                    @else
                                        {{ $loop->iteration }}
                                    @endif
                                </span>
                                <div class="pt-1">
                                    <p class="text-sm {{ $isCurrent ? 'font-semibold text-slate-950' : ($isComplete ? 'font-medium text-slate-700' : 'text-slate-400') }}">{{ $label }}</p>
                                    @if ($isCurrent)
                                        <p class="mt-1 text-xs font-medium text-sky-700">Sedang berlangsung</p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ol>
                    <p class="mt-6 border-t border-slate-100 pt-4 text-xs text-slate-400">
                        Terakhir diperbarui {{ $orderTracking->updated_at->format('d/m/Y, H:i') }}
                    </p>
                </div>
            </section>
        @endif
    </main>
</body>
</html>
