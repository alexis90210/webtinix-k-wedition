<?php

namespace App\Repository;

use App\Entity\AdminActions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdminActions|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminActions|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminActions[]    findAll()
 * @method AdminActions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminActionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminActions::class);
    }

    // /**
    //  * @return AdminActions[] Returns an array of AdminActions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdminActions
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
