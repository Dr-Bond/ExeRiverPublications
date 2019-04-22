<?php

namespace App\CommandHandler;

use App\Command\ApprovePaymentCommand;
use App\Helper\Orm;

class ApprovePaymentCommandHandler
{
    private $orm;

    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    public function __invoke(ApprovePaymentCommand $command)
    {
        $orm = $this->orm;
        $payment = $command->getPayment();
        $payment->approvePayment();
        $orm->persist($payment);
        $orm->flush();
    }
}