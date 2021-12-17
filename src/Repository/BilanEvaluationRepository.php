<?php

namespace App\Repository;

use App\Entity\BilanEvaluation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BilanEvaluation|null find($id, $lockMode = null, $lockVersion = null)
 * @method BilanEvaluation|null findOneBy(array $criteria, array $orderBy = null)
 * @method BilanEvaluation[]    findAll()
 * @method BilanEvaluation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilanEvaluationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BilanEvaluation::class);
    }

    // /**
    //  * @return BilanEvaluation[] Returns an array of BilanEvaluation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BilanEvaluation
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
