<?php

namespace App\Repository;

use App\Entity\KanbanManga;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanManga|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanManga|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanManga[]    findAll()
 * @method KanbanManga[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanMangaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanManga::class);
    }

    // /**
    //  * @return KanbanManga[] Returns an array of KanbanManga objects
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
    public function findOneBySomeField($value): ?KanbanManga
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
