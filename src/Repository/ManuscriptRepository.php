<?php

namespace App\Repository;

use App\Entity\Manuscript;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Manuscript|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manuscript|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manuscript[]    findAll()
 * @method Manuscript[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManuscriptRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Manuscript::class);
    }

    // /**
    //  * @return Manuscript[] Returns an array of Manuscript objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Manuscript
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
