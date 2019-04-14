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
        $file = $command->getLocation();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->params->get('manuscript_directory'), $fileName);

        $orm = $this->orm;
        $manuscript = new Manuscript(
            $command->getName(),
            $fileName,
            $command->getBook()
        );

        $orm->persist($manuscript);
        $orm->flush();
    }
}