<?php

namespace App\Repository;

use App\Entity\KanbanMangaGenre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanMangaGenre|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanMangaGenre|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanMangaGenre[]    findAll()
 * @method KanbanMangaGenre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanMangaGenreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanMangaGenre::class);
    }

    // /**
    //  * @return KanbanMangaGenre[] Returns an array of KanbanMangaGenre objects
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
    public function findOneBySomeField($value): ?KanbanMangaGenre
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
