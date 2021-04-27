<?php

namespace App\Repository;

use App\Entity\CategorieContrainte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieContrainte|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieContrainte|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieContrainte[]    findAll()
 * @method CategorieContrainte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieContrainteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieContrainte::class);
    }

    // /**
    //  * @return CategorieContrainte[] Returns an array of CategorieContrainte objects
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
    public function findOneBySomeField($value): ?CategorieContrainte
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
