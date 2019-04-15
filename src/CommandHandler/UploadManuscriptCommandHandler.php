<?php

namespace App\CommandHandler;

use App\Command\UploadManuscriptCommand;
use App\Entity\Book;
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
        $book = $command->getBook();
        $manuscript = new Manuscript(
            $command->getName(),
            $fileName,
            $book
        );
        if($book->getStatus() === Book::REVISION_REQUIRED_STATUS) {
            $book->setStatus(Book::PENDING_EDITOR_REVIEW_STATUS);
            $orm->persist($book);
        } else {
            $book->setStatus(Book::PENDING_REVIEW_STATUS);
            $orm->persist($book);
        }
        $orm->persist($manuscript);
        $orm->flush();
    }
}