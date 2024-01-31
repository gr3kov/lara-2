<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    public function payment($userId, $orderId, $price, $noReceipt);
    public function callback(Request $request);
}
