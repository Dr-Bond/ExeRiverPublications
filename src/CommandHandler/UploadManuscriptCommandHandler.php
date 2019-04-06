<?php

namespace App\CommandHandler;

use App\Command\UploadManuscriptCommand;
use App\Entity\Manuscript;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UploadManuscriptCommandHandler
{
    private $entityManager;
    private $params;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $params)
    {
        $this->entityManager = $entityManager;
        $this->params = $params;
    }

    public function __invoke(UploadManuscriptCommand $command)
    {
        $entityManager = $this->entityManager;
        $manuscript = new Manuscript();

        $file = $command->getLocation();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->params->get('manuscript_directory'), $fileName);
        $manuscript->setReference($command->getReference());
        $manuscript->setName($command->getName());
        $manuscript->setLocation($fileName);
        $entityManager->persist($manuscript);
        $entityManager->flush();
    }
}