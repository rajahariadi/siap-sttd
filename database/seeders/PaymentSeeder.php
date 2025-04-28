<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $paidBills = Bill::where('status', 'paid')
            ->with(['student.user'])
            ->get();

        foreach ($paidBills as $bill) {
            $paymentTime = now()->subDays(rand(1, 30))->setTime(rand(8, 16), rand(0, 59));
            $transactionId = 'SIAP-' . $bill->student->user->nim . '-' . $paymentTime->format('H:i');

            Payment::create([
                'bill_id' => $bill->id,
                'transaction_id' => $transactionId,
                'payment_method' => $this->getRandomPaymentMethod(),
                'amount' => $bill->amount,
                'status' => 'success',
                'midtrans_response' => $this->generateMidtransResponse($bill, $paymentTime),
                'created_at' => $paymentTime,
                'updated_at' => now()
            ]);
        }

        // Pembayaran pending (30% dari total bill)
        $pendingBills = Bill::where('status', 'pending')
            ->with(['student.user'])
            ->inRandomOrder()
            ->limit(Bill::count() * 0.3)
            ->get();

        foreach ($pendingBills as $bill) {
            $paymentTime = now()->subDays(rand(0, 3))->setTime(rand(8, 16), rand(0, 59));
            $transactionId = 'SIAP-' . $bill->student->user->nim . '-' . $paymentTime->format('H:i');

            Payment::create([
                'bill_id' => $bill->id,
                'transaction_id' => $transactionId,
                'payment_method' => null,
                'amount' => $bill->amount,
                'status' => 'pending',
                'midtrans_response' => null,
                'created_at' => $paymentTime,
                'updated_at' => now()
            ]);
        }

        $this->command->info('Berhasil membuat ' . ($paidBills->count() + $pendingBills->count()) . ' pembayaran');
    }

    private function getRandomPaymentMethod()
    {
        $methods = ['bank_transfer', 'credit_card', 'gopay', 'shopeepay', 'qris'];
        return $methods[array_rand($methods)];
    }

    private function generateMidtransResponse($bill, $paymentTime)
    {
        return json_encode([
            'status_code' => '200',
            'status_message' => 'Success, transaction is successful',
            'transaction_id' => 'MID-' . strtoupper(uniqid()),
            'order_id' => 'ORDER-' . $bill->id,
            'gross_amount' => $bill->amount,
            'payment_type' => 'bank_transfer',
            'transaction_time' => $paymentTime->format('Y-m-d H:i:s'),
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
            'bank' => 'bni',
            'va_number' => '988' . rand(100000000, 999999999)
        ]);
    }
}
