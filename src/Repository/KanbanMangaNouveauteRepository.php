<?php

namespace App\Repository;

use App\Entity\KanbanMangaNouveaute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanMangaNouveaute|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanMangaNouveaute|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanMangaNouveaute[]    findAll()
 * @method KanbanMangaNouveaute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanMangaNouveauteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanMangaNouveaute::class);
    }

    // /**
    //  * @return KanbanMangaNouveaute[] Returns an array of KanbanMangaNouveaute objects
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
    public function findOneBySomeField($value): ?KanbanMangaNouveaute
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
