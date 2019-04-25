<?php

namespace App\Command;

use App\Entity\Notification;

/**
 * Class ClearNotificationCommand
 * @package App\Command
 */
class ClearNotificationCommand
{
    /**
     * @var Notification
     */
    private $notification;

    /**
     * ClearNotificationCommand constructor.
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        return $this->notification;
    }

}