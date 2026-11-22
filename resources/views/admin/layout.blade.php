<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f172a">
    <title>{{ $title ?? 'Admin' }} — Konvexa</title>
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
    <div class="min-h-screen md:flex">
        <aside class="flex w-full flex-col bg-slate-950 text-white md:min-h-screen md:w-64 md:shrink-0">
            <div class="flex items-center justify-between border-b border-white/10 px-5 py-5 md:px-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 text-lg font-semibold tracking-tight">
                    <img src="{{ asset('image/konvexa-logo.png') }}" alt="" class="h-9 w-9 rounded-lg bg-white object-contain p-1">
                    <span>Konvexa <span class="font-normal text-slate-400">Admin</span></span>
                </a>
                <span class="rounded-full bg-white/10 px-2.5 py-1 text-[10px] font-medium uppercase tracking-wider text-slate-300">Panel</span>
            </div>

            <nav class="flex gap-2 overflow-x-auto px-3 py-3 md:flex-1 md:flex-col md:px-4 md:py-6">
                <p class="hidden px-3 pb-2 text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500 md:block">Menu utama</p>
                <a href="{{ route('admin.dashboard') }}"
                   class="whitespace-nowrap rounded-xl px-3 py-2.5 text-sm transition {{ request()->routeIs('admin.dashboard') ? 'bg-white text-slate-950 font-semibold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.tracking.index') }}"
                   class="whitespace-nowrap rounded-xl px-3 py-2.5 text-sm transition {{ request()->routeIs('admin.tracking.*') ? 'bg-white text-slate-950 font-semibold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    Tracking Pesanan
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="whitespace-nowrap rounded-xl px-3 py-2.5 text-sm transition {{ request()->routeIs('admin.categories.*') ? 'bg-white text-slate-950 font-semibold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    Kategori
                </a>
                <a href="{{ route('admin.settings.edit') }}"
                   class="whitespace-nowrap rounded-xl px-3 py-2.5 text-sm transition {{ request()->routeIs('admin.settings.*') ? 'bg-white text-slate-950 font-semibold' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    Pengaturan Website
                </a>
            </nav>

            <div class="hidden border-t border-white/10 p-4 md:block">
                <p class="truncate px-2 text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="truncate px-2 pt-1 text-xs text-slate-400">{{ auth()->user()->email }}</p>
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full rounded-xl px-3 py-2 text-left text-sm text-slate-300 transition hover:bg-white/10 hover:text-white">
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <main class="min-w-0 flex-1">
            <header class="flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4 sm:px-8">
                <div>
                    <p class="text-xs font-medium text-slate-400">Konvexa Apparel</p>
                    <h1 class="mt-1 text-lg font-semibold tracking-tight">{{ $title ?? 'Admin' }}</h1>
                </div>
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer"
                   class="rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-700 transition hover:border-slate-400 hover:text-slate-950">
                    Lihat website
                </a>
            </header>

            <div class="px-5 py-6 sm:px-8 sm:py-8">
                @if (session('status'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->has('category'))
                    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        {{ $errors->first('category') }}
                    </div>
                @endif

                @yield('content')
            </div>

            <div class="border-t border-slate-200 px-5 py-4 text-center text-xs text-slate-400 sm:px-8 md:hidden">
                <span>{{ auth()->user()->email }}</span>
                <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="ml-3 font-semibold text-slate-600">Keluar</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
