<?php

namespace App\CommandHandler;

use App\Command\CreateUserCommand;
use App\Entity\Address;
use App\Entity\Role;
use App\Entity\User;
use App\Helper\Orm;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommandHandler
{
    private $orm;
    private $passwordEncoder;

    public function __construct(Orm $orm, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->orm = $orm;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function __invoke(CreateUserCommand $command)
    {
        $orm = $this->orm;
        $user = new User(
            $command->getFirstName(),
            $command->getSurname()
        );
        $user->setPassword($this->encodePassword($user, $command->getPlainPassword()));
        $this->addAddress(
            $user,
            ['address_line_1' => $command->getAddressLineOne(),
            'address_line_2' => $command->getAddressLineTwo(),
            'city' => $command->getCity(),
            'county' => $command->getCounty(),
            'postcode' => $command->getPostcode(),
            'country' => $command->getCountry()
            ]
        );
        $this->addRole($user, $command->getRole());
        $orm->persist($user);
        $orm->flush();
    }

    private function addAddress(User $user, array $address)
    {
        $entity = new Address(
            $user,
            $address['address_line_1'],
            $address['city'],
            $address['county'],
            $address['postcode'],
            $address['country']
        );
        if(!empty($address['country'])) {
            $entity->setAddressLineTwo($address['address_line_2']);
        }
        $this->orm->persist($entity);
        return;
    }

    private function addRole(User $user, string $role)
    {
        $entity = new Role(
            $user,
            $role
        );
        $this->orm->persist($entity);
        return;
    }

    private function encodePassword(User $user, string $password)
    {
        return $this->passwordEncoder->encodePassword(
            $user,
            $password
        );
    }

}