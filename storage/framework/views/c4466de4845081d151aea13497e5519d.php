<?php $__env->startSection('content'); ?>
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm text-slate-500">Catat pesanan dan perbarui tahap produksinya.</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-tight">Tracking pesanan</h2>
        </div>
        <a href="<?php echo e(route('admin.tracking.create')); ?>"
           class="inline-flex items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            + Tambah pesanan
        </a>
    </div>

    <form method="GET" action="<?php echo e(route('admin.tracking.index')); ?>" class="mt-6 flex max-w-lg gap-2">
        <input type="search" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nomor pesanan..."
               class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-500">
        <button class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold transition hover:bg-slate-100">Cari</button>
    </form>

    <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Nomor pesanan</th>
                        <th class="px-5 py-4">Nama pelanggan</th>
                        <th class="px-5 py-4">Progres</th>
                        <th class="px-5 py-4">Diperbarui</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $orderTrackings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderTracking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-5 py-4 text-sm font-semibold tracking-wide text-slate-900"><?php echo e($orderTracking->order_number); ?></td>
                            <td class="px-5 py-4 text-sm font-medium text-slate-600"><?php echo e($orderTracking->customer_name); ?></td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-medium text-sky-800"><?php echo e($orderTracking->status_label); ?></span>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-500"><?php echo e($orderTracking->updated_at->format('d/m/Y')); ?></td>
                            <td class="px-5 py-4 text-right">
                                <a href="<?php echo e(route('admin.tracking.edit', $orderTracking)); ?>" class="text-sm font-semibold text-slate-700 hover:text-slate-950">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-5 py-14 text-center text-sm text-slate-500">Belum ada data tracking pesanan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($orderTrackings->hasPages()): ?>
            <div class="border-t border-slate-100 px-5 py-4"><?php echo e($orderTrackings->links()); ?></div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', ['title' => 'Tracking Pesanan'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ecomerce-knv\resources\views\admin\tracking\index.blade.php ENDPATH**/ ?>