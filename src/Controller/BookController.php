<?php

namespace App\Controller;

use App\Command\AddBookCommand;
use App\Form\AddBookFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="book")
     */
    public function index()
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    /**
     * @Route("/book/add", name="book_add")
     */
    public function upload(Request $request, MessageBusInterface $bus)
    {
        $command = new AddBookCommand();

        $form = $this->createForm(AddBookFormType::class, $command);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bus->dispatch($command);
            return new Response("Book is successfully added.");
        } else {
            return $this->render('book/add.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }
}
