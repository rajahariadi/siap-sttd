<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'transaction_id',
        'payment_method',
        'amount',
        'status',
        'midtrans_response'
    ];

    public function bill(): BelongsTo

    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }
}
