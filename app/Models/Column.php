<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Column extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'name'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
