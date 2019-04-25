<?php

namespace App\CommandHandler;

use App\Command\AssignEditorCommand;
use App\Helper\Orm;

/**
 * Class AssignEditorCommandHandler
 * @package App\CommandHandler
 */
class AssignEditorCommandHandler
{
    /**
     * @var Orm
     */
    private $orm;

    /**
     * AssignEditorCommandHandler constructor.
     * @param Orm $orm
     */
    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    /**
     * @param AssignEditorCommand $command
     * Sets the editor for the book.
     */
    public function __invoke(AssignEditorCommand $command)
    {
        $orm = $this->orm;
        $book = $command->getBook();
        $book->setEditor($command->getEditor());
        $orm->persist($book);
        $orm->flush();
    }
}