<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findAll()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.createdOn')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findPendingReview(User $user)
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.createdOn')
            ->where('(b.mainReviewer = :user or b.secondaryReviewer = :user)')
            ->andWhere('b.status = :pending_review')
            ->setParameter('user',$user)
            ->setParameter('pending_review',Book::PENDING_REVIEW_STATUS)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findMyBooks(User $user)
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.createdOn')
            ->where('(b.author = :user or b.agent = :user)')
            ->setParameter('user',$user)
            ->getQuery()
            ->getResult()
            ;
    }
}
