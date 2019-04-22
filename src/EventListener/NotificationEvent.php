<?php
namespace App\EventListener;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class NotificationEvent extends Event
{
    const BOOK_NOTE_EVENT = 'book_note';
    const BOOK_STATUS_CHANGE_EVENT = 'book_status_change';

    protected $user;
    protected $book;

    public function __construct(User $user, Book $book = null)
    {
        $this->user = $user;
        $this->book = $book;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

}