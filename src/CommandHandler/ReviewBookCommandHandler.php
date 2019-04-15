<?php

namespace App\CommandHandler;

use App\Command\ReviewBookCommand;
use App\Entity\Book;
use App\Entity\Note;
use App\Helper\Orm;

class ReviewBookCommandHandler
{
    private $orm;

    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    public function __invoke(ReviewBookCommand $command)
    {
        $orm = $this->orm;
        $note = new Note(
            $command->getBook(),
            $command->getUser(),
            $command->getFeedback(),
            Note::REVIEWER_FEEDBACK_TYPE
        );
        $book = $command->getBook();
        $book->review(
            $command->getUser(),
            $command->getProcess(),
            $command->getRating()
        );
        if ($command->getProcess() === Book::REJECTED_STATUS) {
            $book->processManuscripts($command->getProcess());
        }

        $orm->persist($note);
        $orm->persist($book);
        $orm->flush();
    }
}