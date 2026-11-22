<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konvexa Apparel | Konveksi Murah Berkualitas</title>
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon-konvexa.png') }}?v=1">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'DM Sans', system-ui, sans-serif; }

        .hero-title {
            color: #17283d;
            font-size: clamp(2.2rem, 4vw, 3.4rem);
            font-weight: 600;
            letter-spacing: -0.045em;
            line-height: 1.08;
        }

        .hero-title span {
            color: #17283d;
            display: block;
            font-size: 1em;
            font-weight: 600;
            letter-spacing: inherit;
            margin-top: 0.03em;
        }

        .hero-section {
            background:
                radial-gradient(ellipse at 76% 40%, rgba(91, 163, 222, 0.22) 0%, rgba(91, 163, 222, 0.09) 26%, transparent 50%),
                radial-gradient(ellipse at 34% 96%, rgba(105, 132, 201, 0.09), transparent 38%),
                linear-gradient(180deg, #f9fafc 0%, #f4f6fa 56%, #fbfcfe 100%);
        }

        .hero-background-art {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .hero-benefits {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.58) 55%, #fff 100%);
        }

        .hero-benefits > div {
            padding-top: 12px;
        }

        .hero-product-frame {
            position: relative;
            isolation: isolate;
            aspect-ratio: 1.08;
        }

        .hero-product-frame::before {
            content: '';
            position: absolute;
            inset: 8% 5% 6%;
            z-index: 0;
            background: radial-gradient(ellipse at center, rgba(205, 229, 244, 0.9), rgba(220, 238, 249, 0.72) 48%, rgba(220, 238, 249, 0) 76%);
            filter: blur(4px);
        }

        .hero-product-image {
            position: absolute;
            inset: 0;
            z-index: 2;
            height: 100%;
            width: 100%;
            object-fit: contain;
            transform: scale(1.08);
        }

        [x-cloak] { display: none !important; }

        body { background: #fafafa; color: #171717; }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d4d4d4; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #a3a3a3; }

        .fade-up {
            animation: heroFadeIn 1.5s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .hero-image-enter {
            animation: heroSlideIn 1.7s cubic-bezier(0.16, 1, 0.3, 1) 0.12s both;
        }

        @keyframes heroFadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes heroSlideIn {
            from { opacity: 0; transform: translateX(56px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .product-image {
            transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .product-card:hover .product-image {
            transform: scale(1.04);
        }

        .navbar-top {
            background: transparent;
            border-color: transparent;
            box-shadow: none;
        }

        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.94);
            border-color: rgba(0, 0, 0, 0.07);
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.04);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        ::selection {
            background: #171717;
            color: #fff;
        }

        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 6px;
            width: 0;
            height: 1.5px;
            background: currentColor;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link.active::after,
        .nav-link:hover::after {
            width: 16px;
        }

        .reveal,
        .reveal-scale,
        .reveal-left,
        .reveal-right {
            opacity: 0;
            transition:
                opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1),
                transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal { transform: translateY(28px); }
        .reveal-scale { transform: scale(0.96) translateY(16px); transition-duration: 0.85s; }
        .reveal-left { transform: translateX(-24px); }
        .reveal-right { transform: translateX(24px); }

        .reveal.revealed,
        .reveal-scale.revealed,
        .reveal-left.revealed,
        .reveal-right.revealed {
            opacity: 1;
            transform: none;
        }

        .reveal-delay-1 { transition-delay: 0.08s; }
        .reveal-delay-2 { transition-delay: 0.16s; }
        .reveal-delay-3 { transition-delay: 0.24s; }
        .reveal-delay-4 { transition-delay: 0.32s; }
        .reveal-delay-5 { transition-delay: 0.40s; }
        .reveal-delay-6 { transition-delay: 0.48s; }

        @media (prefers-reduced-motion: reduce) {
            .fade-up,
            .hero-image-enter {
                animation: none;
                opacity: 1;
                transform: none;
            }

            .reveal,
            .reveal-scale,
            .reveal-left,
            .reveal-right {
                opacity: 1;
                transform: none;
                transition: none;
            }

        }

        .search-panel {
            box-shadow: 0 28px 90px rgba(15, 23, 42, 0.2), 0 1px 3px rgba(15, 23, 42, 0.06);
        }

    </style>
</head>

<body
    class="antialiased"
    x-data="{
        mobileMenu: false,
        searchOpen: false,
        contactOpen: false,
        helpOpen: false,
        searchQuery: '',
        active: 'beranda',
        scrolled: false,
        _scrollRaf: null,

        categories: @js($searchCategories),

        setActive(id) {
            this.active = id;
            this.mobileMenu = false;
            this.searchOpen = false;
            this.helpOpen = false;
        },

        onScroll() {
            if (this._scrollRaf) return;
            this._scrollRaf = requestAnimationFrame(() => {
                this.scrolled = window.scrollY > 30;
                this._scrollRaf = null;
            });
        },

        openSearch() {
            this.searchOpen = true;
            this.mobileMenu = false;
            this.helpOpen = false;
            this.$nextTick(() => {
                const input = document.getElementById('search-input');
                if (input) input.focus();
            });
        },

        closeSearch() {
            this.searchOpen = false;
            this.searchQuery = '';
        },

        openContact() {
            this.searchOpen = false;
            this.mobileMenu = false;
            this.helpOpen = false;
            this.contactOpen = true;
        },

        closeContact() {
            this.contactOpen = false;
        },

        get filteredCategories() {
            const q = this.searchQuery.trim().toLowerCase();
            if (!q) return this.categories;
            return this.categories.filter(category => category.nama.toLowerCase().includes(q));
        },

    }"
    @scroll.window.passive="onScroll()"
    @keydown.escape.window="if (contactOpen) closeContact(); else if (searchOpen) closeSearch(); else helpOpen = false"
    x-init="
        const sections = document.querySelectorAll('section[id]');
        if (sections.length) {
            const sectionObserver = new IntersectionObserver(
                (entries) => {
                    let best = null;
                    for (let i = 0; i < entries.length; i++) {
                        const e = entries[i];
                        if (e.isIntersecting && (!best || e.intersectionRatio > best.intersectionRatio)) {
                            best = e;
                        }
                    }
                    if (best) active = best.target.id;
                },
                { rootMargin: '-40% 0px -50% 0px', threshold: 0 }
            );
            for (let i = 0; i < sections.length; i++) sectionObserver.observe(sections[i]);
        }

        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const revealEls = document.querySelectorAll('.reveal, .reveal-scale, .reveal-left, .reveal-right');

        if (reduceMotion) {
            for (let i = 0; i < revealEls.length; i++) revealEls[i].classList.add('revealed');
        } else if (revealEls.length) {
            let pending = revealEls.length;
            let rafScheduled = false;
            const queue = [];

            const flush = () => {
                rafScheduled = false;
                for (let i = 0; i < queue.length; i++) {
                    const el = queue[i];
                    el.style.willChange = 'opacity, transform';
                    el.classList.add('revealed');
                    el.addEventListener('transitionend', function onEnd(ev) {
                        if (ev.propertyName !== 'opacity' && ev.propertyName !== 'transform') return;
                        el.removeEventListener('transitionend', onEnd);
                        el.style.willChange = '';
                        el.style.transitionDelay = '0s';
                    });
                }
                queue.length = 0;
            };

            const revealObserver = new IntersectionObserver(
                (entries) => {
                    for (let i = 0; i < entries.length; i++) {
                        const entry = entries[i];
                        if (!entry.isIntersecting) continue;
                        revealObserver.unobserve(entry.target);
                        queue.push(entry.target);
                        pending--;
                    }
                    if (queue.length && !rafScheduled) {
                        rafScheduled = true;
                        requestAnimationFrame(flush);
                    }
                    if (pending <= 0) revealObserver.disconnect();
                },
                { threshold: 0, rootMargin: '0px 0px -6% 0px' }
            );

            for (let i = 0; i < revealEls.length; i++) {
                revealObserver.observe(revealEls[i]);
            }
        }
    "
>

    <!-- NAVBAR -->
    <nav
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        :class="scrolled ? 'navbar-scrolled border-b' : 'navbar-top'"
    >
        <div class="max-w-6xl mx-auto px-5 sm:px-6">
            <div class="h-16 flex items-center justify-between">

                <a href="#beranda" @click="setActive('beranda')" class="flex shrink-0 items-center group" aria-label="Konvexa Apparel — beranda">
                    <span
                        class="text-lg font-semibold tracking-tight text-black transition-colors duration-300 sm:text-xl"
                    >Konvexa</span>
                    <span
                        class="ml-2 border-l border-black pl-2 text-[9px] font-semibold uppercase tracking-[0.16em] text-black transition-colors duration-300 sm:text-[10px]"
                    >Apparel</span>
                </a>

                <div class="hidden md:flex items-center gap-0.5">
                    <a href="#beranda" @click="setActive('beranda')"
                       class="nav-link px-3.5 py-2 text-[13px] font-medium transition-colors duration-300"
                       :class="active === 'beranda' ? 'active text-black' : 'text-black hover:text-black'">Beranda</a>
                    <a href="#tentang" @click="setActive('tentang')"
                       class="nav-link px-3.5 py-2 text-[13px] font-medium transition-colors duration-300"
                       :class="active === 'tentang' ? 'active text-black' : 'text-black hover:text-black'">Tentang Kami</a>
                    <a href="#kategori" @click="setActive('kategori')"
                       class="nav-link px-3.5 py-2 text-[13px] font-medium transition-colors duration-300"
                       :class="active === 'kategori' ? 'active text-black' : 'text-black hover:text-black'">Katalog</a>
                    <a href="#lokasi" @click="setActive('lokasi')"
                       class="nav-link px-3.5 py-2 text-[13px] font-medium transition-colors duration-300"
                       :class="active === 'lokasi' ? 'active text-black' : 'text-black hover:text-black'">Lokasi</a>
                    <a href="#kontak" @click="setActive('kontak')"
                       class="nav-link px-3.5 py-2 text-[13px] font-medium transition-colors duration-300"
                       :class="active === 'kontak' ? 'active text-black' : 'text-black hover:text-black'">Kontak</a>
                    <div class="relative" @click.outside="helpOpen = false">
                        <button
                            type="button"
                            @click="helpOpen = !helpOpen"
                            :aria-expanded="helpOpen"
                            aria-haspopup="true"
                            class="nav-link inline-flex items-center gap-1 px-3.5 py-2 text-[13px] font-medium text-black transition-colors duration-300 hover:text-black"
                        >
                            Bantuan
                            <svg class="h-3.5 w-3.5 transition-transform" :class="helpOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>
                        <div
                            x-show="helpOpen"
                            x-cloak
                            x-transition.opacity.duration.150ms
                            class="absolute right-0 top-full z-50 mt-2 w-48 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl"
                        >
                            <a href="#cara-order" @click="setActive('faq')" class="block rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-slate-950">Cara Order</a>
                            <a href="#faq" @click="setActive('faq')" class="block rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-slate-950">FAQ</a>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-1">
                    <button
                        type="button"
                        @click="openContact()"
                        class="hidden md:inline-flex items-center rounded-full bg-black px-4 py-2 text-xs font-semibold text-white transition-colors duration-300 hover:bg-neutral-900"
                    >Minta Penawaran</button>
                    <button
                        @click="openSearch()"
                        class="ml-1 inline-flex h-10 items-center gap-2 rounded-full border border-black px-3 text-black transition-colors duration-300 hover:bg-black hover:text-white"
                        aria-label="Cari Kategori"
                    >
                        <svg class="h-[17px] w-[17px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                        </svg>
                        <span class="hidden text-xs font-medium sm:inline">Cari Kategori</span>
                    </button>

                    <button
                        @click="mobileMenu = !mobileMenu"
                        class="md:hidden flex h-9 w-9 items-center justify-center rounded-full text-black transition-colors duration-300 hover:bg-black hover:text-white"
                        aria-label="Menu"
                    >
                        <svg x-show="!mobileMenu" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileMenu" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M6 6l12 12M18 6 6 18"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div
            x-show="mobileMenu"
            x-cloak
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden border-t border-slate-100 bg-white/95 px-5 py-3 backdrop-blur-xl transition-colors duration-300"
        >
            <div class="space-y-0.5">
                <a href="#beranda" @click="setActive('beranda')" class="block rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100">Beranda</a>
                <a href="#tentang" @click="setActive('tentang')" class="block rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100">Tentang Kami</a>
                <a href="#kategori" @click="setActive('kategori')" class="block rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100">Katalog</a>
                <a href="#lokasi" @click="setActive('lokasi')" class="block rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100">Lokasi</a>
                <a href="#kontak" @click="setActive('kontak')" class="block rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100">Kontak</a>
                <div>
                    <button
                        type="button"
                        @click="helpOpen = !helpOpen"
                        :aria-expanded="helpOpen"
                        class="flex w-full items-center justify-between rounded-lg px-4 py-2.5 text-left text-sm font-medium text-slate-700 transition hover:bg-slate-100"
                    >
                        Bantuan
                        <svg class="h-4 w-4 transition-transform" :class="helpOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                    <div x-show="helpOpen" x-cloak x-transition class="ml-4 mt-1 space-y-0.5 border-l border-slate-200 pl-2">
                        <a href="#cara-order" @click="setActive('faq')" class="block rounded-lg px-3 py-2 text-sm text-slate-500 transition hover:bg-slate-100 hover:text-slate-900">Cara Order</a>
                        <a href="#faq" @click="setActive('faq')" class="block rounded-lg px-3 py-2 text-sm text-slate-500 transition hover:bg-slate-100 hover:text-slate-900">FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- SEARCH OVERLAY -->
    <div
        x-show="searchOpen"
        x-cloak
        class="fixed inset-0 z-[90] flex items-start justify-center overflow-y-auto px-4 py-16 sm:py-24"
    >
        <div
            x-show="searchOpen"
            x-transition.opacity.duration.200ms
            @click="closeSearch()"
            class="absolute inset-0 bg-slate-950/35 backdrop-blur-sm"
        ></div>

        <div
            x-show="searchOpen"
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 -translate-y-2 scale-[0.99]"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="relative z-10 w-full max-w-xl"
        >
            <div
                class="search-panel overflow-hidden rounded-[26px] border border-white bg-white"
                role="dialog"
                aria-modal="true"
                aria-labelledby="search-dialog-title"
            >
                <div class="bg-gradient-to-br from-slate-50 via-white to-blue-50/70 px-6 pb-5 pt-6 sm:px-7">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">Jelajahi katalog</p>
                            <h2 id="search-dialog-title" class="mt-2 text-xl font-semibold tracking-tight text-slate-900 sm:text-2xl">Cari kategori</h2>
                            <p class="mt-1 text-sm text-slate-500">Temukan produk yang sesuai kebutuhanmu.</p>
                        </div>
                        <button
                            type="button"
                            @click="closeSearch()"
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white/80 text-slate-500 transition hover:border-slate-300 hover:bg-white hover:text-slate-900"
                            aria-label="Tutup pencarian"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 6 12 12M18 6 6 18"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-6 pb-5 sm:px-7">
                    <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50/80 px-4 py-3.5 transition focus-within:border-slate-400 focus-within:bg-white focus-within:ring-4 focus-within:ring-slate-100">
                        <svg class="h-5 w-5 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                        </svg>
                        <input
                            id="search-input"
                            type="search"
                            x-model="searchQuery"
                            placeholder="Contoh: kaos, polo, kemeja..."
                            class="min-w-0 flex-1 bg-transparent text-sm text-slate-900 placeholder-slate-400 outline-none"
                            autocomplete="off"
                            aria-label="Cari kategori produk"
                        >
                        <span class="hidden rounded-md border border-slate-200 bg-white px-2 py-1 text-[10px] font-medium text-slate-400 sm:inline">ESC</span>
                    </div>
                </div>

                <div class="max-h-[min(360px,45vh)] overflow-y-auto border-t border-slate-100">
                    <template x-if="searchQuery.trim() === ''">
                        <div class="px-6 py-5 sm:px-7">
                            <p class="mb-3 text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400">Kategori populer</p>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="tag in @js($categories->pluck('name'))">
                                    <button
                                        type="button"
                                        @click="searchQuery = tag"
                                        class="rounded-full border border-slate-200 bg-white px-3.5 py-2 text-xs font-medium text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-slate-900"
                                        x-text="tag"
                                    ></button>
                                </template>
                            </div>
                        </div>
                    </template>

                    <template x-if="searchQuery.trim() !== '' && filteredCategories.length === 0">
                        <div class="px-6 py-9 text-center sm:px-7">
                            <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="11" cy="11" r="7" stroke-width="1.6"/>
                                    <path stroke-linecap="round" stroke-width="1.6" d="m16 16 4 4"/>
                                </svg>
                            </div>
                            <p class="mt-3 text-sm font-semibold text-slate-800">Kategori belum ditemukan</p>
                            <p class="mt-1 text-xs text-slate-500">Coba kata kunci lain, misalnya “polo” atau “kaos”.</p>
                        </div>
                    </template>

                    <template x-if="searchQuery.trim() !== '' && filteredCategories.length > 0">
                        <div class="py-2">
                            <p class="px-6 py-3 text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400 sm:px-7" x-text="filteredCategories.length + ' kategori ditemukan'"></p>
                            <template x-for="category in filteredCategories" :key="category.id">
                                <a
                                    :href="'#kategori-' + category.slug"
                                    @click="closeSearch()"
                                    class="group flex items-center gap-4 px-6 py-3 transition hover:bg-slate-50 sm:px-7"
                                >
                                    <img
                                        :src="category.gambar"
                                        :alt="category.nama"
                                        class="h-12 w-12 shrink-0 rounded-xl border border-slate-100 bg-slate-50 object-cover"
                                    >
                                    <div class="flex-1 min-w-0">
                                        <p class="truncate text-sm font-semibold text-slate-800" x-text="category.nama"></p>
                                        <p class="mt-1 text-xs text-slate-400">Lihat detail kategori</p>
                                    </div>
                                    <svg class="h-4 w-4 shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M5 12h14m-6-6 6 6-6 6"/>
                                    </svg>
                                </a>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div
        x-cloak
        x-show="contactOpen"
        x-transition.opacity
        @click.self="closeContact()"
        class="fixed inset-0 z-[70] flex items-center justify-center bg-black/50 px-5 py-8"
        role="dialog"
        aria-modal="true"
        aria-labelledby="contact-modal-title"
    >
        <div
            x-show="contactOpen"
            x-transition
            class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl sm:p-8"
        >
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-neutral-400">Konsultasi</p>
                    <h2 id="contact-modal-title" class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900">Hubungi Kami</h2>
                    <p class="mt-2 text-sm leading-6 text-neutral-500">Pilih cara yang paling nyaman untuk menghubungi admin.</p>
                </div>
                <button
                    type="button"
                    @click="closeContact()"
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-xl text-neutral-400 transition hover:bg-neutral-100 hover:text-neutral-900"
                    aria-label="Tutup pop-up"
                >&times;</button>
            </div>

            <div class="mt-6 grid gap-3">
                <a
                    href="https://wa.me/{{ $whatsappNumber }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center justify-between rounded-2xl border border-neutral-200 p-4 transition hover:border-neutral-400 hover:bg-neutral-50"
                >
                    <span>
                        <span class="block text-sm font-semibold text-neutral-900">WhatsApp</span>
                        <span class="mt-1 block text-xs text-neutral-500">{{ $siteSettings['whatsapp_phone'] }}</span>
                    </span>
                    <span class="text-sm font-medium text-neutral-500">Hubungi <span aria-hidden="true">&rarr;</span></span>
                </a>
                @if ($siteSettings['instagram_url'])
                <a
                    href="{{ $siteSettings['instagram_url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center justify-between rounded-2xl border border-neutral-200 p-4 transition hover:border-neutral-400 hover:bg-neutral-50"
                >
                    <span>
                        <span class="block text-sm font-semibold text-neutral-900">Instagram</span>
                        <span class="mt-1 block text-xs text-neutral-500">{{ $siteSettings['instagram_handle'] ?: $siteSettings['instagram_url'] }}</span>
                    </span>
                    <span class="text-sm font-medium text-neutral-500">Kunjungi <span aria-hidden="true">&rarr;</span></span>
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- HERO -->
    <section id="beranda" class="hero-section relative overflow-hidden">
        <svg class="hero-background-art" viewBox="0 0 1920 1080" preserveAspectRatio="xMidYMid slice" aria-hidden="true" focusable="false">
            <defs>
                <linearGradient id="wave-royal" x1="0" y1="0" x2="1" y2=".6">
                    <stop offset="0" stop-color="#617ad0" stop-opacity=".01"/>
                    <stop offset=".55" stop-color="#5977cf" stop-opacity=".15"/>
                    <stop offset="1" stop-color="#354c9a" stop-opacity=".08"/>
                </linearGradient>
                <linearGradient id="wave-cyan" x1="0" y1="0" x2="1" y2=".3">
                    <stop offset="0" stop-color="#78d8ef" stop-opacity=".01"/>
                    <stop offset=".55" stop-color="#62c6df" stop-opacity=".18"/>
                    <stop offset="1" stop-color="#6097d2" stop-opacity=".07"/>
                </linearGradient>
                <linearGradient id="wave-violet" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0" stop-color="#9d8bea" stop-opacity="0"/>
                    <stop offset=".55" stop-color="#9384d0" stop-opacity=".11"/>
                    <stop offset="1" stop-color="#7771ba" stop-opacity=".05"/>
                </linearGradient>
                <radialGradient id="wave-glow" cx="50%" cy="50%" r="50%">
                    <stop offset="0" stop-color="#66cbeb" stop-opacity=".2"/>
                    <stop offset="1" stop-color="#66cbeb" stop-opacity="0"/>
                </radialGradient>
                <linearGradient id="wave-fade" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0" stop-color="white" stop-opacity="0"/>
                    <stop offset=".38" stop-color="white" stop-opacity="0"/>
                    <stop offset=".58" stop-color="white" stop-opacity=".16"/>
                    <stop offset=".82" stop-color="white" stop-opacity=".48"/>
                    <stop offset="1" stop-color="white" stop-opacity=".2"/>
                </linearGradient>
                <mask id="wave-fade-mask" maskUnits="userSpaceOnUse" x="0" y="0" width="1920" height="1080">
                    <rect width="1920" height="1080" fill="url(#wave-fade)"/>
                </mask>
                <filter id="wave-soft-light" x="-30%" y="-30%" width="160%" height="160%">
                    <feGaussianBlur stdDeviation="56"/>
                </filter>
                <filter id="wave-soft-edges" x="-5%" y="-20%" width="110%" height="140%">
                    <feGaussianBlur stdDeviation="16"/>
                </filter>
            </defs>
            <path d="M0 177C111 77 219 0 365 0h430C497 80 210 169 0 322Z" fill="#dce3ed" opacity=".2"/>
            <path d="M1508 106h232l-335 562h-232Z" fill="#a9c8e8" opacity=".23"/>
            <path d="m1920 205-280 288 116 122 164-164Z" fill="#dfe5ef" opacity=".15"/>
            <ellipse cx="1435" cy="610" rx="470" ry="260" fill="url(#wave-glow)" filter="url(#wave-soft-light)"/>
            <g mask="url(#wave-fade-mask)" filter="url(#wave-soft-edges)" opacity=".78">
                <path d="M0 660c215 2 374 83 603 171 237 91 405 97 651 20 244-76 454-197 666-200v429H0Z" fill="url(#wave-royal)"/>
                <path d="M0 946c226-116 425-127 664-67 227 57 404 94 632 28 240-70 411-169 624-196v369H0Z" fill="url(#wave-cyan)"/>
                <path d="M0 1056c260-119 443-142 703-93 267 51 438 70 686-20 211-77 378-150 531-165v302H0Z" fill="url(#wave-violet)"/>
            </g>
        </svg>
        <div class="relative z-10 mx-auto grid w-full max-w-6xl items-center gap-10 px-5 pb-8 pt-24 sm:px-8 sm:pb-10 sm:pt-28 lg:grid-cols-[1.05fr_0.95fr] lg:gap-16 lg:px-10 lg:pb-10 lg:pt-28">
            <div class="fade-up max-w-xl">
                <p class="mb-5 inline-flex items-center gap-2.5 rounded-full border border-slate-200/80 bg-white/85 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-600 shadow-sm sm:text-[11px]">
                    <svg class="h-4 w-4 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="m8 4 4 2 4-2 5 3-3 4-2-1v10H8V10l-2 1-3-4 5-3Z"/>
                    </svg>
                    {{ $siteSettings['hero_badge'] }}
                </p>

                <h1 class="hero-title max-w-[620px]">
                    {{ $siteSettings['hero_title'] }}
                    <span>{{ $siteSettings['hero_highlight'] }}</span>
                </h1>

                <p class="mt-4 max-w-[500px] text-[15px] leading-7 text-slate-600">
                    {{ $siteSettings['hero_description'] }}
                </p>

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <a
                        href="#kategori"
                        @click="setActive('kategori')"
                        class="group inline-flex items-center gap-4 rounded-full bg-black py-2 pl-6 pr-2 text-sm font-semibold text-white transition duration-300 hover:bg-neutral-900"
                    >
                        Lihat Koleksi
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 transition duration-300 group-hover:translate-x-0.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6 6 6-6 6"/>
                            </svg>
                        </span>
                    </a>
                    <button
                        type="button"
                        @click="openContact()"
                        class="inline-flex items-center gap-2 rounded-full border border-black px-5 py-3.5 text-sm font-medium text-black transition hover:bg-black hover:text-white"
                    >
                        Konsultasi Pesanan
                    </button>
                </div>

            </div>

            <div class="hero-image-enter mx-auto w-full max-w-[500px] lg:ml-auto" aria-label="Koleksi apparel Konvexa">
                <div class="hero-product-frame">
                    <img
                        src="{{ asset('image/hero-apparel-feature.png') }}"
                        alt="Polo hitam dan jersey putih custom Konvexa"
                        class="hero-product-image"
                        fetchpriority="high"
                    >
                </div>
            </div>
        </div>

        <div class="hero-benefits relative z-10" role="region" aria-label="Keunggulan Konvexa Apparel">
            <div class="mx-auto grid max-w-6xl grid-cols-2 px-5 sm:px-8 lg:grid-cols-4 lg:px-10">
                <div class="flex items-center gap-3 border-b border-slate-200 py-2 pr-3 lg:border-b-0 lg:border-r lg:pr-5">
                    <svg class="h-8 w-8 shrink-0 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m8 4 4 2 4-2 5 3-3 4-2-1v10H8V10l-2 1-3-4 5-3Z"/>
                    </svg>
                    <div>
                        <p class="text-xs font-semibold text-slate-900 sm:text-sm">Hasil Sesuai Desain</p>
                        <p class="mt-1 text-[10px] text-slate-500 sm:text-xs">Desain sesuai kebutuhan</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 border-b border-slate-200 py-2 pl-3 lg:border-b-0 lg:border-r lg:px-5">
                    <svg class="h-8 w-8 shrink-0 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m12 3 7 3v5c0 4.5-2.8 7.7-7 10-4.2-2.3-7-5.5-7-10V6l7-3Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m9 12 2 2 4-4"/>
                    </svg>
                    <div>
                        <p class="text-xs font-semibold text-slate-900 sm:text-sm">Kualitas Konsisten</p>
                        <p class="mt-1 text-[10px] text-slate-500 sm:text-xs">Hasil rapi dan nyaman dipakai</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 py-2 pr-3 lg:border-r lg:border-slate-200 lg:px-5">
                    <svg class="h-8 w-8 shrink-0 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7h11v10H3zM14 10h4l3 3v4h-7zM7 20a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm11 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                    </svg>
                    <div>
                        <p class="text-xs font-semibold text-slate-900 sm:text-sm">Produksi Terkendali</p>
                        <p class="mt-1 text-[10px] text-slate-500 sm:text-xs">Order kecil hingga skala besar</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 py-2 pl-3 lg:pl-5">
                    <svg class="h-8 w-8 shrink-0 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12a9 9 0 0 1 18 0v5h-4v-6h4M3 12v5h4v-6H3m14 5a5 5 0 0 1-5 5h-1"/>
                    </svg>
                    <div>
                        <p class="text-xs font-semibold text-slate-900 sm:text-sm">Konsultasi Pesanan</p>
                        <p class="mt-1 text-[10px] text-slate-500 sm:text-xs">Dari pemilihan bahan hingga produksi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TENTANG KAMI -->
    <section id="tentang" class="py-20 sm:py-24 px-5 sm:px-6 bg-white">
        <div class="max-w-3xl mx-auto text-center">
            <div class="reveal">
                <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-neutral-400 mb-3">About Us</p>
                <h2 class="text-3xl sm:text-4xl font-semibold tracking-tight text-neutral-900">
                    Tentang Kami
                </h2>
            </div>
            <div class="reveal reveal-delay-1 mt-8 space-y-5">
                <p class="text-[15px] text-neutral-500 font-light leading-relaxed">
                    {{ $siteSettings['about_intro'] }}
                </p>
                <p class="text-[15px] text-neutral-500 font-light leading-relaxed">
                    {{ $siteSettings['about_commitment'] }}
                </p>
            </div>
        </div>
    </section>

    <!-- KATALOG -->
    <section id="kategori" class="relative bg-white py-20 sm:py-24 px-5 sm:px-6">
        <div class="relative mx-auto max-w-6xl">
            <div class="mb-10 flex flex-col gap-5 sm:mb-12 sm:flex-row sm:items-end sm:justify-between">
                <div class="reveal">
                    <p class="mb-3 inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                        <span class="h-px w-7 bg-slate-900"></span>
                        Koleksi Konvexa
                    </p>
                    <h2 class="text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Katalog Pilihan</h2>
                </div>
                <p class="reveal reveal-delay-1 max-w-sm text-sm leading-6 text-slate-600">
                    Pilih kategori seragam dan apparel custom untuk kebutuhan tim, komunitas, maupun brand Anda.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4 sm:gap-5 md:grid-cols-3 lg:grid-cols-4">
                @forelse ($categories as $category)
                    <article id="kategori-{{ $category->slug }}"
                       class="reveal reveal-delay-{{ min($loop->iteration, 6) }} scroll-mt-24 group overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-lg">
                        <div class="relative aspect-[4/3] overflow-hidden bg-white">
                            <img src="{{ $category->image_url }}"
                                 alt="{{ $category->name }}"
                                 class="h-full w-full object-contain p-4 transition-transform duration-500 group-hover:scale-[1.04] sm:p-5">
                        </div>
                        <div class="flex flex-col items-stretch gap-3 p-4 sm:p-5">
                            <div class="min-w-0">
                                <span class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400">
                                    Kategori {{ sprintf('%02d', $loop->iteration) }}
                                </span>
                                <h3 class="mt-1 break-words text-sm font-semibold tracking-tight text-slate-900 sm:text-base">
                                    {{ $category->name }}
                                </h3>
                            </div>
                            <button type="button" @click="openContact()"
                               class="w-full rounded-full bg-slate-900 px-3 py-2.5 text-center text-[10px] font-medium text-white transition hover:bg-slate-700 sm:text-xs">
                                Hubungi Admin
                            </button>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white/70 px-6 py-14 text-center text-sm text-slate-500">
                        Kategori akan segera hadir.
                    </p>
                @endforelse
            </div>
        </div>
    </section>

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

    <!-- LOKASI -->
    @php
        $locationAddress = $siteSettings['location_address'];
        $locationName = $siteSettings['location_name'];
        $googleMapsQuery = urlencode($locationName . ', ' . $locationAddress);
        $appleMapsQuery = urlencode($locationName . ', ' . $locationAddress);
    @endphp
    <section id="lokasi" class="relative overflow-hidden bg-[#f7f9f9] py-16 sm:py-20 px-5 sm:px-6">
        <div class="pointer-events-none absolute -right-36 top-0 h-96 w-96 rounded-full bg-[#eaf3f3] blur-3xl" aria-hidden="true"></div>
        <div class="relative mx-auto max-w-6xl">
            <div class="reveal mb-8 max-w-2xl sm:mb-10">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">Lokasi Konvexa</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Temukan Kami</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">Lihat lokasi dan petunjuk arah ke {{ $locationName }}.</p>
            </div>
            <div class="grid items-center gap-8 md:grid-cols-2 md:gap-12">
                <div class="reveal overflow-hidden rounded-3xl border border-neutral-100 bg-neutral-100 shadow-[0_16px_44px_rgba(0,0,0,0.06)]">
                    <iframe
                        src="https://maps.google.com/maps?q={{ $googleMapsQuery }}&amp;output=embed"
                        title="Peta lokasi produksi {{ $locationName }}"
                        class="aspect-[4/3] w-full"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                    ></iframe>
                </div>

                <div class="reveal reveal-delay-1 md:pl-4">
                    <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-neutral-400">Alamat lokasi</p>
                    <h3 class="mt-3 text-3xl font-medium tracking-tight text-neutral-950 sm:text-4xl">{{ $locationName }}</h3>
                    <p class="mt-5 max-w-lg text-sm leading-7 text-neutral-500 sm:text-base">
                        {{ $locationAddress }}
                    </p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a
                            href="https://www.google.com/maps/search/?api=1&amp;query={{ $googleMapsQuery }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-3 rounded-full bg-neutral-950 px-5 py-3 text-sm font-medium text-white transition hover:bg-neutral-800"
                        >
                            Google Maps
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 17 17 7M7 7h10v10"/>
                            </svg>
                        </a>
                        <a
                            href="https://maps.apple.com/?q={{ $appleMapsQuery }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-3 rounded-full border border-neutral-200 bg-white/80 px-5 py-3 text-sm font-medium text-neutral-800 transition hover:border-neutral-400 hover:bg-white"
                        >
                            Apple Maps
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 17 17 7M7 7h10v10"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT / SOSMED -->
    <section id="kontak" class="py-20 sm:py-24 px-5 sm:px-6 bg-neutral-50">
        <div class="max-w-3xl mx-auto text-center">
            <div class="reveal">
                <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-neutral-400 mb-3">Connect With Us</p>
                <h2 class="text-3xl sm:text-4xl font-semibold tracking-tight text-neutral-900">Hubungi Kami</h2>
                <p class="mt-5 text-[15px] text-neutral-500 font-light leading-relaxed max-w-md mx-auto">
                    Hubungi kami untuk konsultasi order, katalog, dan update produksi terbaru.
                </p>
            </div>

            <div class="reveal reveal-delay-1 mt-12 grid sm:grid-cols-2 gap-3">
                @if ($siteSettings['instagram_url'])
                <a
                    href="{{ $siteSettings['instagram_url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group flex items-center gap-4 p-5 rounded-2xl bg-white border border-neutral-100 hover:border-neutral-200 hover:shadow-[0_12px_32px_rgba(0,0,0,0.06)] transition-all duration-300 text-left"
                >
                    <div class="w-11 h-11 rounded-xl bg-neutral-50 flex items-center justify-center shrink-0 group-hover:bg-neutral-900 transition-colors duration-300">
                        <svg class="w-5 h-5 text-neutral-700 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-neutral-900">Instagram</p>
                        <p class="text-xs text-neutral-400 mt-0.5">{{ $siteSettings['instagram_handle'] ?: $siteSettings['instagram_url'] }}</p>
                    </div>
                    <span class="text-neutral-300 group-hover:text-neutral-900 transition">→</span>
                </a>
                @endif

                @if ($siteSettings['tiktok_url'])
                <a
                    href="{{ $siteSettings['tiktok_url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group flex items-center gap-4 p-5 rounded-2xl bg-white border border-neutral-100 hover:border-neutral-200 hover:shadow-[0_12px_32px_rgba(0,0,0,0.06)] transition-all duration-300 text-left"
                >
                    <div class="w-11 h-11 rounded-xl bg-neutral-50 flex items-center justify-center shrink-0 group-hover:bg-neutral-900 transition-colors duration-300">
                        <svg class="w-5 h-5 text-neutral-700 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1v-3.5a6.37 6.37 0 00-.79-.05A6.34 6.34 0 003.15 15.8a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-.19-.05z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-neutral-900">TikTok</p>
                        <p class="text-xs text-neutral-400 mt-0.5">{{ $siteSettings['tiktok_handle'] ?: $siteSettings['tiktok_url'] }}</p>
                    </div>
                    <span class="text-neutral-300 group-hover:text-neutral-900 transition">→</span>
                </a>
                @endif

                <a
                    href="https://wa.me/{{ $whatsappNumber }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group flex items-center gap-4 p-5 rounded-2xl bg-white border border-neutral-100 hover:border-neutral-200 hover:shadow-[0_12px_32px_rgba(0,0,0,0.06)] transition-all duration-300 text-left"
                >
                    <div class="w-11 h-11 rounded-xl bg-neutral-50 flex items-center justify-center shrink-0 group-hover:bg-neutral-900 transition-colors duration-300">
                        <svg class="w-5 h-5 text-neutral-700 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.485 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-neutral-900">WhatsApp</p>
                        <p class="text-xs text-neutral-400 mt-0.5">{{ $siteSettings['whatsapp_phone'] }}</p>
                    </div>
                    <span class="text-neutral-300 group-hover:text-neutral-900 transition">→</span>
                </a>

                <a
                    href="mailto:{{ $siteSettings['contact_email'] }}"
                    class="group flex items-center gap-4 p-5 rounded-2xl bg-white border border-neutral-100 hover:border-neutral-200 hover:shadow-[0_12px_32px_rgba(0,0,0,0.06)] transition-all duration-300 text-left"
                >
                    <div class="w-11 h-11 rounded-xl bg-neutral-50 flex items-center justify-center shrink-0 group-hover:bg-neutral-900 transition-colors duration-300">
                        <svg class="w-5 h-5 text-neutral-700 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-neutral-900">Email</p>
                        <p class="text-xs text-neutral-400 mt-0.5">{{ $siteSettings['contact_email'] }}</p>
                    </div>
                    <span class="text-neutral-300 group-hover:text-neutral-900 transition">→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-neutral-950 text-white">
        <div class="max-w-6xl mx-auto px-5 sm:px-6 py-14">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-1">
                        <span class="text-xl font-semibold tracking-tight">Konvexa</span>
                        <span class="text-xl font-light text-neutral-500 tracking-tight">Apparel</span>
                    </div>
                    <p class="mt-4 max-w-xs text-sm text-neutral-500 font-light leading-relaxed">
                        Konveksi modern yang menghadirkan produk apparel berkualitas dengan harga terjangkau.
                    </p>
                </div>

                <div>
                    <h4 class="text-[11px] uppercase tracking-wider font-medium text-neutral-500">Navigasi</h4>
                    <div class="mt-4 space-y-2.5">
                        <a href="#beranda" class="block text-sm text-neutral-500 hover:text-white transition">Beranda</a>
                        <a href="#tentang" class="block text-sm text-neutral-500 hover:text-white transition">Tentang Kami</a>
                        <a href="#kategori" class="block text-sm text-neutral-500 hover:text-white transition">Katalog</a>
                        <a href="#lokasi" class="block text-sm text-neutral-500 hover:text-white transition">Lokasi</a>
                    </div>
                </div>

                <div>
                    <h4 class="text-[11px] uppercase tracking-wider font-medium text-neutral-500">Bantuan</h4>
                    <div class="mt-4 space-y-2.5">
                        <a href="#kontak" class="block text-sm text-neutral-500 hover:text-white transition">Hubungi Kami</a>
                        <a href="#faq" class="block text-sm text-neutral-500 hover:text-white transition">FAQ</a>
                        <a href="#" class="block text-sm text-neutral-500 hover:text-white transition">Kebijakan Privasi</a>
                        <a href="#" class="block text-sm text-neutral-500 hover:text-white transition">Syarat &amp; Ketentuan</a>
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-white/5 flex flex-col sm:flex-row justify-between gap-2">
                <p class="text-xs text-neutral-600">© 2026 Konvexa Apparel. All rights reserved.</p>
                <p class="text-xs text-neutral-600">Crafted for modern konveksi.</p>
            </div>
        </div>
    </footer>

</body>
</html>
