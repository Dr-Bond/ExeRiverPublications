<?php

namespace App\CommandHandler;

use App\Command\ClearNotificationCommand;
use App\Helper\Orm;

class ClearNotificationCommandHandler
{
    private $orm;

    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    public function __invoke(ClearNotificationCommand $command)
    {
        $orm = $this->orm;
        $orm->remove($command->getNotification());
        $orm->flush();
    }
}