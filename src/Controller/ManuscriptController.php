<?php

namespace App\Controller;

use App\Command\UploadManuscriptCommand;
use App\Entity\Book;
use App\Form\UploadManuscriptFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ManuscriptController extends AbstractController
{
    /**
     * @Route("/manuscripts/{book}", name="manuscripts")
     */
    public function index(Book $book)
    {
        return $this->render('manuscript/index.html.twig', array(
            'manuscripts' => $book->getManuscripts(),
            'book' => $book
        ));
    }

    /**
     * @Route("/manuscript/upload/{book}", name="manuscript_upload")
     */
    public function upload(Book $book, Request $request, MessageBusInterface $bus)
    {
        $command = new UploadManuscriptCommand();
        $command->setBook($book);
        $form = $this->createForm(UploadManuscriptFormType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bus->dispatch($command);
            new Response("Manuscript successfully uploaded.");
                return $this->redirect($this->generateUrl('manuscripts',['book' => $book->getId()]));
        } else {
            return $this->render('manuscript/upload.html.twig', array(
                'form' => $form->createView(),
                'book' => $book
            ));
        }
    }

}
