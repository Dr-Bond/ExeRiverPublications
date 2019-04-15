<?php

namespace App\Controller;

use App\Command\AddNoteCommand;
use App\Entity\Book;
use App\Form\AddNoteFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends BaseController
{
    /**
     * @Route("/notes/{book}", name="notes")
     */
    public function index(Book $book)
    {
        return $this->render('note/index.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/note/add/{book}", name="add_note")
     */
    public function assignEditor(Book $book, Request $request, MessageBusInterface $bus)
    {
        $command = new AddNoteCommand($book,$this->getUser());
        $form = $this->createForm(AddNoteFormType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bus->dispatch($command);
            return $this->redirect($this->generateUrl('notes',['book' => $book->getId()]));
        } else {
            return $this->render('note/add.html.twig', array(
                'form' => $form->createView(),
                'book' => $book
            ));
        }
    }
}