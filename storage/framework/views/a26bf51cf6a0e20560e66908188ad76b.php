<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Produk | Konvexa Apparel</title>
    <meta name="description" content="Katalog lengkap produk Konvexa Apparel — konveksi murah berkualitas untuk kaos, kemeja, seragam, dan apparel custom.">
    <meta name="theme-color" content="#171717">
    <link rel="canonical" href="<?php echo e(route('produk.index')); ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Konvexa Apparel">
    <meta property="og:title" content="Katalog Produk | Konvexa Apparel">
    <meta property="og:description" content="Jelajahi katalog kaos, polo, kemeja, seragam, dan apparel custom dari Konvexa Apparel.">
    <meta property="og:url" content="<?php echo e(route('produk.index')); ?>">
    <meta property="og:image" content="<?php echo e(asset('image/hero-apparel-feature.png')); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="icon" type="image/png" sizes="64x64" href="<?php echo e(asset('favicon-konvexa.png')); ?>?v=1">

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

        .product-image {
            transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .product-card:hover .product-image {
            transform: scale(1.04);
        }

        .page-enter {
            animation: pageIn 0.55s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes pageIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .filter-chip {
            transition: all 0.25s ease;
        }
        .filter-chip.active {
            background: #171717;
            color: #fff;
            border-color: #171717;
        }

        ::selection { background: #171717; color: #fff; }
    </style>
</head>

<body class="antialiased" x-data="{ mobileMenu: false }">

    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 bg-white/92 backdrop-blur-md border-b border-neutral-100">
        <div class="max-w-6xl mx-auto px-5 sm:px-6">
            <div class="h-16 flex items-center justify-between">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-1 group">
                    <span class="text-xl font-semibold tracking-tight text-neutral-900">Konvexa</span>
                    <span class="text-xl font-light tracking-tight text-neutral-400">Apparel</span>
                </a>

                <div class="hidden md:flex items-center gap-1">
                    <a href="<?php echo e(route('home')); ?>#beranda" class="nav-link px-3.5 py-2 text-[13px] font-medium text-neutral-500 hover:text-neutral-900 transition">Beranda</a>
                    <a href="<?php echo e(route('home')); ?>#tentang" class="nav-link px-3.5 py-2 text-[13px] font-medium text-neutral-500 hover:text-neutral-900 transition">Tentang Kami</a>
                    <a href="<?php echo e(route('home')); ?>#kategori" class="nav-link px-3.5 py-2 text-[13px] font-medium text-neutral-500 hover:text-neutral-900 transition">Katalog</a>
                    <a href="<?php echo e(route('produk.index')); ?>" class="nav-link active px-3.5 py-2 text-[13px] font-medium text-neutral-900 relative after:content-[''] after:absolute after:left-1/2 after:-translate-x-1/2 after:bottom-1.5 after:w-4 after:h-[1.5px] after:bg-neutral-900">Produk</a>
                    <a href="<?php echo e(route('home')); ?>#kontak" class="nav-link px-3.5 py-2 text-[13px] font-medium text-neutral-500 hover:text-neutral-900 transition">Kontak</a>
                </div>

                <div class="flex items-center gap-1">
                    <a href="<?php echo e(route('home')); ?>" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-neutral-600 hover:text-neutral-900 transition group">
                        <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M19 12H5m0 0 6 6m-6-6 6-6"/>
                        </svg>
                        Kembali
                    </a>
                    <button
                        @click="mobileMenu = !mobileMenu"
                        class="md:hidden w-9 h-9 flex items-center justify-center rounded-full text-neutral-700 hover:bg-neutral-100 transition"
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
                <a href="<?php echo e(route('home')); ?>#beranda" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition">Beranda</a>
                <a href="<?php echo e(route('home')); ?>#tentang" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition">Tentang Kami</a>
                <a href="<?php echo e(route('home')); ?>#kategori" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition">Katalog</a>
                <a href="<?php echo e(route('produk.index')); ?>" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-neutral-900 bg-neutral-50 transition">Produk</a>
                <a href="<?php echo e(route('home')); ?>#kontak" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-neutral-700 hover:bg-neutral-50 transition">Kontak</a>
                <a href="<?php echo e(route('home')); ?>" class="block px-4 py-2.5 rounded-lg text-sm font-medium text-neutral-500 hover:bg-neutral-50 transition sm:hidden">← Kembali ke beranda</a>
            </div>
        </div>
    </nav>

    <main class="page-enter">
        <!-- HEADER -->
        <section class="bg-white border-b border-neutral-100">
            <div class="max-w-6xl mx-auto px-5 sm:px-6 py-12 sm:py-16">
                <p class="text-[11px] font-medium uppercase tracking-[0.2em] text-neutral-400 mb-3">Catalog</p>
                <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight text-neutral-900">Semua Produk</h1>
                <p class="mt-3 max-w-lg text-sm text-neutral-500 font-light leading-relaxed">
                    Jelajahi seluruh koleksi Konvexa Apparel. Filter berdasarkan kategori yang kamu butuhkan.
                </p>

                <!-- Banner panjang -->
                <div class="mt-8 relative w-full h-28 sm:h-36 lg:h-40 rounded-2xl overflow-hidden">
                    <img
                        src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1600&q=80"
                        alt="Koleksi produk Konvexa Apparel"
                        class="w-full h-full object-cover"
                        loading="lazy"
                        decoding="async"
                    >
                    <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/70 via-neutral-950/20 to-transparent"></div>
                    <div class="absolute inset-0 flex items-center px-6 sm:px-8">
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-white/70 font-medium">Koleksi Terbaru</p>
                            <p class="mt-1 text-sm sm:text-base font-medium text-white">Kualitas premium, harga bersahabat.</p>
                        </div>
                    </div>
                </div>

                <!-- Filter kategori (dari database) -->
                <div class="mt-7 flex flex-wrap gap-2">
                    <a href="<?php echo e(route('produk.index')); ?>"
                       class="filter-chip px-3.5 py-1.5 rounded-full text-xs font-medium border border-neutral-200 text-neutral-600 hover:border-neutral-400 <?php echo e(request('category') ? '' : 'active'); ?>">
                        Semua
                    </a>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('produk.index', ['category' => $category->slug])); ?>"
                           class="filter-chip px-3.5 py-1.5 rounded-full text-xs font-medium border border-neutral-200 text-neutral-600 hover:border-neutral-400 <?php echo e(request('category') === $category->slug ? 'active' : ''); ?>">
                            <?php echo e($category->name); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>

        <!-- GRID -->
        <section class="py-10 sm:py-14 px-5 sm:px-6">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center justify-between mb-6">
                    <p class="text-sm text-neutral-500 font-light">
                        <span class="font-medium text-neutral-800"><?php echo e($products->total()); ?></span>
                        produk ditemukan
                    </p>
                </div>

                <?php if($products->isEmpty()): ?>
                    <div class="py-20 text-center">
                        <p class="text-sm font-medium text-neutral-800">Tidak ada produk</p>
                        <p class="mt-1 text-xs text-neutral-400">Coba pilih kategori lain</p>
                        <a href="<?php echo e(route('produk.index')); ?>"
                           class="mt-5 inline-flex px-5 py-2.5 rounded-full bg-neutral-900 text-white text-sm font-medium hover:bg-neutral-700 transition">
                            Reset filter
                        </a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <article class="product-card group bg-white rounded-2xl overflow-hidden border border-neutral-100 hover:border-neutral-200 hover:shadow-[0_16px_40px_rgba(0,0,0,0.06)] transition-all duration-500">
<div class="relative aspect-[3/4] overflow-hidden bg-white">
    <img
        src="<?php echo e($product->image_url); ?>"
        alt="<?php echo e($product->name); ?>"
        class="product-image w-full h-full object-contain p-4"
        loading="lazy"
        decoding="async"
        width="600"
        height="750"
    >
</div>
                                <div class="p-4">
                                    <p class="text-[10px] uppercase tracking-wider text-neutral-400 mb-1"><?php echo e($product->category?->name); ?></p>
                                    <h2 class="font-medium text-sm leading-snug text-neutral-800 line-clamp-2 min-h-[40px]"><?php echo e($product->name); ?></h2>
                                    <a href="https://wa.me/<?php echo e($whatsappNumber); ?>?text=<?php echo e(urlencode('Halo Konvexa, saya tertarik dengan produk ' . $product->name)); ?>"
                                       target="_blank" rel="noopener noreferrer"
                                       class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-full bg-neutral-900 px-4 py-2.5 text-xs font-medium text-white hover:bg-neutral-700 transition">
                                        Hubungi Admin
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="mt-10">
                        <?php echo e($products->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="bg-neutral-950 text-white">
        <div class="max-w-6xl mx-auto px-5 sm:px-6 py-14">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
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
                        <a href="<?php echo e(route('home')); ?>#beranda" class="block text-sm text-neutral-500 hover:text-white transition">Beranda</a>
                        <a href="<?php echo e(route('home')); ?>#tentang" class="block text-sm text-neutral-500 hover:text-white transition">Tentang Kami</a>
                        <a href="<?php echo e(route('home')); ?>#kategori" class="block text-sm text-neutral-500 hover:text-white transition">Katalog</a>
                        <a href="<?php echo e(route('produk.index')); ?>" class="block text-sm text-neutral-500 hover:text-white transition">Produk</a>
                    </div>
                </div>
                <div>
                    <h4 class="text-[11px] uppercase tracking-wider font-medium text-neutral-500">Bantuan</h4>
                    <div class="mt-4 space-y-2.5">
                        <a href="<?php echo e(route('home')); ?>#kontak" class="block text-sm text-neutral-500 hover:text-white transition">Hubungi Kami</a>
                        <a href="#" class="block text-sm text-neutral-500 hover:text-white transition">FAQ</a>
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
</html><?php /**PATH C:\laragon\www\ecomerce-knv\resources\views\produk.blade.php ENDPATH**/ ?>