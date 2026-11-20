<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function forWebsite(): array
    {
        $defaults = [
            'hero_badge' => 'Konveksi & Produksi Pakaian',
            'hero_title' => 'Solusi Kebutuhan',
            'hero_highlight' => 'Seragam Mu !',
            'hero_description' => 'Kami Bantu Wujudkan Seragam Yang Nyaman Dipakai Dan Mencerminkan Karakter Tim Anda.',
            'about_intro' => 'Didirikan pada 2025, Konvexa hadir sebagai konveksi yang fokus pada produksi kemeja, kaos, polo, dan rompi. Kami melayani berbagai kebutuhan custom, dari order kecil hingga skala besar, dengan standar kualitas yang konsisten.',
            'about_commitment' => 'Kami berkomitmen menghadirkan produk apparel yang nyaman dipakai, tahan lama, dan sesuai dengan karakter setiap brand.',
            'location_name' => 'KONVEXA APPAREL',
            'location_address' => 'Jl. Kersan No.12, Bekelan, Tirtonirmolo, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55181',
            'whatsapp_phone' => '+62 895-4111-46879',
            'contact_email' => 'konvexaapparel@gmail.com',
            'instagram_url' => 'https://www.instagram.com/konvexaapparel?stkn=NDZ0NWdqdjlmdmVi&utm_source=qr',
            'instagram_handle' => '@konvexaapparel',
            'tiktok_url' => 'https://www.tiktok.com/@konvexaapparel',
            'tiktok_handle' => '@konvexaapparel',
        ];

        return array_replace($defaults, static::query()->pluck('value', 'key')->all());
    }
}
