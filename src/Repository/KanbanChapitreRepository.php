<?php

namespace App\Repository;

use App\Entity\KanbanChapitre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanChapitre|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanChapitre|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanChapitre[]    findAll()
 * @method KanbanChapitre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanChapitreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanChapitre::class);
    }

    // /**
    //  * @return KanbanChapitre[] Returns an array of KanbanChapitre objects
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
    public function findOneBySomeField($value): ?KanbanChapitre
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
