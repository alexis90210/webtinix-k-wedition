<?php

namespace App\Repository;

use App\Entity\KanbanContactUs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanContactUs|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanContactUs|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanContactUs[]    findAll()
 * @method KanbanContactUs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanContactUsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanContactUs::class);
    }

    // /**
    //  * @return KanbanContactUs[] Returns an array of KanbanContactUs objects
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
    public function findOneBySomeField($value): ?KanbanContactUs
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
