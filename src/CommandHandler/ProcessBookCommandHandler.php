<?php

namespace App\CommandHandler;

use App\Command\ProcessBookCommand;
use App\Entity\Note;
use App\Entity\Payment;
use App\EventListener\NotificationEvent;
use App\Helper\Orm;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ProcessBookCommandHandler
 * @package App\CommandHandler
 */
class ProcessBookCommandHandler
{
    /**
     * @var Orm
     */
    private $orm;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * ProcessBookCommandHandler constructor.
     * @param Orm $orm
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(Orm $orm, EventDispatcherInterface $eventDispatcher)
    {
        $this->orm = $orm;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param ProcessBookCommand $command
     * Creates a note object with the type of REVIEWER_FEEDBACK_TYPE.
     * Updates the book with the rating.
     * Updates the books status.
     * Updates all manuscripts statuses which belong to that book.
     * Creates a payment.
     * Event listener creates a user notification to inform them of a status change.
     */
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

        $notification = new NotificationEvent($command->getUser(), $command->getBook());
        $this->eventDispatcher->dispatch(NotificationEvent::BOOK_STATUS_CHANGE_EVENT, $notification);
    }
}