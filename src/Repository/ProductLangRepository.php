<?php

namespace App\Repository;

use App\Entity\ProductLang;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductLang|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductLang|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductLang[]    findAll()
 * @method ProductLang[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductLangRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductLang::class);
    }

    // /**
    //  * @return ProductLang[] Returns an array of ProductLang objects
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
    public function findOneBySomeField($value): ?ProductLang
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
