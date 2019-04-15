<?php

namespace App\CommandHandler;

use App\Command\AddNoteCommand;
use App\Entity\Note;
use App\Helper\Orm;

class AddNoteCommandHandler
{
    private $orm;

    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    public function __invoke(AddNoteCommand $command)
    {
        $orm = $this->orm;
        $note = new Note(
            $command->getBook(),
            $command->getUser(),
            $command->getContent(),
            $command->getNoteType()
        );
        $orm->persist($note);
        $orm->flush();
    }
}