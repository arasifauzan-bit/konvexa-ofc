<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Throwable;

class ChatbotController extends Controller
{
    private const SESSION_KEY = 'konvexa.chat';

    /**
     * Kata/frasa yang menunjukkan pengguna sedang merujuk
     * pada pembahasan sebelumnya.
     */
    private const REFERENSI = [
        'itu',
        'tadi',
        'tersebut',
        'nya',
        'yang tadi',
        'sebelumnya',
        'yang pertama',
        'yang kedua',
        'yang atas',
        'semuanya',
    ];

    /**
     * Kata umum yang tidak boleh dijadikan keyword pencarian produk.
     *
     * Contoh:
     * "berapa harga kaos"
     *
     * Keyword yang dipakai hanya:
     * "kaos"
     *
     * Bukan "berapa", "harga", dll.
     */
    private const KATA_UMUM = [
        'ada',
        'apa',
        'apakah',
        'berapa',
        'bisa',
        'boleh',
        'buat',
        'buatkan',
        'cari',
        'cara',
        'dari',
        'dengan',
        'dan',
        'di',
        'dong',
        'untuk',
        'yang',
        'ini',
        'itu',
        'saya',
        'aku',
        'kami',
        'kamu',
        'mau',
        'ingin',
        'tolong',
        'please',
        'nya',
        'kah',
        'ya',
        'yg',
        'aja',
        'saja',
        'juga',
        'lebih',
        'paling',

        // Harga
        'harga',
        'price',
        'biaya',
        'tarif',
        'banderol',

        // Order
        'order',
        'pesan',
        'pesanan',
        'pemesanan',
        'produksi',
        'konveksi',
        'custom',

        // Informasi umum
        'minimal',
        'minimum',
        'bahan',
        'kain',
        'material',
        'ukuran',
        'size',
        'stok',
        'ready',
        'tersedia',
        'masih',
        'lama',
        'estimasi',
        'waktu',
        'pembayaran',
        'bayar',
        'pengiriman',
        'kirim',
        'ongkir',

        // Kata percakapan
        'halo',
        'hai',
        'hi',
        'hello',
        'pagi',
        'siang',
        'sore',
        'malam',
        'permisi',
    ];

    /**
     * Endpoint chatbot.
     */
    public function message(Request $request): JsonResponse
    {
        $raw = trim((string) $request->input('message'));

        $max = (int) config('konvexa.chat.max_length', 500);

        if ($raw === '') {
            return $this->reply(
                'Tulis pertanyaan Anda tentang produk, harga, bahan, atau pemesanan.',
                [
                    'suggestions' => $this->saranAwal(),
                ]
            );
        }

        if (mb_strlen($raw) > $max) {
            return $this->reply(
                "Pertanyaan melebihi {$max} karakter. Ringkas dulu, atau kirim dalam beberapa pesan.",
                [],
                422
            );
        }

        try {
            $q = $this->normalize($raw);

            $keywords = $this->keywords($q);

            $konteks = $this->konteks();

            $this->ingat('user', $raw);

            /*
             * Urutan intent dibuat hati-hati.
             *
             * 1. Sapaan
             * 2. Terima kasih
             * 3. Pertanyaan lanjutan berdasarkan context
             * 4. FAQ / order / kontak yang jelas
             * 5. Superlatif yang memang didukung database
             * 6. Kategori
             * 7. Produk literal
             * 8. Fuzzy product
             * 9. Fallback
             */
            $response = $this->tanganiSapaan($q)
                ?? $this->tanganiTerimaKasih($q)
                ?? $this->tanganiLanjutan($q, $keywords, $konteks)
                ?? $this->tanganiFaq($q)
                ?? $this->tanganiPemesanan($q)
                ?? $this->tanganiKontak($q)
                ?? $this->tanganiPerusahaan($q)
                ?? $this->tanganiSuperlatif($q)
                ?? $this->tanganiKategori($q)
                ?? $this->tanganiProduk($q, $keywords)
                ?? $this->tanganiProdukMirip($q, $keywords)
                ?? $this->tanganiTidakPaham();

            return $response;
        } catch (Throwable $e) {
            Log::error('Konvexa chatbot error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_message' => $raw,
            ]);

            return $this->reply(
                'Maaf, sistem chatbot sedang mengalami kendala. Silakan coba lagi atau hubungi tim Konvexa melalui WhatsApp.',
                [
                    'actions' => [
                        $this->tombolWhatsapp('Hubungi tim'),
                    ],
                ]
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | INTENT
    |--------------------------------------------------------------------------
    */

    /**
     * Sapaan.
     */
    private function tanganiSapaan(string $q): ?JsonResponse
    {
        $sapaan = [
            'halo',
            'hai',
            'hi',
            'hello',
            'pagi',
            'siang',
            'sore',
            'malam',
            'assalamualaikum',
            'permisi',
        ];

        if (
            str_word_count($q) > 4
            || ! $this->mengandungKata($q, $sapaan)
        ) {
            return null;
        }

        $nama = config('konvexa.perusahaan.nama', 'Konvexa');

        return $this->reply(
            "Halo! Saya asisten {$nama} 👋\n\n"
            . "Saya bisa membantu mencari produk, mengecek harga, "
            . "melihat kategori, dan memberikan informasi pemesanan. "
            . "Silakan tanyakan yang Anda butuhkan.",
            [
                'suggestions' => $this->saranAwal(),
            ]
        );
    }

    /**
     * Terima kasih.
     *
     * "oke saya mau harga kaos"
     * tidak boleh dianggap sebagai ucapan terima kasih.
     */
    private function tanganiTerimaKasih(string $q): ?JsonResponse
    {
        $kata = preg_split('/\s+/', trim($q)) ?: [];

        $terimaKasih = $this->mengandung(
            $q,
            [
                'terima kasih',
                'terimakasih',
                'makasih',
                'thanks',
                'thank you',
            ]
        );

        $pendek = count($kata) <= 3;

        $balasanPendek = $pendek
            && $this->mengandungKata(
                $q,
                [
                    'sip',
                    'mantap',
                    'oke',
                ]
            );

        if (! $terimaKasih && ! $balasanPendek) {
            return null;
        }

        return $this->reply(
            'Sama-sama! Jika ingin lanjut pesan atau konsultasi produk, saya siap membantu.',
            [
                'actions' => [
                    $this->tombolWhatsapp('Lanjut ke WhatsApp'),
                ],
            ]
        );
    }

    /**
     * Menangani pertanyaan lanjutan berdasarkan produk sebelumnya.
     *
     * Contoh:
     *
     * User:
     * "Cari kaos"
     *
     * Bot:
     * [daftar kaos]
     *
     * User:
     * "berapa harganya?"
     *
     * -> harga daftar kaos tadi.
     *
     * User:
     * "yang tadi bahannya apa?"
     *
     * -> FAQ bahan.
     */
    private function tanganiLanjutan(
        string $q,
        Collection $keywords,
        array $konteks
    ): ?JsonResponse {
        $produkIds = $konteks['produk'] ?? [];

        if (empty($produkIds)) {
            return null;
        }

        $produk = Product::with('category:id,name,slug')
            ->where('is_active', true)
            ->whereIn('id', $produkIds)
            ->get();

        if ($produk->isEmpty()) {
            return null;
        }

        $merujuk = $this->mengandung($q, self::REFERENSI);

        /*
         * Atribut yang memang sangat umum ditanyakan sebagai follow-up.
         */
        $tanyaHarga = $this->tanyaHarga($q);

        $tanyaBahan = $this->mengandung(
            $q,
            [
                'bahan',
                'kain',
                'material',
            ]
        );

        $tanyaUkuran = $this->mengandung(
            $q,
            [
                'ukuran',
                'size',
                'ukuran apa',
            ]
        );

        $tanyaStok = $this->mengandung(
            $q,
            [
                'stok',
                'ready',
                'tersedia',
                'masih ada',
            ]
        );

        /*
         * Jika user sudah menyebut produk baru,
         * jangan gunakan context produk lama.
         */
        $adaProdukBaru = $this->adaNamaProdukDiPertanyaan($q);

        if ($adaProdukBaru && ! $merujuk) {
            return null;
        }

        /*
         * Harga/bahan/ukuran/stok merupakan follow-up yang valid
         * walaupun tidak ada kata "itu/tadi".
         *
         * Contoh:
         * "berapa harganya?"
         * "bahannya apa?"
         */
        if (
            ! $merujuk
            && ! $tanyaHarga
            && ! $tanyaBahan
            && ! $tanyaUkuran
            && ! $tanyaStok
        ) {
            /*
             * Pertanyaan pendek seperti:
             * "yang mana?"
             * "yang pertama?"
             */
            if (str_word_count($q) > 5) {
                return null;
            }
        }

        if ($tanyaHarga) {
            return $this->balasProduk(
                $produk,
                'Berikut harga produk yang tadi kita bahas:'
            );
        }

        if ($tanyaBahan) {
            $faq = config('konvexa.faq.bahan');

            if (is_array($faq) && ! empty($faq['reply'])) {
                return $this->reply(
                    $faq['reply'],
                    [
                        'suggestions' => $faq['follow_up'] ?? [],
                    ]
                );
            }

            return $this->reply(
                'Informasi bahan belum tersedia di data chatbot. Untuk memastikan bahan produk yang Anda pilih, silakan konfirmasi ke tim Konvexa.',
                [
                    'actions' => [
                        $this->tombolWhatsapp('Tanyakan bahan'),
                    ],
                ]
            );
        }

        if ($tanyaUkuran) {
            $faq = config('konvexa.faq.ukuran');

            if (is_array($faq) && ! empty($faq['reply'])) {
                return $this->reply(
                    $faq['reply'],
                    [
                        'suggestions' => $faq['follow_up'] ?? [],
                    ]
                );
            }

            return $this->reply(
                'Informasi ukuran belum tersedia di data chatbot. Silakan kirim produk dan ukuran yang diinginkan ke tim Konvexa untuk dikonfirmasi.',
                [
                    'actions' => [
                        $this->tombolWhatsapp('Tanyakan ukuran'),
                    ],
                ]
            );
        }

        if ($tanyaStok) {
            $nama = $produk
                ->pluck('name')
                ->unique()
                ->implode(', ');

            return $this->reply(
                "Untuk ketersediaan {$nama}, saya belum memiliki data stok real-time. "
                . "Silakan konfirmasi ketersediaan dan jadwal produksinya melalui WhatsApp.",
                [
                    'actions' => [
                        $this->tombolWhatsapp('Tanyakan ketersediaan'),
                    ],
                ]
            );
        }

        if ($merujuk) {
            return $this->balasProduk(
                $produk,
                'Ini detail produk yang tadi disebut:'
            );
        }

        return null;
    }

    /**
     * Superlatif yang benar-benar bisa dibuktikan dari database.
     *
     * HANYA:
     * - termurah
     * - termahal
     * - terbaru
     *
     * Tidak memakai:
     * rating
     * sold
     * is_featured
     * premium
     * terbaik
     * rekomendasi
     */
    private function tanganiSuperlatif(string $q): ?JsonResponse
    {
        $murah = $this->mengandung(
            $q,
            [
                'termurah',
                'paling murah',
                'paling terjangkau',
            ]
        );

        $mahal = $this->mengandung(
            $q,
            [
                'termahal',
                'paling mahal',
            ]
        );

        $baru = $this->mengandung(
            $q,
            [
                'terbaru',
                'produk baru',
                'paling baru',
                'keluaran terbaru',
            ]
        );

        if (! $murah && ! $mahal && ! $baru) {
            return null;
        }

        $limit = (int) config(
            'konvexa.chat.max_produk',
            5
        );

        $query = Product::with('category:id,name,slug')
            ->where('is_active', true);

        if ($murah) {
            $query->orderBy('price', 'asc');

            $judul = 'Produk dengan harga paling rendah di katalog:';
        } elseif ($mahal) {
            $query->orderBy('price', 'desc');

            $judul = 'Produk dengan harga paling tinggi di katalog:';
        } else {
            $query->orderByDesc('created_at');

            $judul = 'Produk terbaru di katalog:';
        }

        $produk = $query
            ->limit($limit)
            ->get();

        if ($produk->isEmpty()) {
            return $this->reply(
                'Belum ada data produk yang bisa ditampilkan.'
            );
        }

        return $this->balasProduk(
            $produk,
            $judul
        );
    }

    /**
     * Kategori.
     */
    private function tanganiKategori(string $q): ?JsonResponse
    {
        $inginKategori = $this->mengandung(
            $q,
            [
                'kategori',
                'katalog',
                'jenis produk',
                'produk apa saja',
                'ada produk apa',
                'jual apa',
            ]
        );

        if (! $inginKategori) {
            return null;
        }

        $kategori = $this->indeksKategori();

        if ($kategori->isEmpty()) {
            return $this->reply(
                'Katalog sedang diperbarui. Untuk daftar produk terbaru, silakan hubungi tim Konvexa.',
                [
                    'actions' => [
                        $this->tombolWhatsapp('Minta katalog'),
                    ],
                ]
            );
        }

        /*
         * Kalau user mengatakan:
         * "kategori kaos"
         *
         * coba tampilkan produk kategori tersebut.
         */
        foreach ($kategori as $namaKategori) {
            if (
                $this->mengandungKata(
                    $q,
                    [
                        Str::lower($namaKategori),
                    ]
                )
            ) {
                $produk = Product::with('category:id,name,slug')
                    ->where('is_active', true)
                    ->whereHas('category', function ($query) use ($namaKategori) {
                        $query->where('name', $namaKategori);
                    })
                    ->limit(
                        (int) config(
                            'konvexa.chat.max_produk',
                            5
                        )
                    )
                    ->get();

                if ($produk->isNotEmpty()) {
                    return $this->balasProduk(
                        $produk,
                        "Produk kategori {$namaKategori}:"
                    );
                }
            }
        }

        return $this->reply(
            "Kategori yang tersedia:\n\n• "
            . $kategori->implode("\n• ")
            . "\n\nSebutkan nama kategori yang ingin Anda lihat.",
            [
                'suggestions' => $kategori
                    ->take(3)
                    ->map(fn ($k) => "Produk {$k}")
                    ->all(),
            ]
        );
    }

    /**
     * Pencarian produk literal.
     *
     * Tidak lagi:
     * WHERE name LIKE "%berapa%"
     * OR name LIKE "%harga%"
     * OR name LIKE "%kaos%"
     *
     * Hanya keyword produk yang relevan yang dipakai.
     */
    private function tanganiProduk(
        string $q,
        Collection $keywords
    ): ?JsonResponse {
        if ($keywords->isEmpty()) {
            return null;
        }

        /*
         * Jangan mencari produk untuk pertanyaan yang jelas-jelas
         * merupakan FAQ/order/kontak.
         */
        if ($this->pertanyaanNonProduk($q)) {
            return null;
        }

        $produk = $this->cariProdukLiteral($q, $keywords);

        if ($produk->isEmpty()) {
            return null;
        }

        $judul = $this->tanyaHarga($q)
            ? 'Berikut harga produk yang cocok dengan pencarian Anda:'
            : 'Produk yang cocok dengan pencarian Anda:';

        return $this->balasProduk(
            $produk,
            $judul
        );
    }

    /**
     * Cegah pertanyaan FAQ masuk ke pencarian produk.
     */
    private function pertanyaanNonProduk(string $q): bool
    {
        $frasa = [
            'minimal order',
            'minimum order',
            'minimal pemesanan',
            'minimum pemesanan',

            'berapa lama produksi',
            'lama produksi',
            'estimasi produksi',
            'waktu produksi',
            'lead time',

            'metode pembayaran',
            'cara pembayaran',
            'pembayaran',

            'pengiriman',
            'ongkir',
            'kirim barang',

            'cara pesan',
            'cara order',
            'bagaimana cara order',
            'bagaimana cara pesan',
            'alur pemesanan',
            'proses pemesanan',
            'langkah pemesanan',

            'bahan',
            'material',
            'ukuran',
            'size',

            'stok',
            'ready',
            'tersedia',

            'kontak',
            'whatsapp',
            'instagram',
            'tiktok',
            'email',
        ];

        return $this->mengandung($q, $frasa);
    }

    /**
     * Fuzzy search hanya untuk typo yang masuk akal.
     */
    private function tanganiProdukMirip(
        string $q,
        Collection $keywords
    ): ?JsonResponse {
        if ($keywords->isEmpty()) {
            return null;
        }

        if ($this->pertanyaanNonProduk($q)) {
            return null;
        }

        /*
         * Jangan menjalankan fuzzy untuk pertanyaan yang sama sekali
         * tidak terlihat seperti pertanyaan produk.
         */
        if (! $this->terlihatSepertiProduk($q)) {
            return null;
        }

        $limit = (int) config(
            'konvexa.chat.max_produk',
            5
        );

        $ids = $this->idProdukMirip(
            $keywords,
            $limit
        );

        if (empty($ids)) {
            return null;
        }

        $produk = Product::with('category:id,name,slug')
            ->where('is_active', true)
            ->whereIn('id', $ids)
            ->get();

        if ($produk->isEmpty()) {
            return null;
        }

        return $this->balasProduk(
            $produk,
            'Saya belum menemukan nama yang persis. Mungkin maksud Anda produk berikut:'
        );
    }

    /**
     * FAQ dari config.
     */
    private function tanganiFaq(string $q): ?JsonResponse
    {
        $faq = (array) config(
            'konvexa.faq',
            []
        );

        $skor = [];

        foreach ($faq as $key => $item) {
            if (! is_array($item)) {
                continue;
            }

            $patterns = $item['patterns'] ?? [];

            if (! is_array($patterns)) {
                continue;
            }

            $nilai = $this->skorPattern(
                $q,
                $patterns
            );

            if ($nilai > 0) {
                $skor[$key] = $nilai;
            }
        }

        if (empty($skor)) {
            return null;
        }

        arsort($skor);

        $terpilih = array_key_first($skor);

        if ($terpilih === null) {
            return null;
        }

        $item = $faq[$terpilih] ?? null;

        if (! is_array($item) || empty($item['reply'])) {
            return null;
        }

        $actions = [];

        /*
         * Tombol WhatsApp hanya ditambahkan kalau konfigurasi kontak
         * tersedia.
         */
        if (config('konvexa.kontak.whatsapp')) {
            $actions[] = $this->tombolWhatsapp();
        }

        return $this->reply(
            $item['reply'],
            [
                'intent' => $terpilih,
                'suggestions' => $item['follow_up'] ?? [],
                'actions' => $actions,
            ]
        );
    }

    /**
     * Tentang perusahaan.
     */
    private function tanganiPerusahaan(string $q): ?JsonResponse
    {
        if (! $this->mengandung(
            $q,
            [
                'tentang konvexa',
                'siapa konvexa',
                'konvexa itu apa',
                'perusahaan konvexa',
                'konvexa berdiri',
                'konvexa didirikan',
                'kapan konvexa',
                'profil',
                'ar rasi',
                'sejarah',
            ]
        )) {
            return null;
        }

        $deskripsi = config(
            'konvexa.perusahaan.deskripsi'
        );

        if (! $deskripsi) {
            return $this->reply(
                'Informasi profil Konvexa belum tersedia di konfigurasi chatbot.'
            );
        }

        return $this->reply(
            $deskripsi,
            [
                'suggestions' => [
                    'Lihat kategori produk',
                    'Bagaimana cara order?',
                    'Hubungi Konvexa',
                ],
            ]
        );
    }

    /**
     * Kontak.
     */
    private function tanganiKontak(string $q): ?JsonResponse
    {
        if (! $this->mengandung(
            $q,
            [
                'kontak',
                'hubungi',
                'whatsapp',
                'nomor',
                'telepon',
                'admin',
                'instagram',
                'tiktok',
                'email',
                'sosial media',
                'sosmed',
            ]
        )) {
            return null;
        }

        $k = (array) config(
            'konvexa.kontak',
            []
        );

        $whatsapp = $k['whatsapp_tampil'] ?? '-';
        $instagram = $k['instagram'] ?? '-';
        $tiktok = $k['tiktok'] ?? '-';
        $email = $k['email'] ?? '-';
        $jam = $k['jam_operasional'] ?? 'jam operasional tim';

        $teks = "Anda bisa menghubungi Konvexa lewat:\n\n"
            . "• WhatsApp — {$whatsapp}\n"
            . "• Instagram — {$instagram}\n"
            . "• TikTok — {$tiktok}\n"
            . "• Email — {$email}\n\n"
            . "Respons tercepat dapat dikonfirmasi melalui WhatsApp pada {$jam}.";

        $actions = [];

        if (! empty($k['whatsapp'])) {
            $actions[] = $this->tombolWhatsapp(
                'Chat WhatsApp'
            );
        }

        if (! empty($k['instagram_url'])) {
            $actions[] = [
                'label' => 'Instagram',
                'url' => $k['instagram_url'],
                'style' => 'ghost',
            ];
        }

        return $this->reply(
            $teks,
            [
                'actions' => $actions,
            ]
        );
    }

    /**
     * Pemesanan.
     *
     * Tidak hard-code DP 50%.
     *
     * Kalau FAQ pemesanan tersedia di config, gunakan itu.
     */
    private function tanganiPemesanan(string $q): ?JsonResponse
    {
        if (! $this->mengandung(
            $q,
            [
                'custom',
                'produksi',
                'konveksi',
                'pemesanan',
                'order',
                'pesan',
                'cara pesan',
                'cara order',
                'bagaimana cara order',
                'bagaimana cara pesan',
                'alur',
                'proses',
                'langkah',
                'mulai dari mana',
            ]
        )) {
            return null;
        }

        /*
         * Prioritaskan FAQ yang sudah disediakan pemilik website.
         */
        $faq = (array) config(
            'konvexa.faq',
            []
        );

        foreach ([
            'pemesanan',
            'order',
            'cara_pesan',
        ] as $key) {
            if (
                isset($faq[$key])
                && is_array($faq[$key])
                && ! empty($faq[$key]['reply'])
            ) {
                return $this->reply(
                    $faq[$key]['reply'],
                    [
                        'intent' => $key,
                        'suggestions' => $faq[$key]['follow_up'] ?? [],
                        'actions' => [
                            $this->tombolWhatsapp(
                                'Mulai konsultasi'
                            ),
                        ],
                    ]
                );
            }
        }

        /*
         * Fallback aman.
         *
         * Tidak mengarang:
         * - DP
         * - termin pembayaran
         * - tahapan produksi tertentu
         * - lama produksi
         */
        return $this->reply(
            "Untuk pemesanan custom, silakan sampaikan kebutuhan Anda ke tim Konvexa, seperti jenis produk, jumlah, ukuran, dan referensi desain. Tim akan membantu memberikan informasi dan penawaran sesuai kebutuhan.",
            [
                'suggestions' => [
                    'Minimal order berapa?',
                    'Berapa lama produksinya?',
                    'Metode pembayaran?',
                ],
                'actions' => [
                    $this->tombolWhatsapp(
                        'Mulai konsultasi'
                    ),
                ],
            ]
        );
    }

    /**
     * Fallback.
     */
    private function tanganiTidakPaham(): JsonResponse
    {
        return $this->reply(
            "Saya khusus membantu informasi seputar Konvexa, seperti produk, harga, kategori, bahan, ukuran, minimum order, produksi, pembayaran, pengiriman, dan cara pemesanan.",
            [
                'suggestions' => $this->saranAwal(),
                'actions' => [
                    $this->tombolWhatsapp('Tanya ke tim'),
                ],
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PENCARIAN PRODUK
    |--------------------------------------------------------------------------
    */

    /**
     * Pencarian literal dengan scoring.
     *
     * Contoh:
     *
     * "berapa harga kaos"
     *
     * keywords:
     * ["kaos"]
     *
     * bukan:
     * ["berapa", "harga", "kaos"]
     */
    private function cariProdukLiteral(
        string $q,
        Collection $keywords
    ): Collection {
        $limit = (int) config(
            'konvexa.chat.max_produk',
            5
        );

        $produk = Product::with('category:id,name,slug')
            ->where('is_active', true)
            ->get();

        if ($produk->isEmpty()) {
            return collect();
        }

        $hasil = [];

        foreach ($produk as $product) {
            $nama = $this->normalize(
                (string) $product->name
            );

            $kategori = $this->normalize(
                (string) ($product->category?->name ?? '')
            );

            $score = 0;

            /*
             * Nama produk lengkap lebih kuat.
             */
            if (
                $nama !== ''
                && Str::contains($q, $nama)
            ) {
                $score += 100;
            }

            /*
             * Nama kategori lengkap.
             */
            if (
                $kategori !== ''
                && Str::contains($q, $kategori)
            ) {
                $score += 60;
            }

            /*
             * Cocokkan token produk.
             */
            foreach ($keywords as $keyword) {
                if ($keyword === '') {
                    continue;
                }

                if (
                    Str::contains(
                        $nama,
                        $keyword
                    )
                ) {
                    $score += 20;
                }

                if (
                    $kategori !== ''
                    && Str::contains(
                        $kategori,
                        $keyword
                    )
                ) {
                    $score += 10;
                }
            }

            if ($score > 0) {
                $hasil[] = [
                    'product' => $product,
                    'score' => $score,
                ];
            }
        }

        if (empty($hasil)) {
            return collect();
        }

        /*
         * Skor terbesar lebih dulu.
         */
        usort(
            $hasil,
            fn ($a, $b) => $b['score'] <=> $a['score']
        );

        /*
         * Hindari produk dengan nama sama muncul berulang-ulang.
         *
         * Ini penting kalau database memiliki beberapa record
         * dengan nama produk identik.
         */
        $unikNama = [];
        $hasilAkhir = [];

        foreach ($hasil as $item) {
            $product = $item['product'];

            $namaKey = $this->normalize(
                (string) $product->name
            );

            if (isset($unikNama[$namaKey])) {
                continue;
            }

            $unikNama[$namaKey] = true;

            $hasilAkhir[] = $product;

            if (count($hasilAkhir) >= $limit) {
                break;
            }
        }

        return collect($hasilAkhir);
    }

    /**
     * Fuzzy search typo.
     */
    private function idProdukMirip(
        Collection $keywords,
        int $limit
    ): array {
        $keywords = $keywords
            ->filter(
                fn ($k) => mb_strlen($k) >= 4
            )
            ->values();

        if ($keywords->isEmpty()) {
            return [];
        }

        $threshold = (int) config(
            'konvexa.chat.fuzzy_threshold',
            82
        );

        /*
         * Jangan izinkan threshold terlalu rendah.
         */
        $threshold = max(
            82,
            $threshold
        );

        $indeks = $this->indeksProduk();

        $skor = [];

        foreach ($indeks as $id => $nama) {
            $terbaik = 0;

            $bagianNama = preg_split(
                '/\s+/',
                $nama
            ) ?: [];

            foreach ($keywords as $kata) {
                foreach ($bagianNama as $bagian) {
                    if (mb_strlen($bagian) < 4) {
                        continue;
                    }

                    similar_text(
                        $kata,
                        $bagian,
                        $persen
                    );

                    $terbaik = max(
                        $terbaik,
                        $persen
                    );
                }
            }

            if ($terbaik >= $threshold) {
                $skor[$id] = $terbaik;
            }
        }

        arsort($skor);

        return array_slice(
            array_keys($skor),
            0,
            $limit
        );
    }

    /**
     * Apakah query terlihat seperti pertanyaan produk?
     */
    private function terlihatSepertiProduk(string $q): bool
    {
        if ($this->mengandung(
            $q,
            [
                'produk',
                'barang',
                'kaos',
                'kemeja',
                'polo',
                'rompi',
                'seragam',
                'apparel',
                'kategori',
                'katalog',
            ]
        )) {
            return true;
        }

        /*
         * Kalau ada token yang dekat dengan nama produk,
         * fuzzy boleh berjalan.
         */
        $keywords = $this->keywords($q);

        if ($keywords->isEmpty()) {
            return false;
        }

        $indeks = $this->indeksProduk();

        foreach ($keywords as $keyword) {
            if (mb_strlen($keyword) < 4) {
                continue;
            }

            foreach ($indeks as $nama) {
                foreach (
                    preg_split('/\s+/', $nama) ?: []
                    as $bagian
                ) {
                    if (mb_strlen($bagian) < 4) {
                        continue;
                    }

                    similar_text(
                        $keyword,
                        $bagian,
                        $persen
                    );

                    if ($persen >= 82) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Apakah query menyebut nama produk yang benar-benar ada?
     */
    private function adaNamaProdukDiPertanyaan(
        string $q
    ): bool {
        $indeks = $this->indeksProduk();

        foreach ($indeks as $nama) {
            $namaNormal = $this->normalize($nama);

            if (
                $namaNormal !== ''
                && Str::contains(
                    $q,
                    $namaNormal
                )
            ) {
                return true;
            }

            $bagianNama = preg_split(
                '/\s+/',
                $namaNormal
            ) ?: [];

            foreach ($bagianNama as $bagian) {
                if (mb_strlen($bagian) < 4) {
                    continue;
                }

                if (
                    $this->mengandungKata(
                        $q,
                        [$bagian]
                    )
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Index produk.
     */
    private function indeksProduk(): array
    {
        return Cache::remember(
            'konvexa.chat.index.produk',
            (int) config(
                'konvexa.chat.cache_ttl',
                900
            ),
            fn () => Product::where(
                'is_active',
                true
            )
                ->pluck(
                    'name',
                    'id'
                )
                ->map(
                    fn ($nama) => Str::lower(
                        (string) $nama
                    )
                )
                ->all()
        );
    }

    /**
     * Index kategori.
     */
    private function indeksKategori(): Collection
    {
        return Cache::remember(
            'konvexa.chat.index.kategori',
            (int) config(
                'konvexa.chat.cache_ttl',
                900
            ),
            fn () => Product::with(
                'category:id,name'
            )
                ->where(
                    'is_active',
                    true
                )
                ->get()
                ->pluck(
                    'category.name'
                )
                ->filter()
                ->unique()
                ->sort()
                ->values()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | BAHASA
    |--------------------------------------------------------------------------
    */

    /**
     * Normalisasi teks.
     */
    private function normalize(string $teks): string
    {
        $teks = Str::lower($teks);

        $teks = preg_replace(
            '/[^\p{L}\p{N}\s\-]/u',
            ' ',
            $teks
        ) ?? $teks;

        $teks = preg_replace(
            '/\s+/',
            ' ',
            trim($teks)
        ) ?? trim($teks);

        /*
         * Sinonim dari config.
         */
        $sinonim = (array) config(
            'konvexa.sinonim',
            []
        );

        $kata = array_map(
            function ($k) use ($sinonim) {
                return $sinonim[$k] ?? $k;
            },
            explode(' ', $teks)
        );

        return implode(
            ' ',
            $kata
        );
    }

    /**
     * Ambil keyword yang benar-benar berguna untuk produk.
     */
    private function keywords(string $q): Collection
    {
        $stopwords = array_merge(
            (array) config(
                'konvexa.stopwords',
                []
            ),
            self::KATA_UMUM
        );

        $stopwords = array_map(
            fn ($word) => Str::lower(
                trim((string) $word)
            ),
            $stopwords
        );

        return collect(
            preg_split('/\s+/', trim($q)) ?: []
        )
            ->map(
                fn ($kata) => preg_replace(
                    '/[^\p{L}\p{N}\-]/u',
                    '',
                    $kata
                )
            )
            ->filter()
            ->reject(
                fn ($kata) => in_array(
                    $kata,
                    $stopwords,
                    true
                )
            )
            ->filter(
                fn ($kata) => mb_strlen($kata) >= 3
            )
            ->unique()
            ->values();
    }

    /**
     * Skor FAQ.
     */
    private function skorPattern(
        string $q,
        array $patterns
    ): int {
        $skor = 0;

        foreach ($patterns as $pattern) {
            if (! is_string($pattern)) {
                continue;
            }

            $pattern = $this->normalize(
                $pattern
            );

            if ($pattern === '') {
                continue;
            }

            if (! Str::contains(
                $q,
                $pattern
            )) {
                continue;
            }

            $jumlahKata = count(
                preg_split(
                    '/\s+/',
                    $pattern
                ) ?: []
            );

            /*
             * Frasa lebih panjang mendapatkan bobot lebih besar.
             */
            $skor += (
                $jumlahKata * 10
            ) + mb_strlen($pattern);
        }

        return $skor;
    }

    /**
     * Contains substring.
     */
    private function mengandung(
        string $q,
        array $frasa
    ): bool {
        foreach ($frasa as $item) {
            if (! is_string($item)) {
                continue;
            }

            if (Str::contains(
                $q,
                Str::lower($item)
            )) {
                return true;
            }
        }

        return false;
    }

    /**
     * Contains kata utuh.
     */
    private function mengandungKata(
        string $q,
        array $kataList
    ): bool {
        $kataDalamQ = preg_split(
            '/\s+/',
            trim($q)
        ) ?: [];

        foreach ($kataList as $target) {
            if (! is_string($target)) {
                continue;
            }

            $target = Str::lower(
                trim($target)
            );

            if ($target === '') {
                continue;
            }

            /*
             * Frasa:
             * "terima kasih"
             */
            if (Str::contains(
                $target,
                ' '
            )) {
                if (
                    Str::contains(
                        $q,
                        $target
                    )
                ) {
                    return true;
                }

                continue;
            }

            /*
             * Kata utuh:
             * "hi"
             * tidak boleh match "shirt".
             */
            if (
                in_array(
                    $target,
                    $kataDalamQ,
                    true
                )
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Apakah pertanyaan tentang harga.
     */
    private function tanyaHarga(
        string $q
    ): bool {
        return $this->mengandung(
            $q,
            [
                'harga',
                'berapa',
                'price',
                'biaya',
                'tarif',
                'banderol',
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SESSION / CONTEXT
    |--------------------------------------------------------------------------
    */

    private function konteks(): array
    {
        return session(
            self::SESSION_KEY,
            [
                'produk' => [],
                'riwayat' => [],
            ]
        );
    }

    private function ingat(
        string $peran,
        string $teks,
        array $produkIds = []
    ): void {
        $konteks = $this->konteks();

        $max = (int) config(
            'konvexa.chat.max_history',
            12
        );

        $konteks['riwayat'][] = [
            'peran' => $peran,
            'teks' => $teks,
        ];

        $konteks['riwayat'] = array_slice(
            $konteks['riwayat'],
            -$max
        );

        /*
         * Context produk hanya diganti ketika ada hasil produk baru.
         */
        if (! empty($produkIds)) {
            $konteks['produk'] = array_values(
                array_unique($produkIds)
            );
        }

        session([
            self::SESSION_KEY => $konteks,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | RESPONSE
    |--------------------------------------------------------------------------
    */

    /**
     * Membuat response produk.
     */
    private function balasProduk(
        Collection $produk,
        string $judul
    ): JsonResponse {
        /*
         * Hilangkan duplicate nama sebelum disimpan ke context.
         */
        $produk = $produk
            ->unique(
                fn ($p) => $this->normalize(
                    (string) $p->name
                )
            )
            ->values();

        $this->ingat(
            'bot',
            $judul,
            $produk
                ->pluck('id')
                ->all()
        );

        $teks = $judul
            . "\n\n"
            . $produk
                ->map(
                    fn ($p) => $this->barisProduk($p)
                )
                ->implode("\n");

        $maxProduk = (int) config(
            'konvexa.chat.max_produk',
            5
        );

        if ($produk->count() >= $maxProduk) {
            $sisa = "\n\nItu sebagian produk yang paling relevan. "
                . "Sebutkan nama produk tertentu jika ingin melihat detailnya.";
        } else {
            $sisa = "\n\nSebutkan nama produk tertentu jika ingin saya bantu cek detailnya.";
        }

        return response()->json([
            'success' => true,
            'type' => 'products',
            'reply' => $teks . $sisa,
            'products' => $produk
                ->map(
                    fn ($p) => $this->kartuProduk($p)
                )
                ->values()
                ->all(),
            'suggestions' => [
                'Bahan apa saja?',
                'Minimal order berapa?',
                'Berapa lama produksinya?',
            ],
            'actions' => [
                $this->tombolWhatsapp(
                    'Pesan lewat WhatsApp'
                ),
            ],
        ]);
    }

    /**
     * Format satu produk.
     */
    private function barisProduk(
        Product $p
    ): string {
        $baris = "• {$p->name}";

        if ($p->category?->name) {
            $baris .= " ({$p->category->name})";
        }

        /*
         * formatted_price biasanya accessor dari Product.
         * Kalau tidak ada, fallback ke price.
         */
        if (
            isset($p->formatted_price)
            && $p->formatted_price
        ) {
            $harga = $p->formatted_price;
        } elseif (
            isset($p->price)
            && is_numeric($p->price)
        ) {
            $harga = 'Rp'
                . number_format(
                    (float) $p->price,
                    0,
                    ',',
                    '.'
                );
        } else {
            $harga = 'Harga belum tersedia';
        }

        $baris .= " — {$harga}";

        return $baris;
    }

    /**
     * Card produk untuk frontend.
     */
    private function kartuProduk(
        Product $p
    ): array {
        if (
            isset($p->formatted_price)
            && $p->formatted_price
        ) {
            $harga = $p->formatted_price;
        } elseif (
            isset($p->price)
            && is_numeric($p->price)
        ) {
            $harga = 'Rp'
                . number_format(
                    (float) $p->price,
                    0,
                    ',',
                    '.'
                );
        } else {
            $harga = 'Harga belum tersedia';
        }

        return [
            'id' => $p->id,

            'nama' => $p->name,

            'kategori' => $p->category?->name,

            'harga' => $harga,

            'gambar' => $p->image
                ? asset(
                    'storage/' . $p->image
                )
                : 'https://placehold.co/120x150',

            'url' => $this->urlProduk($p),
        ];
    }

    /**
     * URL produk.
     */
    private function urlProduk(
        Product $p
    ): ?string {
        if (! Route::has(
            'produk.index'
        )) {
            return null;
        }

        return $p->category?->slug
            ? route(
                'produk.index',
                [
                    'category' => $p->category->slug,
                ]
            )
            : route(
                'produk.index'
            );
    }

    /**
     * Tombol WhatsApp.
     */
    private function tombolWhatsapp(
        string $label = 'Hubungi WhatsApp',
        ?string $pesan = null
    ): array {
        $nomor = config(
            'konvexa.kontak.whatsapp'
        );

        $pesan ??=
            'Halo Konvexa, saya ingin bertanya tentang pemesanan.';

        /*
         * Bersihkan nomor:
         * +62 895-4111-46879
         * menjadi:
         * 62895411146879
         */
        $nomor = preg_replace(
            '/\D+/',
            '',
            (string) $nomor
        );

        return [
            'label' => $label,

            'url' => 'https://wa.me/'
                . $nomor
                . '?text='
                . rawurlencode($pesan),

            'style' => 'primary',
        ];
    }

    /**
     * Saran awal.
     */
    private function saranAwal(): array
    {
        return [
            'Lihat kategori produk',
            'Minimal order berapa?',
            'Berapa lama produksinya?',
        ];
    }

    /**
     * Response text standar.
     */
    private function reply(
        string $teks,
        array $extra = [],
        int $status = 200
    ): JsonResponse {
        if ($status === 200) {
            $this->ingat(
                'bot',
                $teks
            );
        }

        return response()->json(
            array_merge(
                [
                    'success' => $status === 200,
                    'type' => 'text',
                    'reply' => $teks,
                    'products' => [],
                    'suggestions' => [],
                    'actions' => [],
                ],
                $extra
            ),
            $status
        );
    }
}