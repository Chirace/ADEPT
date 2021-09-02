<?php

namespace App\Repository;

use App\Entity\Grille1ED6161;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Grille1ED6161|null find($id, $lockMode = null, $lockVersion = null)
 * @method Grille1ED6161|null findOneBy(array $criteria, array $orderBy = null)
 * @method Grille1ED6161[]    findAll()
 * @method Grille1ED6161[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Grille1ED6161Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grille1ED6161::class);
    }

    // /**
    //  * @return Grille1ED6161[] Returns an array of Grille1ED6161 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Grille1ED6161
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
