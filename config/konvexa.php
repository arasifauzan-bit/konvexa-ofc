<?php

/*
|--------------------------------------------------------------------------
| Konvexa — Data Perusahaan & Basis Pengetahuan Chatbot
|--------------------------------------------------------------------------
|
| Semua jawaban statis chatbot ada di sini, bukan di controller.
| Ubah isinya tanpa menyentuh kode. Nilai bertanda [SESUAIKAN] wajib
| diganti dengan data asli Konvexa sebelum dipakai di produksi.
|
*/

return [

    'perusahaan' => [
        'nama'       => 'Konvexa Official',
        'berdiri'    => 2025,
        'induk'      => 'Ar Rasi Konveksi',
        'produk'     => ['kemeja', 'kaos', 'polo', 'rompi'],
        'deskripsi'  => 'Konvexa didirikan pada 2025 dan berfokus pada produksi kemeja, kaos, polo, dan rompi. Kami melayani kebutuhan custom dari order kecil hingga skala besar, dan berada di bawah satu naungan produksi dengan Ar Rasi Konveksi.',
    ],

    'kontak' => [
        'whatsapp'        => '62895411146879',
        'whatsapp_tampil' => '+62 895-4111-46879',
        'instagram'       => '@konvexaofficial',
        'instagram_url'   => 'https://www.instagram.com/konvexaofficial',
        'tiktok'          => '@konvexa.official',
        'tiktok_url'      => 'https://tiktok.com/@konvexa.official',
        'email'           => 'konvexaofficial@gmail.com',
        'alamat'          => 'Yogyakarta, Indonesia', // [SESUAIKAN] alamat workshop lengkap
        'jam_operasional' => 'Senin–Sabtu, 08.00–17.00 WIB', // [SESUAIKAN]
    ],

    /*
    |--------------------------------------------------------------------------
    | FAQ
    |--------------------------------------------------------------------------
    |
    | key       : nama intent, dipakai controller
    | patterns  : frasa pemicu. Frasa multi-kata otomatis diberi bobot lebih
    |             tinggi daripada kata tunggal.
    | reply     : jawaban yang dikirim ke pengguna
    | follow_up : saran pertanyaan lanjutan (chip di bawah balasan)
    |
    */

    'faq' => [

        'minimum_order' => [
            'patterns' => [
                'minimal order', 'minimum order', 'min order', 'moq',
                'minimal berapa', 'minimal pesan', 'satuan', 'lusinan',
                'bisa satuan', 'order sedikit', 'jumlah minimal',
            ],
            // [SESUAIKAN] angka minimum order sebenarnya
            'reply' => "Minimum order Konvexa adalah 12 pcs per desain untuk kaos dan polo, serta 6 pcs untuk kemeja dan rompi.\n\nUntuk sablon satuan atau custom dalam jumlah kecil, masih bisa kami bantu dengan penyesuaian harga. Silakan konsultasi lewat WhatsApp.",
            'follow_up' => ['Berapa lama produksinya?', 'Bahan apa saja yang tersedia?', 'Cara pesan bagaimana?'],
        ],

        'bahan' => [
            'patterns' => [
                'bahan', 'material', 'kain', 'cotton', 'katun', 'combed',
                'drill', 'fleece', 'american drill', 'japan drill',
                'bahan apa', 'jenis kain', 'kualitas bahan',
            ],
            // [SESUAIKAN] daftar bahan yang benar-benar tersedia
            'reply' => "Bahan yang tersedia di Konvexa:\n\n• Kaos — Cotton Combed 20s, 24s, 30s\n• Polo — Lacoste Cotton, Lacoste CVC\n• Kemeja — American Drill, Japan Drill, Oxford\n• Rompi — Drill, Canvas, Taslan\n\nKami bisa mengirim sampel bahan sebelum produksi agar Anda yakin dengan pilihannya.",
            'follow_up' => ['Minta katalog', 'Berapa lama produksinya?', 'Hubungi WhatsApp'],
        ],

        'durasi' => [
            'patterns' => [
                'berapa lama', 'lama produksi', 'estimasi waktu', 'waktu pengerjaan',
                'kapan jadi', 'kapan selesai', 'durasi', 'lead time',
                'bisa cepat', 'express', 'buru buru', 'mendesak',
            ],
            // [SESUAIKAN] estimasi durasi asli
            'reply' => "Estimasi waktu produksi:\n\n• 12–50 pcs — 7–10 hari kerja\n• 51–200 pcs — 10–14 hari kerja\n• Di atas 200 pcs — dijadwalkan setelah konfirmasi\n\nHitungan hari dimulai setelah desain final disetujui dan DP masuk. Layanan express tersedia dengan biaya tambahan.",
            'follow_up' => ['Cara pesan bagaimana?', 'Metode pembayaran?', 'Hubungi WhatsApp'],
        ],

        'pembayaran' => [
            'patterns' => [
                'pembayaran', 'bayar', 'dp', 'uang muka', 'transfer',
                'cicil', 'tempo', 'cod', 'rekening', 'metode bayar',
                'bisa cod', 'pelunasan',
            ],
            // [SESUAIKAN] skema pembayaran asli
            'reply' => "Skema pembayaran Konvexa:\n\n• DP 50% saat order dikonfirmasi\n• Pelunasan 50% setelah produksi selesai, sebelum pengiriman\n\nPembayaran lewat transfer bank atau e-wallet. Untuk order instansi dan korporat, kami melayani pembayaran termin dengan invoice resmi.",
            'follow_up' => ['Minimal order berapa?', 'Berapa lama produksinya?', 'Hubungi WhatsApp'],
        ],

        'pengiriman' => [
            'patterns' => [
                'pengiriman', 'kirim', 'ongkir', 'ekspedisi', 'kurir',
                'luar kota', 'luar pulau', 'ambil sendiri', 'pickup',
                'dikirim kemana', 'bisa kirim',
            ],
            'reply' => "Kami mengirim ke seluruh Indonesia lewat JNE, J&T, SiCepat, dan kargo untuk order besar.\n\nOngkir dihitung dari berat total dan kota tujuan. Untuk area Yogyakarta dan sekitarnya, pengambilan langsung di workshop juga bisa.",
            'follow_up' => ['Di mana lokasinya?', 'Metode pembayaran?', 'Hubungi WhatsApp'],
        ],

        'ukuran' => [
            'patterns' => [
                'ukuran', 'size', 'size chart', 'tabel ukuran', 'jumbo',
                'big size', 'ukuran anak', 'xxl', 'xxxl', 'lingkar dada',
            ],
            'reply' => "Ukuran tersedia dari S sampai XXXL, termasuk ukuran anak.\n\nKami juga melayani ukuran custom sesuai pola Anda, dan bisa mengirim size chart lengkap beserta detail lingkar dada dan panjang badan lewat WhatsApp.",
            'follow_up' => ['Minta size chart', 'Bahan apa saja?', 'Hubungi WhatsApp'],
        ],

        'desain' => [
            'patterns' => [
                'desain', 'design', 'mockup', 'logo', 'sablon', 'bordir',
                'dtf', 'plastisol', 'sublim', 'file desain', 'format file',
                'belum punya desain', 'dibuatkan desain', 'cdr', 'ai', 'psd',
            ],
            'reply' => "Kami menerima file desain dalam format CDR, AI, PSD, atau PNG resolusi tinggi.\n\nBelum punya desain? Tim kami bisa membantu membuatkannya. Sebelum produksi, Anda akan menerima mockup digital untuk disetujui terlebih dahulu.\n\nTeknik yang tersedia: sablon plastisol, DTF, sublimasi, dan bordir komputer.",
            'follow_up' => ['Berapa lama produksinya?', 'Minimal order berapa?', 'Hubungi WhatsApp'],
        ],

        'garansi' => [
            'patterns' => [
                'garansi', 'retur', 'komplain', 'revisi', 'salah ukuran',
                'cacat', 'reject', 'tukar', 'jaminan', 'kalau tidak sesuai',
            ],
            'reply' => "Setiap produk melewati quality control sebelum dikirim.\n\nJika ada cacat produksi atau ketidaksesuaian dengan mockup yang telah disetujui, kami ganti tanpa biaya tambahan. Laporkan maksimal 3 hari setelah barang diterima, disertai foto.",
            'follow_up' => ['Cara pesan bagaimana?', 'Metode pembayaran?', 'Hubungi WhatsApp'],
        ],

        'lokasi' => [
            'patterns' => [
                'lokasi', 'alamat', 'dimana', 'di mana', 'workshop',
                'pabrik', 'kantor', 'maps', 'bisa datang', 'survey tempat',
            ],
            'reply' => "Workshop Konvexa berada di Yogyakarta, Indonesia.\n\nAnda dipersilakan berkunjung untuk melihat proses produksi dan sampel bahan secara langsung. Kabari dulu lewat WhatsApp agar kami siapkan.", // [SESUAIKAN]
            'follow_up' => ['Jam buka?', 'Hubungi WhatsApp'],
        ],

        'jam' => [
            'patterns' => [
                'jam buka', 'jam operasional', 'jam kerja', 'buka jam',
                'tutup jam', 'hari apa saja', 'buka minggu', 'weekend',
            ],
            'reply' => "Konvexa buka Senin–Sabtu pukul 08.00–17.00 WIB. Minggu dan hari libur nasional tutup.\n\nPesan WhatsApp di luar jam tersebut tetap kami balas pada jam kerja berikutnya.", // [SESUAIKAN]
            'follow_up' => ['Di mana lokasinya?', 'Hubungi WhatsApp'],
        ],

        'promo' => [
            'patterns' => [
                'promo', 'diskon', 'potongan', 'penawaran', 'murah',
                'bisa nego', 'nego harga', 'harga grosir', 'reseller',
                'kerja sama', 'partnership',
            ],
            'reply' => "Harga kami turun otomatis seiring bertambahnya jumlah order — semakin banyak, semakin murah per pcs.\n\nUntuk reseller, instansi, dan order rutin, tersedia harga khusus. Sampaikan estimasi jumlah dan jenis produknya lewat WhatsApp agar kami buatkan penawaran.",
            'follow_up' => ['Lihat produk terlaris', 'Minimal order berapa?', 'Hubungi WhatsApp'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Normalisasi bahasa: singkatan, slang, dan typo umum
    |--------------------------------------------------------------------------
    */

    'sinonim' => [
        'gmn' => 'bagaimana', 'gimana' => 'bagaimana', 'bgmn' => 'bagaimana',
        'brp' => 'berapa', 'brpa' => 'berapa', 'brapa' => 'berapa',
        'hrg' => 'harga', 'hrga' => 'harga', 'harag' => 'harga', 'hargaa' => 'harga',
        'sy' => 'saya', 'gw' => 'saya', 'gue' => 'saya', 'aq' => 'saya', 'ane' => 'saya',
        'bs' => 'bisa', 'bsa' => 'bisa', 'dpt' => 'dapat',
        'tq' => 'terima kasih', 'thx' => 'terima kasih', 'thanks' => 'terima kasih',
        'makasih' => 'terima kasih', 'mksh' => 'terima kasih', 'nuhun' => 'terima kasih',
        'wa' => 'whatsapp', 'ig' => 'instagram', 'no' => 'nomor',
        'pcs' => 'pieces', 'lsn' => 'lusin',
        'kaos' => 'kaos', 'kaus' => 'kaos', 'tshirt' => 'kaos', 't-shirt' => 'kaos',
        'keos' => 'kaos', 'kemeja' => 'kemeja', 'kmeja' => 'kemeja',
        'seragam' => 'seragam', 'srgm' => 'seragam',
        'blh' => 'boleh', 'sdh' => 'sudah', 'udh' => 'sudah', 'blm' => 'belum',
        'yg' => 'yang', 'dgn' => 'dengan', 'utk' => 'untuk', 'tp' => 'tapi',
        'jd' => 'jadi', 'kl' => 'kalau', 'klo' => 'kalau', 'klau' => 'kalau',
        'mnt' => 'minta', 'tlg' => 'tolong', 'pls' => 'tolong',
        'cust' => 'custom', 'kustom' => 'custom',
        'prod' => 'produksi', 'produk' => 'produk',
        'ongkos' => 'ongkir', 'ongkoskirim' => 'ongkir',
    ],

    'stopwords' => [
        'yang', 'dan', 'atau', 'di', 'ke', 'dari', 'untuk', 'dengan', 'pada',
        'ada', 'apa', 'apakah', 'saya', 'aku', 'kamu', 'anda', 'kami',
        'mau', 'ingin', 'pengen', 'cari', 'carikan', 'tolong', 'mohon',
        'dong', 'nih', 'sih', 'kok', 'deh', 'ya', 'yah', 'gitu',
        'itu', 'ini', 'tuh', 'produk', 'barang', 'berapa', 'harga',
        'harganya', 'kah', 'ga', 'gak', 'nggak', 'tidak', 'bukan',
        'punya', 'pun', 'bisa', 'boleh', 'adalah', 'jadi', 'kalau',
        'pesan', 'order', 'memesan', 'pemesanan', 'beli', 'membeli',
        'lihat', 'info', 'informasi', 'detail', 'tentang', 'soal',
        'juga', 'saja', 'aja', 'lagi', 'masih', 'sudah', 'belum',
        'cara', 'bagaimana', 'kenapa', 'mengapa', 'dimana', 'kapan',
        'siapa', 'begini', 'begitu', 'seperti',
    ],

    'chat' => [
        'max_length'       => 500,
        'max_history'      => 12,   // pesan yang diingat per sesi
        'max_produk'       => 5,    // hasil produk per balasan
        'fuzzy_threshold'  => 72,   // 0–100, makin tinggi makin ketat
        'cache_ttl'        => 900,  // detik, untuk indeks nama produk
    ],
];