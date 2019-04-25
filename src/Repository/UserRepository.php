<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param $roles
     * @return mixed
     * Finds a user by their role.
     */
    public function findByRoles($roles)
    {
        return $this->createQueryBuilder('u')
            ->join('u.roles', 'r')
            ->andWhere('r.role in (:roles)')
            ->setParameter('roles', $roles)
            ->orderBy('u.surname')
            ->orderBy('u.firstName')
            ->getQuery()
            ->getResult()
        ;
    }
}
