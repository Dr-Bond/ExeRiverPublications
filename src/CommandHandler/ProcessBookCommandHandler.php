<?php

namespace App\CommandHandler;

use App\Command\ProcessBookCommand;
use App\Entity\Note;
use App\Entity\Payment;
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
        if($command->getAmount() !== null) {
            $payment = new Payment(
                $command->getBook(),
                $command->getUser(),
                $command->getAmount(),
                Payment::FINAL_PAYMENT_TYPE
            );
            $orm->persist($payment);
        }
        $orm->persist($note);
        $orm->persist($book);
        $orm->flush();
    }
}