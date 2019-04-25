<?php

namespace App\Controller;

use App\Command\ApprovePaymentCommand;
use App\Entity\Book;
use App\Entity\Payment;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PaymentController
 * @package App\Controller
 */
class PaymentController extends BaseController
{
    /**
     * @Route("/payments/{book}", name="payments")
     * @param Book $book
     * @return mixed \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     *  All user access to view payments.
     */
    public function index(Book $book)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('payment/index.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Route("/payment/approve/{payment}", name="approve_payment")
     * @param Payment $payment
     * @param MessageBusInterface $bus
     * @return mixed \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     *  Admin access only, to approve payments.
     */
    public function approve(Payment $payment, MessageBusInterface $bus)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $command = new ApprovePaymentCommand($payment);
        $bus->dispatch($command);

        return $this->render('payment/index.html.twig', [
            'book' => $payment->getBook()
        ]);
    }

    /**
     * @Route("/payment/pending", name="pending_payments")
     * @return mixed \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     *  Author access only, to list all pending payments which need approving.
     */
    public function pending()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $payments = $this->getPaymentRepository()->findBy(['status' => Payment::PENDING_APPROVAL_STATUS]);

        return $this->render('payment/pending.html.twig', [
            'payments' => $payments,
        ]);
    }
}