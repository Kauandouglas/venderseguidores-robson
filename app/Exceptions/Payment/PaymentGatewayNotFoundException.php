<?php

namespace App\Exceptions\Payment;

use Exception;

class PaymentGatewayNotFoundException extends Exception
{
    protected $message = 'Payment gateway not found.';
}
