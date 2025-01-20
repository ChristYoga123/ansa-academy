<?php

namespace App\Services;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Transaksi;
use App\Models\MentoringMentee;
use Illuminate\Support\Facades\Log;
use App\Contracts\PaymentServiceInterface;
use App\Models\KelasAnsaMentee;
use App\Models\ProofreadingMentee;

class MidtransPaymentService implements PaymentServiceInterface
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVERKEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    public function processPayment(Transaksi $transaksi): string
    {
        $itemDetails = [
            'id' => $transaksi->order_id,
            'price' => $transaksi->total_harga,
            'quantity' => 1,
            'name' => "Pembayaran untuk transaksi {$transaksi->order_id}",
        ];

        $customerDetails = [
            'first_name' => $transaksi->mentee->name,
            'email' => $transaksi->mentee->email,
        ];

        $midtransParam = [
            'transaction_details' => [
                'order_id' => $transaksi->order_id,
                'gross_amount' => $transaksi->total_harga,
            ],
            'item_details' => [$itemDetails],
            'customer_details' => $customerDetails,
        ];

        try {
            return Snap::getSnapToken($midtransParam);
        } catch(Exception $e) {
            Log::error('Midtrans payment error: ' . $e->getMessage());
            return false;
        }
    }
}
