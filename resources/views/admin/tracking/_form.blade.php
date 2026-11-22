<div>
    <label for="order_number" class="text-sm font-semibold text-slate-800">Nomor pesanan</label>
    <input id="order_number" name="order_number" value="{{ old('order_number', $orderTracking->order_number) }}"
           placeholder="Contoh: KVX2610112" required maxlength="32" autocomplete="off"
           class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm uppercase outline-none transition focus:border-slate-500">
    @error('order_number') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="customer_name" class="text-sm font-semibold text-slate-800">Nama pelanggan</label>
    <input id="customer_name" name="customer_name" value="{{ old('customer_name', $orderTracking->customer_name) }}"
           placeholder="Contoh: KEVIN" required maxlength="100" autocomplete="off"
           oninput="this.value = this.value.toUpperCase()"
           class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm uppercase outline-none transition focus:border-slate-500 placeholder:normal-case">
    @error('customer_name') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="status" class="text-sm font-semibold text-slate-800">Progres pesanan</label>
    <select id="status" name="status" required
            class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-500">
        @foreach ($statuses as $value => $label)
            <option value="{{ $value }}" @selected(old('status', $orderTracking->status) === $value)>{{ $label }}</option>
        @endforeach
    </select>
    @error('status') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="progress_note" class="text-sm font-semibold text-slate-800">Keterangan proses <span class="font-normal text-slate-400">(opsional)</span></label>
    <textarea id="progress_note" name="progress_note" rows="3" maxlength="500"
              placeholder="Contoh: Bordir dulu, kemudian dijahit."
              class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-slate-500">{{ old('progress_note', $orderTracking->progress_note) }}</textarea>
    <p class="mt-1.5 text-xs text-slate-400">Gunakan keterangan ini untuk menjelaskan urutan jahit dan bordir sesuai pesanan.</p>
    @error('progress_note') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
</div>
