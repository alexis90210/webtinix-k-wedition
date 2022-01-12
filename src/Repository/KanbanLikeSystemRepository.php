<?php

namespace App\Repository;

use App\Entity\KanbanLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanLike[]    findAll()
 * @method KanbanLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanLikeSystemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanLike::class);
    }

    // /**
    //  * @return KanbanLike[] Returns an array of KanbanLike objects
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
    public function findOneBySomeField($value): ?KanbanLike
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
