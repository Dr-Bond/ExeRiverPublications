<?php

namespace App\CommandHandler;

use App\Command\SearchBookCommand;
use App\Entity\Book;
use App\Helper\Orm;
use Symfony\Component\Messenger\HandleTrait;

class SearchBookCommandHandler
{
    use HandleTrait;

    private $orm;

    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    public function __invoke(SearchBookCommand $command)
    {
        return $this->orm->getRepository(Book::class)->findByStatus($command->getStatus());
    }
}