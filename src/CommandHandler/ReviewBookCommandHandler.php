<?php

namespace App\CommandHandler;

use App\Command\ReviewBookCommand;
use App\Entity\Book;
use App\Entity\Note;
use App\Entity\Payment;
use App\EventListener\NotificationEvent;
use App\Helper\Orm;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ReviewBookCommandHandler
{
    private $orm;
    private $eventDispatcher;

    public function __construct(Orm $orm, EventDispatcherInterface $eventDispatcher)
    {
        $this->orm = $orm;
        $this->eventDispatcher = $eventDispatcher;
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

        if($command->getAmount() !== null) {
            $payment = new Payment(
                $command->getBook(),
                $command->getUser(),
                $command->getAmount(),
                Payment::ADVANCED_PAYMENT_TYPE
            );
            $orm->persist($payment);
        }
        $orm->persist($note);
        $orm->persist($book);
        $orm->flush();

        $notification = new NotificationEvent($command->getUser(), $command->getBook());
        $this->eventDispatcher->dispatch(NotificationEvent::BOOK_STATUS_CHANGE_EVENT, $notification);
    }
}