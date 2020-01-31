<?php

namespace App\Repository;

use App\Entity\ExternalOrders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ExternalOrders|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExternalOrders|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExternalOrders[]    findAll()
 * @method ExternalOrders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExternalOrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExternalOrders::class);
    }

    // /**
    //  * @return ExternalOrders[] Returns an array of ExternalOrders objects
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
    public function findOneBySomeField($value): ?ExternalOrders
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
