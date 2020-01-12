<?php

namespace App\Repository;

use App\Entity\Warehouses;
use App\Entity\Shelfs;
use App\Entity\Racks;
use App\Entity\Rows;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Warehouses|null find($id, $lockMode = null, $lockVersion = null)
 * @method Warehouses|null findOneBy(array $criteria, array $orderBy = null)
 * @method Warehouses[]    findAll()
 * @method Warehouses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WarehousesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Warehouses::class);
    }


    public function findempty()
    {

        $entityManager = $this->getEntityManager()->getConnection();

        /*
        $query = $entityManager->createQuery(
            'SELECT distinct she
            FROM App\Entity\Shelfs she
            JOIN App\Entity\Racks rac
            JOIN App\Entity\Rows row
            JOIN App\Entity\Warehouses war
            WHERE she NOT IN (SELECT prod FROM App\Entity\Products prod)
            ');

        return $query->getResult();
        */

        $sql = 'select distinct she.id shelf_id,rac.id rack_id , row.id row_id, war.id warehouse_id from shelfs she
        left join products pro on she.id = pro.warehouse_id
        left join racks rac on she.rack_id=rac.id
        left join rows row on rac.row_id = row.id
        left join warehouses war on row.warehouse_id = war.id
        where she.id not in (select shelf_id from products);
        ';
        $stmt = $entityManager->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }




    // /**
    //  * @return Warehouses[] Returns an array of Warehouses objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Warehouses
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
