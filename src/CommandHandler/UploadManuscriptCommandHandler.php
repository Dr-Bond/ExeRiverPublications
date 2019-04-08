<?php

namespace App\CommandHandler;

use App\Command\UploadManuscriptCommand;
use App\Entity\Manuscript;
use App\Helper\Orm;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UploadManuscriptCommandHandler
{
    private $orm;
    private $params;

    public function __construct(Orm $orm, ParameterBagInterface $params)
    {
        $this->orm = $orm;
        $this->params = $params;
    }

    public function __invoke(UploadManuscriptCommand $command)
    {
        $orm = $this->orm;
        $manuscript = new Manuscript();

        $file = $command->getLocation();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->params->get('manuscript_directory'), $fileName);
        $manuscript->setReference($command->getReference());
        $manuscript->setName($command->getName());
        $manuscript->setLocation($fileName);
        $orm->persist($manuscript);
        $orm->flush();
    }
}