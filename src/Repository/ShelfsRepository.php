<?php

namespace App\Repository;

use App\Entity\Shelfs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Shelfs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shelfs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shelfs[]    findAll()
 * @method Shelfs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShelfsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shelfs::class);
    }

    // /**
    //  * @return Shelfs[] Returns an array of Shelfs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Shelfs
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
