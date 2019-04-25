<?php

namespace App\CommandHandler;

use App\Command\ReviewBookCommand;
use App\Entity\Book;
use App\Entity\Note;
use App\Entity\Payment;
use App\EventListener\NotificationEvent;
use App\Helper\Orm;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ReviewBookCommandHandler
 * @package App\CommandHandler
 */
class ReviewBookCommandHandler
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
     * ReviewBookCommandHandler constructor.
     * @param Orm $orm
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(Orm $orm, EventDispatcherInterface $eventDispatcher)
    {
        $this->orm = $orm;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param ReviewBookCommand $command
     * Creates a note object with the type of  REVIEWER_FEEDBACK_TYPE.
     * Updates the book status and rating when processed.
     * Creates a payment.
     * Event listener creates a user notification to inform them of a status change.
     */
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