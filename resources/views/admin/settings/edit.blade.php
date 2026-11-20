@extends('admin.layout', ['title' => 'Pengaturan Website'])

@section('content')
    <div class="mx-auto max-w-5xl">
        <div>
            <p class="text-sm text-slate-500">Kelola teks, kontak, media sosial, dan lokasi website.</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-tight">Pengaturan Website</h2>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="mb-5 border-b border-slate-100 pb-4">
                    <h3 class="font-semibold">Konten halaman utama</h3>
                    <p class="mt-1 text-xs text-slate-500">Teks yang tampil pada bagian hero dan tentang kami.</p>
                </div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="hero_badge" class="mb-2 block text-sm font-semibold">Label hero</label>
                        <input id="hero_badge" name="hero_badge" value="{{ old('hero_badge', $settings['hero_badge']) }}" required maxlength="100"
                               class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
                        @error('hero_badge') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="hero_title" class="mb-2 block text-sm font-semibold">Judul hero</label>
                        <input id="hero_title" name="hero_title" value="{{ old('hero_title', $settings['hero_title']) }}" required maxlength="120"
                               class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
                        @error('hero_title') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="hero_highlight" class="mb-2 block text-sm font-semibold">Baris judul kedua</label>
                        <input id="hero_highlight" name="hero_highlight" value="{{ old('hero_highlight', $settings['hero_highlight']) }}" required maxlength="120"
                               class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
                        @error('hero_highlight') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="hero_description" class="mb-2 block text-sm font-semibold">Deskripsi hero</label>
                        <textarea id="hero_description" name="hero_description" rows="3" required maxlength="1000"
                                  class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">{{ old('hero_description', $settings['hero_description']) }}</textarea>
                        @error('hero_description') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="about_intro" class="mb-2 block text-sm font-semibold">Tentang kami — paragraf pertama</label>
                        <textarea id="about_intro" name="about_intro" rows="4" required maxlength="2000"
                                  class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">{{ old('about_intro', $settings['about_intro']) }}</textarea>
                        @error('about_intro') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="about_commitment" class="mb-2 block text-sm font-semibold">Tentang kami — paragraf kedua</label>
                        <textarea id="about_commitment" name="about_commitment" rows="4" required maxlength="2000"
                                  class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">{{ old('about_commitment', $settings['about_commitment']) }}</textarea>
                        @error('about_commitment') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="mb-5 border-b border-slate-100 pb-4">
                    <h3 class="font-semibold">Lokasi dan kontak</h3>
                    <p class="mt-1 text-xs text-slate-500">Alamat ini digunakan untuk peta Google Maps dan Apple Maps.</p>
                </div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="location_name" class="mb-2 block text-sm font-semibold">Nama lokasi</label>
                        <input id="location_name" name="location_name" value="{{ old('location_name', $settings['location_name']) }}" required maxlength="150"
                               class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
                        @error('location_name') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="whatsapp_phone" class="mb-2 block text-sm font-semibold">Nomor WhatsApp</label>
                        <input id="whatsapp_phone" name="whatsapp_phone" value="{{ old('whatsapp_phone', $settings['whatsapp_phone']) }}" required maxlength="32"
                               placeholder="+62 895-4111-46879"
                               class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
                        @error('whatsapp_phone') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="location_address" class="mb-2 block text-sm font-semibold">Alamat untuk peta</label>
                        <textarea id="location_address" name="location_address" rows="3" required maxlength="1000"
                                  class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">{{ old('location_address', $settings['location_address']) }}</textarea>
                        @error('location_address') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="contact_email" class="mb-2 block text-sm font-semibold">Email kontak</label>
                        <input id="contact_email" name="contact_email" type="email" value="{{ old('contact_email', $settings['contact_email']) }}" required maxlength="255"
                               class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
                        @error('contact_email') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="mb-5 border-b border-slate-100 pb-4">
                    <h3 class="font-semibold">Media sosial</h3>
                    <p class="mt-1 text-xs text-slate-500">Kosongkan tautan jika akun tersebut tidak ingin ditampilkan.</p>
                </div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="instagram_url" class="mb-2 block text-sm font-semibold">URL Instagram</label>
                        <input id="instagram_url" name="instagram_url" type="url" value="{{ old('instagram_url', $settings['instagram_url']) }}" maxlength="255"
                               placeholder="https://instagram.com/akun"
                               class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
                        @error('instagram_url') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="instagram_handle" class="mb-2 block text-sm font-semibold">Nama akun Instagram</label>
                        <input id="instagram_handle" name="instagram_handle" value="{{ old('instagram_handle', $settings['instagram_handle']) }}" maxlength="100"
                               placeholder="@namapengguna"
                               class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
                        @error('instagram_handle') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="tiktok_url" class="mb-2 block text-sm font-semibold">URL TikTok</label>
                        <input id="tiktok_url" name="tiktok_url" type="url" value="{{ old('tiktok_url', $settings['tiktok_url']) }}" maxlength="255"
                               placeholder="https://tiktok.com/@akun"
                               class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
                        @error('tiktok_url') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="tiktok_handle" class="mb-2 block text-sm font-semibold">Nama akun TikTok</label>
                        <input id="tiktok_handle" name="tiktok_handle" value="{{ old('tiktok_handle', $settings['tiktok_handle']) }}" maxlength="100"
                               placeholder="@namapengguna"
                               class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-100">
                        @error('tiktok_handle') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>

            <div class="flex justify-end">
                <button type="submit" class="rounded-xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Simpan pengaturan
                </button>
            </div>
        </form>
    </div>
@endsection
