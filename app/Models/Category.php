<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;


class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

public function products() { return $this->hasMany(Product::class); }

public function getImageUrlAttribute(): string
{
    if (! $this->image) {
        return 'https://placehold.co/600x750';
    }

    return Storage::disk(config('filament.default_filesystem_disk', 'public'))->url($this->image);
}

}