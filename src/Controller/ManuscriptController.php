<?php

namespace App\Controller;

use App\Command\UploadManuscriptCommand;
use App\Form\UploadManuscriptFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ManuscriptController extends AbstractController
{
    /**
     * @Route("/manuscript", name="manuscript")
     */
    public function index()
    {
    }

    /**
     * @Route("/manuscript/upload", name="manuscript_upload")
     */
    public function upload(Request $request, MessageBusInterface $bus)
    {
        $command = new UploadManuscriptCommand();

        $form = $this->createForm(UploadManuscriptFormType::class, $command);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bus->dispatch($command);
            return new Response("Manuscript successfully uploaded.");
        } else {
            return $this->render('manuscript/upload.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

}
