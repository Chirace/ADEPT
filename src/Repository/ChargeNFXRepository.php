<?php

namespace App\Repository;

use App\Entity\ChargeNFX;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChargeNFX|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChargeNFX|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChargeNFX[]    findAll()
 * @method ChargeNFX[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChargeNFXRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChargeNFX::class);
    }

    // /**
    //  * @return ChargeNFX[] Returns an array of ChargeNFX objects
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
    public function findOneBySomeField($value): ?ChargeNFX
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
