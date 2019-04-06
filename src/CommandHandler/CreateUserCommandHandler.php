<?php

namespace App\CommandHandler;

use App\Command\CreateUserCommand;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommandHandler
{
    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function __invoke(CreateUserCommand $command)
    {
        $entityManager = $this->entityManager;
        $user = new User(
            $command->getFirstName(),
            $command->getSurname()
        );
        $encoded = $this->passwordEncoder->encodePassword(
            $user,
            $command->getPlainPassword()
        );
        $user->setPassword($encoded);
        $user->setAddressLineOne($command->getAddressLineOne());
        $user->setAddressLineTwo($command->getAddressLineOne());
        $user->setCity($command->getCity());
        $user->setCounty($command->getCounty());
        $user->setPostcode($command->getPostcode());
        $user->setCountry($command->getCountry());
        $entityManager->persist($user);
        $entityManager->flush();
    }

}