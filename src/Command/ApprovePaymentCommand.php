<?php

namespace App\Command;


use App\Entity\Payment;

class ApprovePaymentCommand
{
    private $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function getPayment(): Payment
    {
        return $this->payment;
    }

}