<?php

namespace App\Command;

use App\Entity\User;

/**
 * Class DeleteUserCommand
 * @package App\Command
 */
class DeleteUserCommand
{
    /**
     * @var User
     */
    private $user;

    /**
     * DeleteUserCommand constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}