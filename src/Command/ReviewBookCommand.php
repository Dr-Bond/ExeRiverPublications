<?php

namespace App\Command;

use App\Entity\Book;
use App\Entity\User;

class ReviewBookCommand extends AbstractProcessCommand
{
    public function __construct(Book $book, User $user)
    {
        parent::__construct($book, $user);
    }
}