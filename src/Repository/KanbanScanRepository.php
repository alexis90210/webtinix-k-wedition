<?php

namespace App\Repository;

use App\Entity\KanbanScan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanScan|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanScan|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanScan[]    findAll()
 * @method KanbanScan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanScanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanScan::class);
    }

    // /**
    //  * @return KanbanScan[] Returns an array of KanbanScan objects
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
    public function findOneBySomeField($value): ?KanbanScan
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
