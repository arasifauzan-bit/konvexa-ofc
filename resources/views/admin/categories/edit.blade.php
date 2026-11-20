@extends('admin.layout', ['title' => 'Edit Kategori'])

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900">← Kembali ke kategori</a>
        <h2 class="mt-3 text-2xl font-semibold tracking-tight">Edit kategori</h2>
        <p class="mt-1 text-sm text-slate-500">Perbarui informasi kategori katalog.</p>

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data"
              class="mt-6 space-y-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
            @csrf
            @method('PUT')
            @include('admin.categories._form')
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.categories.index') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">Batal</a>
                <button type="submit" class="rounded-xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Simpan perubahan</button>
            </div>
        </form>
    </div>
@endsection
