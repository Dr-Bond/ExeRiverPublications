<?php

namespace App\CommandHandler;

use App\Command\CreateUserCommand;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

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
        //$entityManager->persist($user);
        //$entityManager->flush();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('UserId', new Assert\NotBlank());
        $metadata->addPropertyConstraint(
            'userId',
            new Assert\Length(["min" => 3])
        );
    }
}