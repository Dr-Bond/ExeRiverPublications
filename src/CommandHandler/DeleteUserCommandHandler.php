<?php

namespace App\CommandHandler;

use App\Command\DeleteUserCommand;
use App\Helper\Orm;

/**
 * Class DeleteUserCommandHandler
 * @package App\CommandHandler
 */
class DeleteUserCommandHandler
{
    /**
     * @var Orm
     */
    private $orm;

    /**
     * DeleteUserCommandHandler constructor.
     * @param Orm $orm
     */
    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    /**
     * @param DeleteUserCommand $command
     *  Deletes the user.
     */
    public function __invoke(DeleteUserCommand $command)
    {
        $orm = $this->orm;
        $orm->remove($command->getUser());
        $orm->flush();
    }
}