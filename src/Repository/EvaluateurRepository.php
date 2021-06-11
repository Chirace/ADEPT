<?php

namespace App\Repository;

use App\Entity\Evaluateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evaluateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evaluateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evaluateur[]    findAll()
 * @method Evaluateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evaluateur::class);
    }

    // /**
    //  * @return Evaluateur[] Returns an array of Evaluateur objects
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
    public function findOneBySomeField($value): ?Evaluateur
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
