@extends('admin.layout', ['title' => 'Dashboard'])

@section('content')
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm text-slate-500">Ringkasan katalog website</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-tight">Selamat datang, {{ auth()->user()->name }}</h2>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="inline-flex items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            + Tambah kategori
        </a>
    </div>

    <div class="mt-7 grid gap-4 sm:grid-cols-3">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total kategori</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight">{{ $totalCategories }}</p>
            <p class="mt-1 text-xs text-slate-400">Terdaftar di katalog</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Kategori aktif</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-emerald-700">{{ $activeCategories }}</p>
            <p class="mt-1 text-xs text-slate-400">Ditampilkan di website</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Kategori nonaktif</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-500">{{ $inactiveCategories }}</p>
            <p class="mt-1 text-xs text-slate-400">Disembunyikan dari katalog</p>
        </article>
    </div>

    <section class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-5 py-4 sm:px-6">
            <div>
                <h3 class="font-semibold">Kategori terbaru</h3>
                <p class="mt-1 text-xs text-slate-500">Terakhir diperbarui</p>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-950">Semua kategori →</a>
        </div>
        @forelse ($recentCategories as $category)
            <div class="flex items-center gap-4 border-b border-slate-100 px-5 py-4 last:border-b-0 sm:px-6">
                <img src="{{ $category->image_url }}" alt="" class="h-12 w-12 rounded-xl bg-slate-100 object-cover">
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold">{{ $category->name }}</p>
                    <p class="mt-1 truncate text-xs text-slate-400">{{ $category->slug }}</p>
                </div>
                <span class="rounded-full px-3 py-1 text-xs font-medium {{ $category->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                    {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
                <a href="{{ route('admin.categories.edit', $category) }}" class="hidden text-sm font-medium text-slate-600 hover:text-slate-950 sm:block">Edit</a>
            </div>
        @empty
            <p class="px-6 py-10 text-center text-sm text-slate-500">Belum ada kategori. Tambahkan kategori pertama untuk mulai mengisi katalog.</p>
        @endforelse
    </section>
@endsection
