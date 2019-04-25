<?php

namespace App\CommandHandler;

use App\Command\CreateUserCommand;
use App\Entity\Address;
use App\Entity\Role;
use App\Entity\User;
use App\Helper\Orm;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CreateUserCommandHandler
 * @package App\CommandHandler
 */
class CreateUserCommandHandler
{
    /**
     * @var Orm
     */
    private $orm;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * CreateUserCommandHandler constructor.
     * @param Orm $orm
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(Orm $orm, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->orm = $orm;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param CreateUserCommand $command
     * Creates a user, role and address object and encodes the password being flushing to database.
     */
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

    /**
     * @param User $user
     * @param array $address
     * Create address function.
     */
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

    /**
     * @param User $user
     * @param string $role
     * Function for creating the user role.
     */
    private function addRole(User $user, string $role)
    {
        $entity = new Role(
            $user,
            $role
        );
        $this->orm->persist($entity);
        return;
    }

    /**
     * @param User $user
     * @param string $password
     * @return string
     * Function to encode the plain password
     */
    private function encodePassword(User $user, string $password)
    {
        return $this->passwordEncoder->encodePassword(
            $user,
            $password
        );
    }

}