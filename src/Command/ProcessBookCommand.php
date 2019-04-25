<?php

namespace App\Command;

use App\Entity\Book;
use App\Entity\User;

/**
 * Class ProcessBookCommand
 * @package App\Command
 */
class ProcessBookCommand extends AbstractProcessCommand
{

    /**
     * ProcessBookCommand constructor.
     * @param Book $book
     * @param User $user
     */
    public function __construct(Book $book, User $user)
    {
        parent::__construct($book, $user);
    }

}