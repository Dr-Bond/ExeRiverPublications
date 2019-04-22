<?php

namespace App\Command;

use App\Entity\Notification;

class ClearNotificationCommand
{

    private $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function getNotification(): Notification
    {
        return $this->notification;
    }

}