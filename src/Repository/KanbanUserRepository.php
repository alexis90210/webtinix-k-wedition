<?php

namespace App\Repository;


use App\Entity\KanbanUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanUser[]    findAll()
 * @method KanbanUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanUser::class);
    }

    // /**
    //  * @return KanbanUser[] Returns an array of KanbanUser objects
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
    public function findOneBySomeField($value): ?KanbanUser
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
