<?php

namespace App\Repository;

use App\Entity\KanbanPlanning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanPlanning|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanPlanning|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanPlanning[]    findAll()
 * @method KanbanPlanning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanPlanningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanPlanning::class);
    }

    // /**
    //  * @return KanbanPlanning[] Returns an array of KanbanPlanning objects
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
    public function findOneBySomeField($value): ?KanbanPlanning
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
