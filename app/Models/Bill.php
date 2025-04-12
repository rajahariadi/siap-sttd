<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'payment_type_id',
        'amount',
        'due_date',
        'status'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function payment_type(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'bill_id');
    }

    public static function boot()
    {
        parent::boot();

        static::retrieved(function ($bill) {
            if ($bill->status === 'pending' && Carbon::now()->gt(Carbon::parse($bill->due_date))) {
                $bill->status = 'expired';
                $bill->save();

                // Cek apakah sudah ada payment
                if ($bill->payment) {
                    // Jika ada payment dan status-nya pending, update ke failed
                    if ($bill->payment->status === 'pending') {
                        $bill->payment->update(['status' => 'failed']);
                    }
                } else {
                    // Jika belum ada payment, buat satu entry payment otomatis
                    Payment::create([
                        'bill_id'         => $bill->id,
                        'amount'          => $bill->amount,
                        'status'          => 'failed',
                    ]);
                }
            }
        });
    }
}
