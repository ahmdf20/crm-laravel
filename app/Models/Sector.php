<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sector extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'name',
        'bg_color',
        'text_color'
    ];

    protected static function booted()
    {
        static::creating(function ($sector) {
            if (empty($sector->bg_color) || empty($sector->text_color)) {
                [$bg, $text] = self::getRandomColorPair();
                $sector->bg_color = $bg;
                $sector->text_color = $text;
            }
        });
    }

    protected static function getRandomColorPair(): array
    {
        // 5 pilihan warna Tailwind + teks kontras
        $colorPairs = [
            ['bg-blue-600', 'text-white'],
            ['bg-green-600', 'text-white'],
            ['bg-yellow-400', 'text-black'],
            ['bg-red-600', 'text-white'],
            ['bg-purple-600', 'text-white'],
        ];

        return $colorPairs[array_rand($colorPairs)];
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
