<?php
namespace App\EventListener;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class NotificationEvent
 * @package App\EventListener
 */
class NotificationEvent extends Event
{
    /**
     * Event Type: book_note.
     */
    const BOOK_NOTE_EVENT = 'book_note';
    /**
     * Event Type: book_status_change.
     */
    const BOOK_STATUS_CHANGE_EVENT = 'book_status_change';

    /**
     * @var User
     */
    protected $user;
    /**
     * @var Book
     */
    protected $book;

    /**
     * NotificationEvent constructor.
     * @param User $user
     * @param Book|null $book
     */
    public function __construct(User $user, Book $book = null)
    {
        $this->user = $user;
        $this->book = $book;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return Book
     */
    public function getBook(): Book
    {
        return $this->book;
    }

}