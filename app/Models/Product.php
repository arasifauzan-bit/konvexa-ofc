<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'price_old',
        'image',
        'rating',
        'sold',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'price'       => 'decimal:0',
        'price_old'   => 'decimal:0',
        'rating'      => 'decimal:1',
        'sold'        => 'integer',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'order'       => 'integer',
    ];

    /**
     * Bersihkan indeks cache milik chatbot setiap kali produk
     * dibuat, diubah, atau dihapus, supaya bot tidak pernah
     * menyebut produk yang sudah tidak aktif atau harga lama.
     */
    protected static function booted(): void
    {
        $bersihkan = function (): void {
            Cache::forget('konvexa.chat.index.produk');
            Cache::forget('konvexa.chat.index.kategori');
        };

        static::saved($bersihkan);
        static::deleted($bersihkan);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Hanya produk yang tampil di halaman publik dan chatbot.
     * Pakai: Product::active()->get();
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Produk unggulan yang aktif, diurutkan sesuai kolom `order`.
     * Pakai: Product::active()->featured()->get();
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true)->orderBy('order');
    }

    /**
     * Apakah produk sedang diskon (price_old lebih tinggi dari price).
     */
    public function getIsDiscountedAttribute(): bool
    {
        return (float) $this->price_old > (float) $this->price;
    }

    /**
     * Harga terformat, dipakai di Blade dan balasan chatbot
     * agar format "Rp1.234.567" tidak diulang di banyak tempat.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp' . number_format((float) $this->price, 0, ',', '.');
    }

    public function getFormattedPriceOldAttribute(): ?string
    {
        return $this->is_discounted
            ? 'Rp' . number_format((float) $this->price_old, 0, ',', '.')
            : null;
    }

    public function getImageUrlAttribute(): string
{
    if (! $this->image) {
        return 'https://placehold.co/600x750';
    }

    return Storage::disk(config('filament.default_filesystem_disk', 'public'))->url($this->image);
}

}