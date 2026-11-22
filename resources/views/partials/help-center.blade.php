<!-- BANTUAN -->
<section id="faq" class="scroll-mt-20 bg-slate-50 px-5 py-20 sm:px-6 sm:py-24">
    <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:gap-16">
        <div>
            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">Pusat Bantuan</p>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Ada yang ingin ditanyakan?</h2>
            <p class="mt-4 max-w-md text-sm leading-6 text-slate-600">Ikuti langkah pemesanan atau temukan jawaban dari pertanyaan yang sering ditanyakan.</p>

            <div id="cara-order" class="scroll-mt-24 mt-8 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <h3 class="font-semibold text-slate-900">Cara Order</h3>
                <ol class="mt-5 space-y-4">
                    <li class="flex gap-3">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-700">1</span>
                        <p class="pt-1 text-sm leading-5 text-slate-600">Hubungi admin dan sebutkan jenis pakaian, jumlah, ukuran, serta tenggat waktu.</p>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-700">2</span>
                        <p class="pt-1 text-sm leading-5 text-slate-600">Kirim desain atau logo jika ada. Admin akan membantu cek spesifikasi dan estimasi.</p>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-700">3</span>
                        <p class="pt-1 text-sm leading-5 text-slate-600">Tinjau detail harga dan waktu produksi sebelum menyetujui pesanan.</p>
                    </li>
                </ol>
                <a
                    href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Halo Konvexa, saya ingin konsultasi pemesanan.') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-6 inline-flex items-center gap-2 rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                >
                    Hubungi Admin
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6 6 6-6 6"/>
                    </svg>
                </a>
            </div>
        </div>

        <div x-data="{ openFaq: null }" class="space-y-3">
            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                <h3>
                    <button type="button" @click="openFaq = openFaq === 1 ? null : 1" :aria-expanded="openFaq === 1" aria-controls="faq-answer-1"
                            class="flex w-full items-center justify-between gap-5 px-5 py-5 text-left text-sm font-semibold text-slate-900 sm:px-6">
                        <span>Bagaimana cara melakukan pemesanan?</span>
                        <svg class="h-4 w-4 shrink-0 text-slate-500 transition-transform" :class="openFaq === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                </h3>
                <div id="faq-answer-1" x-show="openFaq === 1" x-cloak x-transition class="px-5 pb-5 text-sm leading-6 text-slate-600 sm:px-6">
                    Hubungi WhatsApp admin dengan detail jenis pakaian, jumlah, ukuran, dan tenggat. Sertakan desain atau logo bila tersedia. Admin akan membantu mengecek kebutuhan dan mengirim estimasi sebelum pesanan disetujui.
                </div>
            </article>

            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                <h3>
                    <button type="button" @click="openFaq = openFaq === 2 ? null : 2" :aria-expanded="openFaq === 2" aria-controls="faq-answer-2"
                            class="flex w-full items-center justify-between gap-5 px-5 py-5 text-left text-sm font-semibold text-slate-900 sm:px-6">
                        <span>Apakah bisa menggunakan desain sendiri?</span>
                        <svg class="h-4 w-4 shrink-0 text-slate-500 transition-transform" :class="openFaq === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                </h3>
                <div id="faq-answer-2" x-show="openFaq === 2" x-cloak x-transition class="px-5 pb-5 text-sm leading-6 text-slate-600 sm:px-6">
                    Bisa. Kirim desain, logo, atau contoh referensi kepada admin. Tim akan mengecek detailnya dan mengonfirmasi spesifikasi sebelum produksi.
                </div>
            </article>

            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                <h3>
                    <button type="button" @click="openFaq = openFaq === 3 ? null : 3" :aria-expanded="openFaq === 3" aria-controls="faq-answer-3"
                            class="flex w-full items-center justify-between gap-5 px-5 py-5 text-left text-sm font-semibold text-slate-900 sm:px-6">
                        <span>Apakah ada jumlah minimum pesanan?</span>
                        <svg class="h-4 w-4 shrink-0 text-slate-500 transition-transform" :class="openFaq === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                </h3>
                <div id="faq-answer-3" x-show="openFaq === 3" x-cloak x-transition class="px-5 pb-5 text-sm leading-6 text-slate-600 sm:px-6">
                    Jumlah minimum dapat berbeda tergantung jenis pakaian dan bahan. Hubungi admin dengan kebutuhanmu untuk mendapat informasi yang sesuai.
                </div>
            </article>

            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                <h3>
                    <button type="button" @click="openFaq = openFaq === 4 ? null : 4" :aria-expanded="openFaq === 4" aria-controls="faq-answer-4"
                            class="flex w-full items-center justify-between gap-5 px-5 py-5 text-left text-sm font-semibold text-slate-900 sm:px-6">
                        <span>Berapa lama waktu produksinya?</span>
                        <svg class="h-4 w-4 shrink-0 text-slate-500 transition-transform" :class="openFaq === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                </h3>
                <div id="faq-answer-4" x-show="openFaq === 4" x-cloak x-transition class="px-5 pb-5 text-sm leading-6 text-slate-600 sm:px-6">
                    Waktu produksi bergantung pada jenis pakaian, jumlah pesanan, dan detail desain. Admin akan memberi estimasi setelah kebutuhan pesanan diketahui.
                </div>
            </article>

            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                <h3>
                    <button type="button" @click="openFaq = openFaq === 5 ? null : 5" :aria-expanded="openFaq === 5" aria-controls="faq-answer-5"
                            class="flex w-full items-center justify-between gap-5 px-5 py-5 text-left text-sm font-semibold text-slate-900 sm:px-6">
                        <span>Apakah pesanan bisa dikirim ke luar kota?</span>
                        <svg class="h-4 w-4 shrink-0 text-slate-500 transition-transform" :class="openFaq === 5 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                </h3>
                <div id="faq-answer-5" x-show="openFaq === 5" x-cloak x-transition class="px-5 pb-5 text-sm leading-6 text-slate-600 sm:px-6">
                    Hubungi admin dengan kota tujuan. Admin akan mengonfirmasi opsi pengiriman, biaya, dan estimasi waktu sebelum pesanan disepakati.
                </div>
            </article>
        </div>
    </div>
</section>
