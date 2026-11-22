<?php $__env->startSection('content'); ?>
    <div class="mx-auto max-w-3xl">
        <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-sm font-medium text-slate-500 hover:text-slate-900">← Kembali ke kategori</a>
        <h2 class="mt-3 text-2xl font-semibold tracking-tight">Tambah kategori</h2>
        <p class="mt-1 text-sm text-slate-500">Kategori aktif akan ditampilkan di katalog website.</p>

        <form method="POST" action="<?php echo e(route('admin.categories.store')); ?>" enctype="multipart/form-data"
              class="mt-6 space-y-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('admin.categories._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="<?php echo e(route('admin.categories.index')); ?>" class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">Batal</a>
                <button type="submit" class="rounded-xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Simpan kategori</button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', ['title' => 'Tambah Kategori'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ecomerce-knv\resources\views\admin\categories\create.blade.php ENDPATH**/ ?>