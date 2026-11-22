<?php $__env->startSection('content'); ?>
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm text-slate-500">Ringkasan katalog website</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-tight">Selamat datang, <?php echo e(auth()->user()->name); ?></h2>
        </div>
        <a href="<?php echo e(route('admin.categories.create')); ?>"
           class="inline-flex items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            + Tambah kategori
        </a>
    </div>

    <div class="mt-7 grid gap-4 sm:grid-cols-3">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total kategori</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight"><?php echo e($totalCategories); ?></p>
            <p class="mt-1 text-xs text-slate-400">Terdaftar di katalog</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Kategori aktif</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-emerald-700"><?php echo e($activeCategories); ?></p>
            <p class="mt-1 text-xs text-slate-400">Ditampilkan di website</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">Kategori nonaktif</p>
            <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-500"><?php echo e($inactiveCategories); ?></p>
            <p class="mt-1 text-xs text-slate-400">Disembunyikan dari katalog</p>
        </article>
    </div>

    <section class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-5 py-4 sm:px-6">
            <div>
                <h3 class="font-semibold">Kategori terbaru</h3>
                <p class="mt-1 text-xs text-slate-500">Terakhir diperbarui</p>
            </div>
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-sm font-semibold text-slate-700 hover:text-slate-950">Semua kategori →</a>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $recentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center gap-4 border-b border-slate-100 px-5 py-4 last:border-b-0 sm:px-6">
                <img src="<?php echo e($category->image_url); ?>" alt="" class="h-12 w-12 rounded-xl bg-slate-100 object-cover">
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold"><?php echo e($category->name); ?></p>
                    <p class="mt-1 truncate text-xs text-slate-400"><?php echo e($category->slug); ?></p>
                </div>
                <span class="rounded-full px-3 py-1 text-xs font-medium <?php echo e($category->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500'); ?>">
                    <?php echo e($category->is_active ? 'Aktif' : 'Nonaktif'); ?>

                </span>
                <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="hidden text-sm font-medium text-slate-600 hover:text-slate-950 sm:block">Edit</a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="px-6 py-10 text-center text-sm text-slate-500">Belum ada kategori. Tambahkan kategori pertama untuk mulai mengisi katalog.</p>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', ['title' => 'Dashboard'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ecomerce-knv\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>