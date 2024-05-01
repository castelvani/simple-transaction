<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $relations = [
        'payer.wallet',
        'payee.wallet',
    ];

    protected $fillable = [
        'payer_id',
        'payee_id',
        'value',
        'status'
    ];

    // Relations
    public function payer(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'payer_id');
    }

    public function payee(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'payee_id');
    }
}
