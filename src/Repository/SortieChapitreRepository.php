<?php

namespace App\Repository;

use App\Entity\SortieChapitre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SortieChapitre|null find($id, $lockMode = null, $lockVersion = null)
 * @method SortieChapitre|null findOneBy(array $criteria, array $orderBy = null)
 * @method SortieChapitre[]    findAll()
 * @method SortieChapitre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieChapitreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SortieChapitre::class);
    }

    // /**
    //  * @return SortieChapitre[] Returns an array of SortieChapitre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SortieChapitre
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
