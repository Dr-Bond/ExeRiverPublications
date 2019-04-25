<?php

namespace App\CommandHandler;

use App\Command\ApprovePaymentCommand;
use App\Helper\Orm;

/**
 * Class ApprovePaymentCommandHandler
 * @package App\CommandHandler
 */
class ApprovePaymentCommandHandler
{
    /**
     * @var Orm
     */
    private $orm;

    /**
     * ApprovePaymentCommandHandler constructor.
     * @param Orm $orm
     */
    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    /**
     * @param ApprovePaymentCommand $command
     * Calls the approvePayment function to approve payments.
     */
    public function __invoke(ApprovePaymentCommand $command)
    {
        $orm = $this->orm;
        $payment = $command->getPayment();
        $payment->approvePayment();
        $orm->persist($payment);
        $orm->flush();
    }
}