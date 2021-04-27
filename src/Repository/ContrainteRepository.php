<?php

namespace App\Repository;

use App\Entity\Contrainte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contrainte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contrainte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contrainte[]    findAll()
 * @method Contrainte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContrainteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contrainte::class);
    }

    // /**
    //  * @return Contrainte[] Returns an array of Contrainte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contrainte
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
