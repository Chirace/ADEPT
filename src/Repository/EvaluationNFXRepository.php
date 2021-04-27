<?php

namespace App\Repository;

use App\Entity\EvaluationNFX;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvaluationNFX|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvaluationNFX|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvaluationNFX[]    findAll()
 * @method EvaluationNFX[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluationNFXRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvaluationNFX::class);
    }

    // /**
    //  * @return EvaluationNFX[] Returns an array of EvaluationNFX objects
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
    public function findOneBySomeField($value): ?EvaluationNFX
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
