<?php

namespace App\CommandHandler;

use App\Command\AddNoteCommand;
use App\Entity\Note;
use App\EventListener\NotificationEvent;
use App\Helper\Orm;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class AddNoteCommandHandler
 * @package App\CommandHandler
 */
class AddNoteCommandHandler
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
     * AddNoteCommandHandler constructor.
     * @param Orm $orm
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(Orm $orm, EventDispatcherInterface $eventDispatcher)
    {
        $this->orm = $orm;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param AddNoteCommand $command
     * Create note.
     * Event listener to add notifications when a note is added.
     */
    public function __invoke(AddNoteCommand $command)
    {
        $orm = $this->orm;
        $note = new Note(
            $command->getBook(),
            $command->getUser(),
            $command->getContent(),
            $command->getNoteType()
        );
        $orm->persist($note);
        $orm->flush();

        $notification = new NotificationEvent($command->getUser(), $command->getBook());
        $this->eventDispatcher->dispatch(NotificationEvent::BOOK_NOTE_EVENT, $notification);
    }
}