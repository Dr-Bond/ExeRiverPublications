<?php

namespace App\CommandHandler;

use App\Command\SearchBookCommand;
use App\Entity\Book;
use App\Helper\Orm;
use Symfony\Component\Messenger\HandleTrait;

/**
 * Class SearchBookCommandHandler
 * @package App\CommandHandler
 */
class SearchBookCommandHandler
{
    use HandleTrait;

    /**
     * @var Orm
     */
    private $orm;

    /**
     * SearchBookCommandHandler constructor.
     * @param Orm $orm
     */
    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    /**
     * @param SearchBookCommand $command
     * @return mixed
     * Filters BookRepository by status.
     */
    public function __invoke(SearchBookCommand $command)
    {
        return $this->orm->getRepository(Book::class)->findByStatus($command->getStatus());
    }
}