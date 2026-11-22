<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderTracking extends Model
{
    public const STATUS_OPTIONS = [
        'antrian' => 'Dalam antrean proses',
        'pembelian_bahan' => 'Pembelian bahan',
        'jahit' => 'Jahit',
        'bordir' => 'Bordir',
        'finishing' => 'Finishing',
        'dapat_diambil' => 'Dapat diambil',
    ];

    protected $fillable = [
        'order_number',
        'customer_name',
        'status',
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
