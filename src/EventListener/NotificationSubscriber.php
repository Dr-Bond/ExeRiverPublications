<?php

namespace App\EventListener;

use App\Entity\Book;
use App\Entity\Notification;
use App\Helper\Orm;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class NotificationSubscriber
 * @package App\EventListener
 */
class NotificationSubscriber implements EventSubscriberInterface
{
    /**
     * @var Orm
     */
    private $orm;

    /**
     * NotificationSubscriber constructor.
     * @param Orm $orm
     */
    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    /**
     * @return array
     */
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

    /**
     * @param NotificationEvent $event
     *  Creates a notification when the status has changed.
     */
    public function bookStatus(NotificationEvent $event): void
    {
        $content = 'Status change : ' . $event->getBook()->getStatus() . ' : ' . $event->getBook()->getName();
        $this->addNotification($event->getBook(), $content);
    }

    /**
     * @param NotificationEvent $event
     *  Creates a notification when a note has been added.
     */
    public function bookNote(NotificationEvent $event): void
    {
        $content = $event->getUser() . ' has added a note to ' . $event->getBook()->getName();
        $this->addNotification($event->getBook(), $content);
    }

    /**
     * @param Book $book
     * @param string $content
     *  Function to create the notification object, adds the user along with content
     */
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