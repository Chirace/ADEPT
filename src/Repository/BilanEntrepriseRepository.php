<?php

namespace App\Repository;

use App\Entity\BilanEntreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BilanEntreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method BilanEntreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method BilanEntreprise[]    findAll()
 * @method BilanEntreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilanEntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BilanEntreprise::class);
    }

    // /**
    //  * @return BilanEntreprise[] Returns an array of BilanEntreprise objects
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
    public function findOneBySomeField($value): ?BilanEntreprise
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
