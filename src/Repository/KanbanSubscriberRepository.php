<?php

namespace App\Repository;

use App\Entity\KanbanSubscriber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanSubscriber|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanSubscriber|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanSubscriber[]    findAll()
 * @method KanbanSubscriber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanSubscriberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanSubscriber::class);
    }

    // /**
    //  * @return KanbanSubscriber[] Returns an array of KanbanSubscriber objects
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
    public function findOneBySomeField($value): ?KanbanSubscriber
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
