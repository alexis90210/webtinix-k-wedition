<?php

namespace App\Repository;

use App\Entity\KanbanCommentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanCommentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanCommentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanCommentaire[]    findAll()
 * @method KanbanCommentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanCommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanCommentaire::class);
    }

    // /**
    //  * @return KanbanCommentaire[] Returns an array of KanbanCommentaire objects
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
    public function findOneBySomeField($value): ?KanbanCommentaire
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
