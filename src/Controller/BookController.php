<?php

namespace App\Controller;

use App\Command\AddBookCommand;
use App\Entity\Book;
use App\Form\AddBookFormType;
use phpDocumentor\Reflection\Types\Parent_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class BookController extends BaseController
{
    public function __construct(Security $security)
    {
        parent::__construct($security);
    }

    /**
     * @Route("/book", name="book")
     */
    public function index()
    {
        $books = $this->getBookRepository()->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books
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
