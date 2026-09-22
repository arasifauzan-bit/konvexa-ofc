<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konvexa Official | Konveksi Murah Berkualitas</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }

        [x-cloak] { display: none !important; }

        body { background: #fafafa; color: #171717; }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d4d4d4; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #a3a3a3; }

        .fade-up {
            animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .product-image {
            transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .product-card:hover .product-image {
            transform: scale(1.04);
        }

        .hero-overlay {
            background: linear-gradient(
                105deg,
                rgba(10, 10, 10, 0.82) 0%,
                rgba(10, 10, 10, 0.55) 50%,
                rgba(10, 10, 10, 0.25) 100%
            );
        }

        .navbar-top {
            background: transparent;
            border-color: transparent;
        }

        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.92);
            border-color: rgba(0, 0, 0, 0.06);
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.04);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .hero-image {
            transform: scale(1.02);
            transition: transform 10s ease;
        }

        #beranda:hover .hero-image {
            transform: scale(1.06);
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
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(0, 0, 0, 0.04);
        }

        /* AI Chat - simple */
        .chat-window {
            box-shadow: 0 16px 48px rgba(0,0,0,.12), 0 4px 12px rgba(0,0,0,.04);
        }
        .chat-scroll {
            scrollbar-width: thin;
            scrollbar-color: #d4d4d4 transparent;
        }
    </style>
</head>

<body
    class="antialiased"
    x-data="{
        mobileMenu: false,
        searchOpen: false,
        searchQuery: '',
        active: 'beranda',
        scrolled: false,
        _scrollRaf: null,

        // AI Chat
        chatOpen: false,
        chatMessage: '',
        chatLoading: false,
        chatHint: true,
        chatMessages: [
            { role: 'bot', text: 'Halo! Saya Konvexa AI. Tanya saja soal produk, harga, kategori, atau cara order.' },
        ],

        products: @js($searchProducts),

        setActive(id) {
            this.active = id;
            this.mobileMenu = false;
            this.searchOpen = false;
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
            this.$nextTick(() => {
                const input = document.getElementById('search-input');
                if (input) input.focus();
            });
        },

        closeSearch() {
            this.searchOpen = false;
            this.searchQuery = '';
        },

        formatPrice(n) {
            return 'Rp' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        },

        get filteredProducts() {
            const q = this.searchQuery.trim().toLowerCase();
            if (!q) return this.products;
            return this.products.filter(p =>
                p.nama.toLowerCase().includes(q) ||
                p.kategori.toLowerCase().includes(q)
            );
        },

        // AI Chat methods
        openChat() {
            this.chatOpen = true;
            this.chatHint = false;
            this.$nextTick(() => {
                const el = document.getElementById('chat-messages');
                if (el) el.scrollTop = el.scrollHeight;
                document.getElementById('chat-input')?.focus();
            });
        },

        askSuggestion(text) {
            this.chatMessage = text;
            this.sendChat();
        },

        async sendChat() {
            const message = this.chatMessage.trim();
            if (!message || this.chatLoading) return;

            this.chatMessages.push({ role: 'user', text: message });
            this.chatMessage = '';
            this.chatLoading = true;

            this.$nextTick(() => {
                const el = document.getElementById('chat-messages');
                if (el) el.scrollTop = el.scrollHeight;
            });

            try {
                const response = await fetch('{{ route('chatbot.message') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                this.chatMessages.push({
                    role: 'bot',
                    text: data.reply || 'Maaf, saya belum bisa menjawab pertanyaan tersebut.'
                });
            } catch (error) {
                this.chatMessages.push({
                    role: 'bot',
                    text: 'Maaf, sedang ada gangguan. Silakan coba lagi beberapa saat.'
                });
            } finally {
                this.chatLoading = false;
                this.$nextTick(() => {
                    const el = document.getElementById('chat-messages');
                    if (el) el.scrollTop = el.scrollHeight;
                });
            }
        }
    }"
    @scroll.window.passive="onScroll()"
    @keydown.escape.window="if (searchOpen) closeSearch(); if (chatOpen) chatOpen = false"
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
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-400"
        :class="scrolled ? 'navbar-scrolled border-b' : 'navbar-top'"
    >
        <div class="max-w-6xl mx-auto px-5 sm:px-6">
            <div class="h-16 flex items-center justify-between">

                <a href="#beranda" @click="setActive('beranda')" class="flex items-center gap-1 group">
                    <span
                        class="text-xl font-semibold tracking-tight transition-colors duration-300 text-white"
                        :class="scrolled ? 'text-neutral-900' : 'text-white'"
                    >Konvexa</span>
                    <span
                        class="text-xl font-light tracking-tight transition-colors duration-300 text-white/50"
                        :class="scrolled ? 'text-neutral-400' : 'text-white/50'"
                    >Official</span>
                </a>

                <div class="hidden md:flex items-center gap-1">
                    <a href="#beranda" @click="setActive('beranda')"
                       class="nav-link px-3.5 py-2 text-[13px] font-medium transition-colors duration-300"
                       :class="scrolled ? (active === 'beranda' ? 'active text-neutral-900' : 'text-neutral-500 hover:text-neutral-900') : (active === 'beranda' ? 'active text-white' : 'text-white/70 hover:text-white')">Beranda</a>
                    <a href="#tentang" @click="setActive('tentang')"
                       class="nav-link px-3.5 py-2 text-[13px] font-medium transition-colors duration-300"
                       :class="scrolled ? (active === 'tentang' ? 'active text-neutral-900' : 'text-neutral-500 hover:text-neutral-900') : (active === 'tentang' ? 'active text-white' : 'text-white/70 hover:text-white')">Tentang Kami</a>
                    <a href="#kategori" @click="setActive('kategori')"
                       class="nav-link px-3.5 py-2 text-[13px] font-medium transition-colors duration-300"
                       :class="scrolled ? (active === 'kategori' ? 'active text-neutral-900' : 'text-neutral-500 hover:text-neutral-900') : (active === 'kategori' ? 'active text-white' : 'text-white/70 hover:text-white')">Katalog</a>
                    <a href="#produk" @click="setActive('produk')"
                       class="nav-link px-3.5 py-2 text-[13px] font-medium transition-colors duration-300"
                       :class="scrolled ? (active === 'produk' ? 'active text-neutral-900' : 'text-neutral-500 hover:text-neutral-900') : (active === 'produk' ? 'active text-white' : 'text-white/70 hover:text-white')">Produk</a>
                    <a href="#kontak" @click="setActive('kontak')"
                       class="nav-link px-3.5 py-2 text-[13px] font-medium transition-colors duration-300"
                       :class="scrolled ? (active === 'kontak' ? 'active text-neutral-900' : 'text-neutral-500 hover:text-neutral-900') : (active === 'kontak' ? 'active text-white' : 'text-white/70 hover:text-white')">Kontak</a>
                </div>

                <div class="flex items-center gap-1">
                    <button
                        @click="openSearch()"
                        class="w-9 h-9 flex items-center justify-center rounded-full transition-colors duration-300"
                        :class="scrolled ? 'text-neutral-600 hover:bg-neutral-100' : 'text-white/80 hover:bg-white/10'"
                        aria-label="Cari produk"
                    >
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>

                    <button
                        @click="mobileMenu = !mobileMenu"
                        class="md:hidden w-9 h-9 flex items-center justify-center rounded-full transition-colors duration-300"
                        :class="scrolled ? 'text-neutral-700 hover:bg-neutral-100' : 'text-white hover:bg-white/10'"
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
            class="md:hidden px-5 py-3 bg-white/95 backdrop-blur-xl border-t border-neutral-100"
        >
            <div class="space-y-0.5">
                <a href="#beranda" @click="setActive('beranda')" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition">Beranda</a>
                <a href="#tentang" @click="setActive('tentang')" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition">Tentang Kami</a>
                <a href="#kategori" @click="setActive('kategori')" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition">Katalog</a>
                <a href="#produk" @click="setActive('produk')" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition">Produk</a>
                <a href="#kontak" @click="setActive('kontak')" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- SEARCH OVERLAY -->
    <div
        x-show="searchOpen"
        x-cloak
        class="fixed inset-0 z-[90]"
    >
        <div
            x-show="searchOpen"
            x-transition.opacity.duration.200ms
            @click="closeSearch()"
            class="absolute inset-0 bg-neutral-950/40 backdrop-blur-sm"
        ></div>

        <div
            x-show="searchOpen"
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 -translate-y-3"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-3"
            class="relative max-w-xl mx-auto mt-16 sm:mt-24 px-4"
        >
            <div class="search-panel bg-white rounded-2xl overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-neutral-100">
                    <svg class="w-5 h-5 text-neutral-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                    <input
                        id="search-input"
                        type="search"
                        x-model="searchQuery"
                        placeholder="Cari produk atau kategori..."
                        class="flex-1 bg-transparent text-[15px] text-neutral-900 placeholder-neutral-400 outline-none"
                        autocomplete="off"
                    >
                    <button
                        @click="closeSearch()"
                        class="text-xs font-medium text-neutral-400 hover:text-neutral-700 transition px-2 py-1 rounded-md hover:bg-neutral-50"
                    >
                        Esc
                    </button>
                </div>

                <div class="max-h-[min(420px,60vh)] overflow-y-auto">
                    <template x-if="searchQuery.trim() === ''">
                        <div class="px-5 py-8 text-center">
                            <p class="text-sm text-neutral-400 font-light">Ketik nama produk atau kategori</p>
                            <div class="mt-5 flex flex-wrap justify-center gap-2">
                                <template x-for="tag in @js($categories->pluck('name'))">
                                    <button
                                        type="button"
                                        @click="searchQuery = tag"
                                        class="px-3 py-1.5 rounded-full bg-neutral-50 border border-neutral-100 text-xs font-medium text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 transition"
                                        x-text="tag"
                                    ></button>
                                </template>
                            </div>
                        </div>
                    </template>

                    <template x-if="searchQuery.trim() !== '' && filteredProducts.length === 0">
                        <div class="px-5 py-10 text-center">
                            <p class="text-sm font-medium text-neutral-800">Tidak ada hasil</p>
                            <p class="mt-1 text-xs text-neutral-400 font-light">Coba kata kunci lain</p>
                        </div>
                    </template>

                    <template x-if="searchQuery.trim() !== '' && filteredProducts.length > 0">
                        <div class="py-2">
                            <p class="px-5 py-2 text-[10px] uppercase tracking-wider text-neutral-400 font-medium" x-text="filteredProducts.length + ' produk ditemukan'"></p>
                            <template x-for="p in filteredProducts" :key="p.id">
                                <a
                                    href="#produk"
                                    @click="closeSearch(); setActive('produk')"
                                    class="flex items-center gap-4 px-5 py-3 hover:bg-neutral-50 transition group"
                                >
                                    <img
                                        :src="p.gambar"
                                        :alt="p.nama"
                                        class="w-12 h-12 rounded-lg object-cover bg-neutral-100 shrink-0"
                                    >
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-neutral-900 truncate group-hover:text-neutral-700" x-text="p.nama"></p>
                                        <p class="text-[11px] text-neutral-400 mt-0.5" x-text="p.kategori"></p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <p class="text-sm font-semibold text-neutral-900" x-text="formatPrice(p.harga)"></p>
                                        <p x-show="p.hargaCoret > 0" class="text-[10px] text-neutral-400 line-through" x-text="formatPrice(p.hargaCoret)"></p>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- HERO -->
    <section id="beranda" class="relative min-h-[100svh] flex items-center overflow-hidden">
        <img
            src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1920&q=80"
            alt="Konvexa Collection"
            class="hero-image absolute inset-0 w-full h-full object-cover"
        >
        <div class="absolute inset-0 hero-overlay"></div>

        <div class="relative z-10 max-w-6xl mx-auto w-full px-5 sm:px-6 pt-16">
            <div class="max-w-2xl fade-up">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-white/15 bg-white/5 backdrop-blur-sm mb-8">
                    <span class="w-1 h-1 bg-white rounded-full"></span>
                    <span class="text-[10px] uppercase tracking-[0.2em] font-medium text-white/80">Konveksi 2026</span>
                </div>

                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-semibold text-white leading-[1.05] tracking-tight">
                    Konveksi Berkualitas.
                    <span class="block font-light text-white/50 mt-1">Harga Bersahabat.</span>
                </h1>

                <p class="mt-7 max-w-md text-[15px] text-white/60 leading-relaxed font-light">
                    Produksi kaos, kemeja, seragam, dan apparel custom dengan kualitas terjamin dan proses yang transparan.
                </p>

                <div class="mt-10 flex flex-wrap gap-3">
                    <a
                        href="produk"
                        @click="setActive('produk')"
                        class="inline-flex items-center gap-2.5 bg-white text-neutral-900 px-6 py-3.5 rounded-full text-sm font-medium hover:bg-neutral-100 transition-all duration-300"
                    >
                        Lihat Produk
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6 6 6-6 6"/>
                        </svg>
                    </a>
                    <a
                        href="#kategori"
                        @click="setActive('kategori')"
                        class="inline-flex items-center px-6 py-3.5 rounded-full border border-white/20 text-white text-sm font-medium hover:bg-white/5 transition-all duration-300"
                    >
                        Eksplorasi
                    </a>
                </div>

                <div class="mt-14 flex flex-wrap gap-x-8 gap-y-2 text-[12px] text-white/40 font-light">
                    <div class="flex items-center gap-2">
                        <span class="text-white/70">✓</span> Bahan Premium
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-white/70">✓</span> Produksi Cepat
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-white/70">✓</span> Harga Kompetitif
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2">
            <a href="#tentang" class="flex flex-col items-center gap-1.5 text-white/30 hover:text-white/60 transition">
                <span class="text-[9px] uppercase tracking-[0.25em]">Scroll</span>
                <svg class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 14l-7 7m0 0-7-7m7 7V3"/>
                </svg>
            </a>
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
                    Didirikan pada 2025, Konvexa hadir sebagai konveksi yang fokus pada produksi kemeja, kaos, polo, dan rompi. Kami melayani berbagai kebutuhan custom, dari order kecil hingga skala besar, dengan standar kualitas yang konsisten.
                </p>
                <p class="text-[15px] text-neutral-500 font-light leading-relaxed">
                    Konvexa berdiri di bawah satu naungan produksi dengan Ar Rasi Konveksi, sehingga kami dapat memberikan proses yang lebih terukur, hasil yang rapi, dan harga yang tetap kompetitif.
                </p>
                <p class="text-[15px] text-neutral-500 font-light leading-relaxed">
                    Kami berkomitmen menghadirkan produk apparel yang nyaman dipakai, tahan lama, dan sesuai dengan karakter setiap brand.
                </p>
            </div>
        </div>
    </section>

    <!-- KATALOG -->
    <section id="kategori" class="py-20 sm:py-24 px-5 sm:px-6 bg-neutral-50">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12">
                <div class="reveal">
                    <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-neutral-400 mb-2">Curated Collections</p>
                    <h2 class="text-3xl sm:text-4xl font-semibold tracking-tight text-neutral-900">Katalog Pilihan</h2>
                </div>
                <p class="reveal reveal-delay-1 max-w-xs text-sm text-neutral-500 font-light leading-relaxed">
                    Eksplorasi seluruh koleksi produk yang dirancang khusus sesuai gaya hidup Anda.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @forelse ($categories as $category)
                    <a href="{{ route('produk.index', ['category' => $category->slug]) }}"
                       class="reveal reveal-delay-{{ min($loop->iteration, 6) }} group relative overflow-hidden rounded-2xl aspect-[3/4] bg-white border border-neutral-100 hover:shadow-xl transition-all duration-500">

                        <img src="{{ $category->image_url }}"
                             alt="{{ $category->name }}"
                             class="absolute inset-0 w-full h-full object-contain p-4 group-hover:scale-105 transition-all duration-700">

                        <div class="absolute inset-0 bg-gradient-to-t from-neutral-900/80 via-transparent to-transparent opacity-90"></div>

                        <div class="absolute inset-0 p-5 flex flex-col justify-between">
                            <div class="flex justify-end">
                                <span class="w-7 h-7 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white text-xs opacity-0 group-hover:opacity-100 transition-all duration-300">→</span>
                            </div>
                            <h3 class="font-medium text-base text-white tracking-tight">{{ $category->name }}</h3>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-sm text-neutral-400">Belum ada kategori.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- PRODUCTS -->
    <section id="produk" class="py-20 sm:py-24 px-5 sm:px-6 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12">
                <div class="reveal">
                    <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-neutral-400 mb-2">Best Seller</p>
                    <h2 class="text-3xl sm:text-4xl font-semibold tracking-tight text-neutral-900">Produk Terlaris</h2>
                </div>
                <a
                    href="{{ route('produk.index') }}"
                    class="reveal reveal-delay-1 inline-flex items-center gap-1.5 text-sm font-medium text-neutral-600 hover:text-neutral-900 transition-all group"
                >
                    Lihat semua
                    <span class="group-hover:translate-x-0.5 transition-transform">→</span>
                </a>
            </div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">                @forelse ($featuredProducts as $product)
                    <a href="{{ route('produk.show', $product) }}"
                       class="reveal-scale reveal-delay-{{ min($loop->iteration, 6) }} product-card group bg-white rounded-2xl overflow-hidden border border-neutral-100 hover:border-neutral-200 hover:shadow-[0_16px_40px_rgba(0,0,0,0.06)] transition-all duration-500">

<div class="relative aspect-[3/4] overflow-hidden bg-white">
    <img
        src="{{ $product->image_url }}"
        alt="{{ $product->name }}"
        class="product-image w-full h-full object-contain p-4"
        loading="lazy"
        decoding="async"
        width="600"
        height="750"
    >
</div>

                        <div class="p-4">
                            <p class="text-[10px] uppercase tracking-wider text-neutral-400 mb-1">{{ $product->category?->name }}</p>
                            <h3 class="font-medium text-sm leading-snug text-neutral-800 line-clamp-2 min-h-[40px]">{{ $product->name }}</h3>
                            <div class="mt-4">
                                <p class="text-base font-semibold tracking-tight text-neutral-900">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                @if ($product->original_price && $product->original_price > $product->price)
                                    <p class="mt-0.5 text-xs text-neutral-400 line-through">
                                        Rp{{ number_format($product->original_price, 0, ',', '.') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-sm text-neutral-400">Belum ada produk.</p>
                @endforelse
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
                <a
                    href="https://www.instagram.com/konvexaofficial?stkn=NDZ0NWdqdjlmdmVi&utm_source=qr"
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
                        <p class="text-xs text-neutral-400 mt-0.5">@konvexaofficial</p>
                    </div>
                    <span class="text-neutral-300 group-hover:text-neutral-900 transition">→</span>
                </a>

                <a
                    href="https://tiktok.com/"
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
                        <p class="text-xs text-neutral-400 mt-0.5">@konvexa.official</p>
                    </div>
                    <span class="text-neutral-300 group-hover:text-neutral-900 transition">→</span>
                </a>

                <a
                    href="https://wa.me/62895411146879"
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
                        <p class="text-xs text-neutral-400 mt-0.5">+62 895-4111-46879</p>
                    </div>
                    <span class="text-neutral-300 group-hover:text-neutral-900 transition">→</span>
                </a>

                <a
                    href="mailto:konvexaofficial@gmail.com"
                    class="group flex items-center gap-4 p-5 rounded-2xl bg-white border border-neutral-100 hover:border-neutral-200 hover:shadow-[0_12px_32px_rgba(0,0,0,0.06)] transition-all duration-300 text-left"
                >
                    <div class="w-11 h-11 rounded-xl bg-neutral-50 flex items-center justify-center shrink-0 group-hover:bg-neutral-900 transition-colors duration-300">
                        <svg class="w-5 h-5 text-neutral-700 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-neutral-900">Email</p>
                        <p class="text-xs text-neutral-400 mt-0.5">konvexaofficial@gmail.com</p>
                    </div>
                    <span class="text-neutral-300 group-hover:text-neutral-900 transition">→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- AI ASSISTANT -->
    <div class="fixed bottom-5 right-5 z-[80]">

        <!-- Teaser -->
        <div
            x-show="!chatOpen && chatHint"
            x-cloak
            x-transition
            class="absolute bottom-[68px] right-0 w-[250px] rounded-2xl border border-neutral-200 bg-white px-4 py-3.5 shadow-lg"
        >
            <div class="flex items-start gap-3">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-neutral-900 text-white text-[11px] font-bold">AI</div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-neutral-900">Ada yang bisa dibantu?</p>
                    <p class="mt-0.5 text-xs text-neutral-500">Tanya produk, harga, atau cara order.</p>
                    <button @click="openChat()" class="mt-2 text-xs font-semibold text-neutral-900 hover:underline">Mulai chat →</button>
                </div>
                <button @click="chatHint = false" class="text-neutral-300 hover:text-neutral-600 text-lg leading-none" aria-label="Tutup">×</button>
            </div>
        </div>

        <!-- Chat Window -->
        <div
            x-show="chatOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-3 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="chat-window mb-3 w-[calc(100vw-2rem)] sm:w-[370px] overflow-hidden rounded-2xl border border-neutral-200 bg-white"
        >
            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3.5 bg-neutral-900 text-white">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-neutral-900 text-[11px] font-bold">AI</div>
                    <div>
                        <p class="text-sm font-semibold">Konvexa AI</p>
                        <p class="text-[11px] text-white/50">Asisten virtual · Online</p>
                    </div>
                </div>
                <button @click="chatOpen = false" class="rounded-full p-1.5 text-white/50 hover:bg-white/10 hover:text-white transition" aria-label="Tutup">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6 6 18"/></svg>
                </button>
            </div>

            <!-- Quick suggestions -->
            <div class="px-3 pt-3 pb-2 flex gap-2 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden border-b border-neutral-100">
                <button @click="askSuggestion('Ada produk kaos?')" class="shrink-0 rounded-full border border-neutral-200 bg-white px-3 py-1.5 text-[11px] font-medium text-neutral-600 hover:bg-neutral-50 transition">Cari produk</button>
                <button @click="askSuggestion('Berapa harga workshirt?')" class="shrink-0 rounded-full border border-neutral-200 bg-white px-3 py-1.5 text-[11px] font-medium text-neutral-600 hover:bg-neutral-50 transition">Cek harga</button>
                <button @click="askSuggestion('Bagaimana cara order?')" class="shrink-0 rounded-full border border-neutral-200 bg-white px-3 py-1.5 text-[11px] font-medium text-neutral-600 hover:bg-neutral-50 transition">Cara order</button>
            </div>

            <!-- Messages -->
            <div id="chat-messages" class="chat-scroll h-[270px] overflow-y-auto bg-neutral-50/60 px-3 py-3 space-y-2.5">
                <template x-for="(msg, index) in chatMessages" :key="index">
                    <div class="flex" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">
                        <div
                            class="max-w-[85%] rounded-2xl px-3.5 py-2 text-[13px] leading-relaxed whitespace-pre-line"
                            :class="msg.role === 'user' ? 'rounded-br-sm bg-neutral-900 text-white' : 'rounded-bl-sm border border-neutral-200 bg-white text-neutral-700'"
                            x-text="msg.text"
                        ></div>
                    </div>
                </template>

                <div x-show="chatLoading" class="flex justify-start" x-cloak>
                    <div class="rounded-2xl rounded-bl-sm border border-neutral-200 bg-white px-4 py-2.5">
                        <div class="flex items-center gap-1.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-neutral-400 animate-bounce"></span>
                            <span class="h-1.5 w-1.5 rounded-full bg-neutral-400 animate-bounce [animation-delay:120ms]"></span>
                            <span class="h-1.5 w-1.5 rounded-full bg-neutral-400 animate-bounce [animation-delay:240ms]"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input -->
            <div class="border-t border-neutral-100 p-3 bg-white">
                <form @submit.prevent="sendChat()" class="flex items-center gap-2">
                    <input
                        id="chat-input"
                        type="text"
                        x-model="chatMessage"
                        @keydown.enter.exact.prevent="sendChat()"
                        maxlength="500"
                        placeholder="Tanya apa saja..."
                        class="flex-1 h-10 rounded-full border border-neutral-200 bg-neutral-50 px-4 text-sm text-neutral-800 outline-none placeholder:text-neutral-400 focus:border-neutral-400 focus:bg-white transition"
                    >
                    <button
                        type="submit"
                        :disabled="chatLoading || !chatMessage.trim()"
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-neutral-900 text-white transition hover:bg-neutral-700 disabled:opacity-30"
                        aria-label="Kirim"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Launcher -->
        <div class="flex items-center justify-end">
            <button
                @click="chatOpen ? chatOpen = false : openChat()"
                class="relative flex h-14 w-14 items-center justify-center rounded-full bg-neutral-900 text-white shadow-lg transition hover:scale-105 hover:bg-neutral-800 active:scale-95"
                aria-label="Buka AI Assistant"
            >
                <template x-if="!chatOpen">
                    <span class="text-sm font-bold tracking-tight">AI</span>
                </template>
                <template x-if="chatOpen">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6 6 18"/></svg>
                </template>
                <span x-show="!chatOpen && chatHint" class="absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-emerald-500 text-[9px] font-bold text-white">1</span>
            </button>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-neutral-950 text-white">
        <div class="max-w-6xl mx-auto px-5 sm:px-6 py-14">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-1">
                        <span class="text-xl font-semibold tracking-tight">Konvexa</span>
                        <span class="text-xl font-light text-neutral-500 tracking-tight">Official</span>
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
                        <a href="#produk" class="block text-sm text-neutral-500 hover:text-white transition">Produk</a>
                    </div>
                </div>

                <div>
                    <h4 class="text-[11px] uppercase tracking-wider font-medium text-neutral-500">Bantuan</h4>
                    <div class="mt-4 space-y-2.5">
                        <a href="#kontak" class="block text-sm text-neutral-500 hover:text-white transition">Hubungi Kami</a>
                        <a href="#" class="block text-sm text-neutral-500 hover:text-white transition">FAQ</a>
                        <a href="#" class="block text-sm text-neutral-500 hover:text-white transition">Kebijakan Privasi</a>
                        <a href="#" class="block text-sm text-neutral-500 hover:text-white transition">Syarat &amp; Ketentuan</a>
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-white/5 flex flex-col sm:flex-row justify-between gap-2">
                <p class="text-xs text-neutral-600">© 2026 Konvexa Official. All rights reserved.</p>
                <p class="text-xs text-neutral-600">Crafted for modern konveksi.</p>
            </div>
        </div>
    </footer>

</body>
</html>