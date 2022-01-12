<?php

namespace App\Repository;

use App\Entity\KanbanCommentaireReponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KanbanCommentaireReponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanbanCommentaireReponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanbanCommentaireReponse[]    findAll()
 * @method KanbanCommentaireReponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanCommentaireReponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanbanCommentaireReponse::class);
    }

    // /**
    //  * @return KanbanCommentaireReponse[] Returns an array of KanbanCommentaireReponse objects
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
    public function findOneBySomeField($value): ?KanbanCommentaireReponse
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
