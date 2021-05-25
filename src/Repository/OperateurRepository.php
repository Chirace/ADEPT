<?php

namespace App\Repository;

use App\Entity\Operateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Operateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operateur[]    findAll()
 * @method Operateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operateur::class);
    }

    // /**
    //  * @return Operateur[] Returns an array of Operateur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Operateur
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
