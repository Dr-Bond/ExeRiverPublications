<?php

namespace App\CommandHandler;

use App\Command\ProcessBookCommand;
use App\Entity\Note;
use App\Helper\Orm;

class ProcessBookCommandHandler
{
    private $orm;

    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    public function __invoke(ProcessBookCommand $command)
    {
        $orm = $this->orm;
        $note = new Note(
            $command->getBook(),
            $command->getUser(),
            $command->getFeedback(),
            Note::REVIEWER_FEEDBACK_TYPE
        );
        $book = $command->getBook();
        $book->setStatus($command->getProcess());
        $book->setEditorRating($command->getRating());
        $book->processManuscripts($command->getProcess());
        $orm->persist($note);
        $orm->persist($book);
        $orm->flush();
    }
}