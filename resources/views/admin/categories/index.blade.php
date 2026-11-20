@extends('admin.layout', ['title' => 'Kelola Kategori'])

@section('content')
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm text-slate-500">Atur kategori yang muncul di katalog publik.</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-tight">Kategori katalog</h2>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="inline-flex items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            + Tambah kategori
        </a>
    </div>

    <form method="GET" action="{{ route('admin.categories.index') }}" class="mt-6 flex max-w-lg gap-2">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama kategori..."
               class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-500">
        <button class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold transition hover:bg-slate-100">Cari</button>
    </form>

    <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Kategori</th>
                        <th class="px-5 py-4">Urutan</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $category->image_url }}" alt="" class="h-12 w-12 rounded-xl bg-slate-100 object-cover">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-slate-900">{{ $category->name }}</p>
                                        <p class="mt-1 truncate text-xs text-slate-400">{{ $category->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-600">{{ $category->order }}</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-medium {{ $category->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-sm font-semibold text-slate-700 hover:text-slate-950">Edit</a>
                                    @if ($category->products_count === 0)
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                              onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-semibold text-rose-600 hover:text-rose-800">Hapus</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400" title="Kategori ini masih dipakai produk">Dipakai</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-14 text-center text-sm text-slate-500">Belum ada kategori yang cocok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($categories->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">{{ $categories->links() }}</div>
        @endif
    </div>
@endsection
