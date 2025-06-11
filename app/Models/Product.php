<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected static function booted()
    {
        static::creating(function($product) {
            $product->slug = Str::slug($product->name);
        });

        static::updating(function($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
