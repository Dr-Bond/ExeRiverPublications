<?php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Note::class);
    }

    public function findNonFeedbackNotes()
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.noteType not in (:reviewer, :editor)')
            ->setParameter('reviewer', Note::REVIEWER_FEEDBACK_TYPE)
            ->setParameter('editor', Note::EDITOR_FEEDBACK_TYPE)
            ->getQuery()
            ->getResult()
            ;
    }
}
