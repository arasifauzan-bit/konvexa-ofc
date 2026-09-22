<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'nama' => 'Classic Leather Watch',
                'kategori' => 'Aksesoris',
                'harga' => 1299000,
                'harga_coret' => 1899000,
                'rating' => 4.9,
                'terjual' => '1.2k',
                'gambar' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&q=80',
                'is_featured' => true,
            ],
            [
                'nama' => 'Minimalist Sunglasses',
                'kategori' => 'Aksesoris',
                'harga' => 459000,
                'harga_coret' => 699000,
                'rating' => 4.8,
                'terjual' => '856',
                'gambar' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=600&q=80',
                'is_featured' => true,
            ],
            [
                'nama' => 'Everyday Sneakers',
                'kategori' => 'Fashion',
                'harga' => 899000,
                'harga_coret' => 1299000,
                'rating' => 4.7,
                'terjual' => '2.1k',
                'gambar' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80',
                'is_featured' => true,
            ],
            [
                'nama' => 'Wireless Headphones',
                'kategori' => 'Elektronik',
                'harga' => 1599000,
                'harga_coret' => 2199000,
                'rating' => 4.9,
                'terjual' => '3.4k',
                'gambar' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&q=80',
                'is_featured' => true,
            ],
            [
                'nama' => 'Organic Cotton Shirt',
                'kategori' => 'Fashion',
                'harga' => 349000,
                'harga_coret' => 499000,
                'rating' => 4.6,
                'terjual' => '640',
                'gambar' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=600&q=80',
                'is_featured' => false,
            ],
            [
                'nama' => 'Ceramic Table Lamp',
                'kategori' => 'Rumah',
                'harga' => 679000,
                'harga_coret' => 899000,
                'rating' => 4.8,
                'terjual' => '312',
                'gambar' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=600&q=80',
                'is_featured' => false,
            ],
            [
                'nama' => 'Hydrating Face Serum',
                'kategori' => 'Beauty',
                'harga' => 289000,
                'harga_coret' => 389000,
                'rating' => 4.9,
                'terjual' => '1.8k',
                'gambar' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=600&q=80',
                'is_featured' => false,
            ],
            [
                'nama' => 'Minimal Desk Journal',
                'kategori' => 'Gaya Hidup',
                'harga' => 159000,
                'harga_coret' => 229000,
                'rating' => 4.5,
                'terjual' => '421',
                'gambar' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=600&q=80',
                'is_featured' => false,
            ],
            [
                'nama' => 'Premium Polo Shirt',
                'kategori' => 'Fashion',
                'harga' => 189000,
                'harga_coret' => 279000,
                'rating' => 4.7,
                'terjual' => '980',
                'gambar' => 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=600&q=80',
                'is_featured' => false,
            ],
            [
                'nama' => 'Crewneck Sweatshirt',
                'kategori' => 'Fashion',
                'harga' => 249000,
                'harga_coret' => 349000,
                'rating' => 4.8,
                'terjual' => '1.1k',
                'gambar' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=600&q=80',
                'is_featured' => false,
            ],
            [
                'nama' => 'Canvas Tote Bag',
                'kategori' => 'Aksesoris',
                'harga' => 129000,
                'harga_coret' => 189000,
                'rating' => 4.6,
                'terjual' => '720',
                'gambar' => 'https://images.unsplash.com/photo-1590874103328-eac38a67437a?w=600&q=80',
                'is_featured' => false,
            ],
            [
                'nama' => 'Minimal Cap',
                'kategori' => 'Aksesoris',
                'harga' => 99000,
                'harga_coret' => 149000,
                'rating' => 4.5,
                'terjual' => '540',
                'gambar' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=600&q=80',
                'is_featured' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}