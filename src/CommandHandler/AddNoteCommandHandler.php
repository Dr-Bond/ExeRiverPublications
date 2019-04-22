<?php

namespace App\CommandHandler;

use App\Command\AddNoteCommand;
use App\Entity\Note;
use App\EventListener\NotificationEvent;
use App\Helper\Orm;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\Tests\Debug\EventSubscriber;

class AddNoteCommandHandler
{
    private $orm;
    private $eventDispatcher;

    public function __construct(Orm $orm, EventDispatcherInterface $eventDispatcher)
    {
        $this->orm = $orm;
        $this->eventDispatcher = $eventDispatcher;
    }

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