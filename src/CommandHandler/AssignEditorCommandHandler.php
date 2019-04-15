<?php

namespace App\CommandHandler;

use App\Command\AssignEditorCommand;
use App\Helper\Orm;

class AssignEditorCommandHandler
{
    private $orm;

    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    public function __invoke(AssignEditorCommand $command)
    {
        $orm = $this->orm;
        $book = $command->getBook();
        $book->setEditor($command->getEditor());
        $orm->persist($book);
        $orm->flush();
    }
}