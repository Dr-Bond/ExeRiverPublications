<?php

namespace App\Controller;

use App\Command\ApprovePaymentCommand;
use App\Entity\Book;
use App\Entity\Payment;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends BaseController
{
    /**
     * @Route("/payments/{book}", name="payments")
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