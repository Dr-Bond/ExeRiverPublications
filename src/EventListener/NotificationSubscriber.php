<?php

namespace App\EventListener;

use App\Entity\Book;
use App\Entity\Notification;
use App\Helper\Orm;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NotificationSubscriber implements EventSubscriberInterface
{
    private $orm;

    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    public static function getSubscribedEvents()
    {
        return [
            NotificationEvent::BOOK_STATUS_CHANGE_EVENT => [
                ["bookStatus", 0]
            ],
            NotificationEvent::BOOK_NOTE_EVENT => [
                ["bookNote", 0]
            ]
        ];
    }

    public function bookStatus(NotificationEvent $event): void
    {
        $content = 'Status change : ' . $event->getBook()->getStatus() . ' : ' . $event->getBook()->getName();
        $this->addNotification($event->getBook(), $content);
    }

    public function bookNote(NotificationEvent $event): void
    {
        $content = $event->getUser() . ' has added a note to ' . $event->getBook()->getName();
        $this->addNotification($event->getBook(), $content);
    }

    public function addNotification(Book $book, string $content): void
    {

        if($book->getAgent() !== null) {
            $notification = new Notification(
                $book->getAgent(),
                $content,
                $book
            );
            $this->orm->persist($notification);
            $this->orm->flush();
        }

        if($book->getAuthor() !== null) {
            $notification = new Notification(
                $book->getAuthor(),
                $content,
                $book
            );
            $this->orm->persist($notification);
            $this->orm->flush();
        }
    }
}