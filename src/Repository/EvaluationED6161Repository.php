<?php

namespace App\Repository;

use App\Entity\EvaluationED6161;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvaluationED6161|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvaluationED6161|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvaluationED6161[]    findAll()
 * @method EvaluationED6161[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluationED6161Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvaluationED6161::class);
    }

    // /**
    //  * @return EvaluationED6161[] Returns an array of EvaluationED6161 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EvaluationED6161
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
