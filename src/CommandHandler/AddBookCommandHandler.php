<?php

namespace App\CommandHandler;

use App\Command\AddBookCommand;
use App\Entity\Book;
use App\Helper\Orm;

/**
 * Class AddBookCommandHandler
 * @package App\CommandHandler
 */
class AddBookCommandHandler
{
    /**
     * @var Orm
     */
    private $orm;

    /**
     * AddBookCommandHandler constructor.
     * @param Orm $orm
     */
    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    /**
     * @param AddBookCommand $command
     * Creates the book.
     */
    public function __invoke(AddBookCommand $command)
    {
        $orm = $this->orm;
        $book = new Book(
            $command->getName(),
            $command->getReference(),
            $command->getAuthor(),
            $command->getAgent(),
            $command->getMainReviewer()
        );
        $book->setSecondaryReviewer($command->getSecondaryReviewer());
        $orm->persist($book);
        $orm->flush();
    }
}