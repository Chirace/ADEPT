<?php

namespace App\Repository;

use App\Entity\PosteDeTravail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PosteDeTravail|null find($id, $lockMode = null, $lockVersion = null)
 * @method PosteDeTravail|null findOneBy(array $criteria, array $orderBy = null)
 * @method PosteDeTravail[]    findAll()
 * @method PosteDeTravail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PosteDeTravailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PosteDeTravail::class);
    }

    // /**
    //  * @return PosteDeTravail[] Returns an array of PosteDeTravail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PosteDeTravail
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
