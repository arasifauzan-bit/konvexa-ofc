<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#17283d">
    <title>Login Admin — Konvexa</title>
    <link rel="icon" type="image/png" sizes="64x64" href="<?php echo e(asset('favicon-konvexa.png')); ?>?v=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', system-ui, sans-serif; }
        .login-art {
            background:
                radial-gradient(circle at 22% 22%, rgba(119, 172, 212, .34), transparent 30%),
                linear-gradient(145deg, #17283d 0%, #203e5d 56%, #315c7b 100%);
        }
        .login-art::before,
        .login-art::after {
            content: '';
            position: absolute;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 9999px;
            pointer-events: none;
        }
        .login-art::before {
            width: 42rem;
            height: 42rem;
            right: -17rem;
            bottom: -25rem;
        }
        .login-art::after {
            width: 32rem;
            height: 32rem;
            right: -12rem;
            bottom: -20rem;
        }
        @media (prefers-reduced-motion: no-preference) {
            .login-float { animation: loginFloat 8s ease-in-out infinite; }
            @keyframes loginFloat {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
        }
    </style>
</head>
<body class="min-h-screen bg-white text-slate-900 antialiased">
    <main class="grid min-h-screen lg:grid-cols-[1.05fr_0.95fr]">
        <section class="login-art relative isolate flex min-h-[360px] flex-col overflow-hidden px-6 py-7 text-white sm:px-10 sm:py-9 lg:min-h-screen lg:px-14 lg:py-12">
            <img src="<?php echo e(asset('image/hero-apparel-feature.png')); ?>" alt=""
                 class="login-float pointer-events-none absolute -right-10 top-10 h-48 w-64 object-contain opacity-25 sm:right-0 sm:top-16 sm:h-64 sm:w-80 lg:right-4 lg:top-1/2 lg:h-[30rem] lg:w-[34rem] lg:-translate-y-1/2 lg:opacity-40">
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-slate-950/10 via-transparent to-slate-950/35"></div>
            <div class="relative flex items-center justify-between">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 text-lg font-semibold tracking-tight">
                    <img src="<?php echo e(asset('image/konvexa-logo.png')); ?>" alt="" class="h-10 w-10 rounded-xl bg-white object-contain p-1">
                    <span>Konvexa <span class="font-normal text-white/65">Apparel</span></span>
                </a>
                <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-[10px] font-semibold uppercase tracking-[0.16em] text-white/80">
                    Admin panel
                </span>
            </div>

            <div class="relative my-auto max-w-xl py-10 lg:py-16">
                <p class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-medium text-white/85">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span>
                    Ruang kerja tim Konvexa
                </p>
                <h1 class="mt-6 max-w-lg text-4xl font-semibold leading-[1.08] tracking-tight sm:text-5xl lg:text-6xl">
                    Katalog yang rapi,
                    <span class="mt-2 block text-sky-200">dimulai dari sini.</span>
                </h1>
                <p class="mt-5 max-w-md text-sm leading-7 text-white/70 sm:text-base">
                    Kelola kategori dan tampilan katalog dengan mudah, agar setiap koleksi Konvexa selalu tersaji konsisten.
                </p>
                <div class="mt-8 flex items-center gap-3 text-xs text-white/70">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full border border-white/20 bg-white/10">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m9 12 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </span>
                    Akses aman khusus admin
                </div>
            </div>

            <div class="relative flex items-center justify-between border-t border-white/15 pt-5 text-[11px] text-white/50">
                <span>© <?php echo e(date('Y')); ?> Konvexa Apparel</span>
                <span>Katalog · Kualitas · Konsistensi</span>
            </div>
        </section>

        <section class="flex min-h-[560px] items-center justify-center px-6 py-12 sm:px-10 lg:min-h-screen lg:px-14">
            <div class="w-full max-w-md">
                <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-slate-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m15 18-6-6 6-6M9 12h12"/>
                    </svg>
                    Kembali ke website
                </a>

                <div class="mt-10 sm:mt-14">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Admin sign in</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">Selamat datang kembali</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        Masuk untuk mengelola kategori katalog Konvexa.
                    </p>
                </div>

                <?php if($errors->any()): ?>
                    <div class="mt-7 flex gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-sm text-rose-700" role="alert">
                        <svg class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v4m0 4h.01M10.3 3.9 1.8 18.5A1.7 1.7 0 0 0 3.3 21h17.4a1.7 1.7 0 0 0 1.5-2.5L13.7 3.9a1.9 1.9 0 0 0-3.4 0Z"/>
                        </svg>
                        <span><?php echo e($errors->first()); ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('admin.login.store')); ?>" class="mt-8 space-y-5">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email admin</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 6h16v12H4zM4 7l8 6 8-6"/>
                            </svg>
                            <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username"
                                   placeholder="nama@perusahaan.com"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50/70 py-3.5 pl-11 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-slate-500 focus:bg-white focus:ring-4 focus:ring-slate-100">
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-xs text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M7 10V7a5 5 0 0 1 10 0v3m-12 0h14v11H5z"/>
                            </svg>
                            <input id="password" name="password" type="password" required autocomplete="current-password"
                                   placeholder="Masukkan password"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50/70 py-3.5 pl-11 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-slate-500 focus:bg-white focus:ring-4 focus:ring-slate-100">
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-xs text-rose-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex cursor-pointer items-center gap-2.5 text-sm text-slate-600">
                            <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-500">
                            Ingat saya
                        </label>
                        <span class="text-xs text-slate-400">Akses khusus admin</span>
                    </div>

                    <button type="submit" class="group flex w-full items-center justify-center gap-2 rounded-xl bg-slate-950 px-4 py-3.5 text-sm font-semibold text-white shadow-lg shadow-slate-950/10 transition hover:-translate-y-0.5 hover:bg-slate-800 hover:shadow-slate-950/20 focus:outline-none focus:ring-4 focus:ring-slate-200">
                        Masuk ke dashboard
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6 6 6-6 6"/>
                        </svg>
                    </button>
                </form>

                <p class="mt-8 text-center text-xs leading-5 text-slate-400">
                    Dengan masuk, Anda menyetujui kebijakan akses internal Konvexa.
                </p>
            </div>
        </section>
    </main>
</body>
</html>
<?php /**PATH C:\laragon\www\ecomerce-knv\resources\views\admin\auth\login.blade.php ENDPATH**/ ?>