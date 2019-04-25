<?php

namespace App\Command;

use App\Entity\Payment;

/**
 * Class ApprovePaymentCommand
 * @package App\Command
 */
class ApprovePaymentCommand
{
    /**
     * @var Payment
     */
    private $payment;

    /**
     * ApprovePaymentCommand constructor.
     * @param Payment $payment
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * @return Payment
     */
    public function getPayment(): Payment
    {
        return $this->payment;
    }

}