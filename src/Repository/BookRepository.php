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
    /**
     * BookRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @return array|mixed
     * Returns all books and orders them by date.
     */
    public function findAll()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.createdOn')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function findPendingReview(User $user)
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.createdOn')
            ->where('(b.mainReviewer = :user or b.secondaryReviewer = :user)')
            ->andWhere('(b.status = :pending_review or b.status = :pending_second_review)')
            ->setParameter('user',$user)
            ->setParameter('pending_review',Book::PENDING_REVIEW_STATUS)
            ->setParameter('pending_second_review',Book::PENDING_SECOND_REVIEW_STATUS)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param User $user
     * @return mixed
     */
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

    /**
     * @param User $user
     * @return mixed
     */
    public function findPendingEditorProcessing(User $user)
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.createdOn')
            ->where('b.editor = :user')
            ->andWhere('b.status in (:accepted, :pending)')
            ->setParameter('user',$user)
            ->setParameter('accepted', Book::ACCEPTED_STATUS)
            ->setParameter('pending', Book::PENDING_EDITOR_REVIEW_STATUS)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param string $status
     * @return mixed
     */
    public function findByStatus(string $status)
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.createdOn')
            ->andWhere('b.status = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult()
            ;
    }

}
