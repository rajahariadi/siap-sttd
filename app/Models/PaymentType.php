<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class, 'payment_type_id');
    }
}
