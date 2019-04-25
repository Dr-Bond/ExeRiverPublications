<?php

namespace App\Command;

use App\Entity\Book;
use App\Entity\User;

/**
 * Class ReviewBookCommand
 * @package App\Command
 */
class ReviewBookCommand extends AbstractProcessCommand
{
    /**
     * ReviewBookCommand constructor.
     * @param Book $book
     * @param User $user
     */
    public function __construct(Book $book, User $user)
    {
        parent::__construct($book, $user);
    }
}