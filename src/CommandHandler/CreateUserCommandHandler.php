<?php

namespace App\CommandHandler;

use App\Command\CreateUserCommand;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CreateUserCommandHandler
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(CreateUserCommand $command)
    {
        $entityManager = $this->entityManager;
        $user = new User();
        $user->setUserId($command->getUserId());
        $user->setPassword($command->getPlainPassword());
        $entityManager->persist($user);
        $entityManager->flush();
    }
}