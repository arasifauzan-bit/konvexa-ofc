<div>
    <label for="name" class="mb-2 block text-sm font-semibold">Nama kategori <span class="text-rose-500">*</span></label>
    <input id="name" name="name" value="{{ old('name', $category->name) }}" required maxlength="255"
           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
    @error('name') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="slug" class="mb-2 block text-sm font-semibold">Slug URL</label>
    <input id="slug" name="slug" value="{{ old('slug', $category->slug) }}" maxlength="255"
           placeholder="Otomatis dari nama kategori"
           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
    <p class="mt-2 text-xs text-slate-400">Boleh dikosongkan; slug akan dibuat otomatis dari nama.</p>
    @error('slug') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="order" class="mb-2 block text-sm font-semibold">Urutan tampil</label>
    <input id="order" name="order" type="number" min="0" value="{{ old('order', $category->order ?? 0) }}" required
           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
    @error('order') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="image" class="mb-2 block text-sm font-semibold">Gambar kategori</label>
    @if ($category->image)
        <img src="{{ $category->image_url }}" alt="Gambar {{ $category->name }}" class="mb-3 h-28 w-36 rounded-xl bg-slate-100 object-contain p-2">
    @endif
    <input id="image" name="image" type="file" accept="image/*"
           class="block w-full rounded-xl border border-slate-200 text-sm file:mr-4 file:border-0 file:bg-slate-100 file:px-4 file:py-3 file:text-sm file:font-semibold file:text-slate-700">
    <p class="mt-2 text-xs text-slate-400">Format gambar umum, maksimal 2 MB.</p>
    @error('image') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>

<div class="rounded-xl bg-slate-50 px-4 py-3">
    <input type="hidden" name="is_active" value="0">
    <label class="flex cursor-pointer items-center gap-3 text-sm font-medium">
        <input type="checkbox" name="is_active" value="1"
               @checked(old('is_active', $category->exists ? $category->is_active : true))
               class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-500">
        Tampilkan kategori di katalog website
    </label>
    @error('is_active') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>

<script>
    const categoryName = document.getElementById('name');
    const categorySlug = document.getElementById('slug');
    let slugEdited = categorySlug.value !== '';

    categorySlug.addEventListener('input', () => {
        slugEdited = categorySlug.value !== '';
    });

    categoryName.addEventListener('input', () => {
        if (!slugEdited) {
            categorySlug.value = categoryName.value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '');
        }
    });
</script>
