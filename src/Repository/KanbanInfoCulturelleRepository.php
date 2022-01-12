<?php

namespace App\Repository;

use App\Entity\KanbanInfoCulturelle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanInfoCulturelle|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanInfoCulturelle|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanInfoCulturelle[]    findAll()
 * @method KanbanInfoCulturelle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanInfoCulturelleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanInfoCulturelle::class);
    }

    // /**
    //  * @return KanbanInfoCulturelle[] Returns an array of KanbanInfoCulturelle objects
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
    public function findOneBySomeField($value): ?KanbanInfoCulturelle
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
