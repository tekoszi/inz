<?php

namespace App\Repository;

use App\Entity\IssueConfirmation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method IssueConfirmation|null find($id, $lockMode = null, $lockVersion = null)
 * @method IssueConfirmation|null findOneBy(array $criteria, array $orderBy = null)
 * @method IssueConfirmation[]    findAll()
 * @method IssueConfirmation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IssueConfirmationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IssueConfirmation::class);
    }

    // /**
    //  * @return IssueConfirmation[] Returns an array of IssueConfirmation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IssueConfirmation
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
