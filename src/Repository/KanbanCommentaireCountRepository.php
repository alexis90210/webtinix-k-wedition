<?php

namespace App\Repository;

use App\Entity\KanbanCommentaireCount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanCommentaireCount|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanCommentaireCount|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanCommentaireCount[]    findAll()
 * @method KanbanCommentaireCount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanCommentaireCountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanCommentaireCount::class);
    }

    // /**
    //  * @return KanbanCommentaireCount[] Returns an array of KanbanCommentaireCount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KanbanCommentaireCount
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
