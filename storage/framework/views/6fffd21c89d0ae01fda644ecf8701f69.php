<div>
    <label for="name" class="mb-2 block text-sm font-semibold">Nama kategori <span class="text-rose-500">*</span></label>
    <input id="name" name="name" value="<?php echo e(old('name', $category->name)); ?>" required maxlength="255"
           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-xs text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div>
    <label for="slug" class="mb-2 block text-sm font-semibold">Slug URL</label>
    <input id="slug" name="slug" value="<?php echo e(old('slug', $category->slug)); ?>" maxlength="255"
           placeholder="Otomatis dari nama kategori"
           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
    <p class="mt-2 text-xs text-slate-400">Boleh dikosongkan; slug akan dibuat otomatis dari nama.</p>
    <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-xs text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div>
    <label for="order" class="mb-2 block text-sm font-semibold">Urutan tampil</label>
    <input id="order" name="order" type="number" min="0" value="<?php echo e(old('order', $category->order ?? 0)); ?>" required
           class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
    <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-xs text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div>
    <label for="image" class="mb-2 block text-sm font-semibold">Gambar kategori</label>
    <?php if($category->image): ?>
        <img src="<?php echo e($category->image_url); ?>" alt="Gambar <?php echo e($category->name); ?>" class="mb-3 h-28 w-36 rounded-xl bg-slate-100 object-contain p-2">
    <?php endif; ?>
    <input id="image" name="image" type="file" accept="image/*"
           class="block w-full rounded-xl border border-slate-200 text-sm file:mr-4 file:border-0 file:bg-slate-100 file:px-4 file:py-3 file:text-sm file:font-semibold file:text-slate-700">
    <p class="mt-2 text-xs text-slate-400">Format gambar umum, maksimal 2 MB.</p>
    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-xs text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="rounded-xl bg-slate-50 px-4 py-3">
    <input type="hidden" name="is_active" value="0">
    <label class="flex cursor-pointer items-center gap-3 text-sm font-medium">
        <input type="checkbox" name="is_active" value="1"
               <?php if(old('is_active', $category->exists ? $category->is_active : true)): echo 'checked'; endif; ?>
               class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-500">
        Tampilkan kategori di katalog website
    </label>
    <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-xs text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
<?php /**PATH C:\laragon\www\ecomerce-knv\resources\views/admin/categories/_form.blade.php ENDPATH**/ ?>