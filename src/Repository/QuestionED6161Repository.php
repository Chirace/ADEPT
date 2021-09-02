<?php

namespace App\Repository;

use App\Entity\QuestionED6161;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestionED6161|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionED6161|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionED6161[]    findAll()
 * @method QuestionED6161[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionED6161Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionED6161::class);
    }

    // /**
    //  * @return QuestionED6161[] Returns an array of QuestionED6161 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestionED6161
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
