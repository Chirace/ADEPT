<?php

namespace App\Repository;

use App\Entity\DomaineED6161;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DomaineED6161|null find($id, $lockMode = null, $lockVersion = null)
 * @method DomaineED6161|null findOneBy(array $criteria, array $orderBy = null)
 * @method DomaineED6161[]    findAll()
 * @method DomaineED6161[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DomaineED6161Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DomaineED6161::class);
    }

    // /**
    //  * @return DomaineED6161[] Returns an array of DomaineED6161 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DomaineED6161
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
