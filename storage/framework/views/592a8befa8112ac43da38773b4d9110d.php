<div>
    <label for="order_number" class="text-sm font-semibold text-slate-800">Nomor pesanan</label>
    <input id="order_number" name="order_number" value="<?php echo e(old('order_number', $orderTracking->order_number)); ?>"
           placeholder="Contoh: KVX2610112" required maxlength="32" autocomplete="off"
           class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm uppercase outline-none transition focus:border-slate-500">
    <?php $__errorArgs = ['order_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div>
    <label for="customer_name" class="text-sm font-semibold text-slate-800">Nama pelanggan</label>
    <input id="customer_name" name="customer_name" value="<?php echo e(old('customer_name', $orderTracking->customer_name)); ?>"
           placeholder="Contoh: KEVIN" required maxlength="100" autocomplete="off"
           oninput="this.value = this.value.toUpperCase()"
           class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm uppercase outline-none transition focus:border-slate-500 placeholder:normal-case">
    <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div>
    <label for="status" class="text-sm font-semibold text-slate-800">Progres pesanan</label>
    <select id="status" name="status" required
            class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-500">
        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($value); ?>" <?php if(old('status', $orderTracking->status) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<?php /**PATH C:\laragon\www\ecomerce-knv\resources\views/admin/tracking/_form.blade.php ENDPATH**/ ?>