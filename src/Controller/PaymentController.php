<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends BaseController
{
    /**
     * @Route("/payments/{book}", name="payments")
     */
    public function index(Book $book)
    {
        return $this->render('payment/index.html.twig', [
            'book' => $book
        ]);
    }
}