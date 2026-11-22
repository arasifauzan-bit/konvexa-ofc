<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderTracking extends Model
{
    public const STATUS_OPTIONS = [
        'antrian' => 'Dalam antrean proses',
        'pembelian_bahan' => 'Pembelian bahan',
        'produksi' => 'Proses Produksi (Potong, Jahit, Bordir/Sablon)',
        'finishing' => 'Finishing',
        'dapat_diambil' => 'Dapat diambil',
        'selesai' => 'Selesai',
    ];

    protected $fillable = [
        'order_number',
        'customer_name',
        'status',
        'progress_note',
    ];

    public function setCustomerNameAttribute(?string $value): void
    {
        $this->attributes['customer_name'] = $value === null ? null : Str::upper(trim($value));
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_OPTIONS[$this->status] ?? self::STATUS_OPTIONS['antrian'];
    }
}
