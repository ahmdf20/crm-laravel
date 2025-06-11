<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'id',
        'trx',
        'column_id',
        'product_id',
        'contact_id',
        'current_price',
        'qty',
        'grand_total'
    ];

    protected static function booted()
    {
        static::creating(function($transaction) {
            if (empty($transaction->trx)) {
                $transaction->trx = self::generateTrxCode();
            }
        });
    }

    protected static function generateTrxCode(): string
    {
        // Format: TRX + yymmddHHMM + 2 digit random → TRX250608153012
        return 'TRX' . now()->format('ymdHi') . rand(10, 99);
    }

    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }
}
