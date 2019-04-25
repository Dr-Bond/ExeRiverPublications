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

    /**
     * @return Orm
     */
    public function getOrm(): Orm
    {
        return $this->orm;
    }

    /**
     * @param Orm $orm
     */
    public function setOrm(Orm $orm): void
    {
        $this->orm = $orm;
    }

    /**
     * @param ClearNotificationCommand $command
     * Deletes the Notification.
     */
    public function __invoke(ClearNotificationCommand $command)
    {
        $orm = $this->orm;
        $orm->remove($command->getNotification());
        $orm->flush();
    }
}