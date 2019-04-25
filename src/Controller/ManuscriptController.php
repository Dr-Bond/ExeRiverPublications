<?php

namespace App\Controller;

use App\Command\UploadManuscriptCommand;
use App\Entity\Book;
use App\Entity\Manuscript;
use App\Form\UploadManuscriptFormType;
use phpDocumentor\Reflection\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ManuscriptController
 * @package App\Controller
 */
class ManuscriptController extends BaseController
{
    /**
     * @Route("/manuscripts/{book}", name="manuscripts")
     * @param Book $book
     * @return mixed \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     * All user access, displays the manuscript for the book
     */
    public function index(Book $book)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('manuscript/index.html.twig', array(
            'manuscripts' => $book->getManuscripts(),
            'book' => $book
        ));
    }

    /**
     * @Route("/manuscript/upload/{book}", name="manuscript_upload")
     * @param Book $book
     * @param Request $request
     * @param MessageBusInterface $bus
     * @return mixed \Symfony\Component\HttpFoundation\RedirectResponse \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait
     *  Author access only, allows the Author to upload a book.
     */
    public function upload(Book $book, Request $request, MessageBusInterface $bus)
    {
        $this->denyAccessUnlessGranted('ROLE_AUTHOR');

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

    /**
     * @Route("/manuscript/download/{manuscript}", name="manuscript_download")
     * @param Manuscript $manuscript
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * Creates the download link fot the file.
     */
    public function download(Manuscript $manuscript)
    {
        $pdfPath = $this->getParameter('manuscript_directory').'/'.$manuscript->getLocation();
        return $this->file($pdfPath);
    }
}
