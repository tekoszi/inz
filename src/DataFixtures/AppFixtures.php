<?php

namespace App\DataFixtures;

use App\Entity\OrderItems;
use App\Entity\Orders;
use App\Entity\Users;
use App\Entity\Products;
use App\Entity\Rows;
use App\Entity\Racks;
use App\Entity\Shelfs;
use App\Entity\Warehouses;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new Users();
        $user->setFullName('Admin');
        $user->setEmail('admin@admin.pl');
        $user->setRoles(['ROLE_ADMIN']);
//        $user->setRoles(['ROLE_USER']);
        $user->setAddress('admin address');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));
        $manager->persist($user);


        // create 20 users!
        for ($i = 0; $i < 20; $i++) {
            $user = new Users();
            $user->setFullName('User '.($i+1));
            $user->setEmail('user'.($i+1).'@email.com');
            $user->setRoles(['ROLE_USER']);
            $user->setAddress('address no.'.($i+1));
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'.($i+1)));
            $manager->persist($user);
        }
        // create 30 orders!
        for ($i = 0; $i < 30; $i++) {
            $order = new Orders();
            $order->setUserId(mt_rand(1, 20));
            $input = array("Zrealizowane", "W trakcie realizacji", "Odwołane");
            $order->setStatus($input[mt_rand(0, 2)]);
            $s = date('d/m/Y');
            $date = date_create_from_format('d/m/Y', $s);
            $date->getTimestamp();
            $order->setCreatedAt($date);
            $manager->persist($order);
        }
        // create 1 warehouse!
        for ($i = 0; $i < 1; $i++) {
            $warehouse = new Warehouses();
            $warehouse->setName('Warehouse' . ($i + 1));
            $manager->persist($warehouse);
            for ($x = 0; $x < 3; $x++) {
                $row = new Rows();
                $row->setWarehouseId($i+1);
                $manager->persist($row);
                for ($y = 0; $y < 5; $y++) {
                    $rack = new Racks();
                    $rack->setRowId($x+1);
                    $manager->persist($rack);
                    for ($z = 0; $z < 5; $z++) {
                        $shelf = new Shelfs();
                        $shelf->setRackId($y+1);
                        $manager->persist($shelf);
                    }
                }
            }
        }
        // create 30 products!
        for ($i = 0; $i < 75; $i++) {
            $product = new Products();
            $product->setName('product '.($i+1));
            $product->setPrice(mt_rand(1000, 10000)/100);
            $product->setBarcode(mt_rand(7000000, 8000000));
            $product->setQuantity(mt_rand(1, 500));
            $product->setWarehouseId(1);
            $product->setRowId(mt_rand(1, 3));
            $product->setRackId(mt_rand(1, 5));
            $product->setShelfId($i+1);
            $manager->persist($product);
        }

        // create 50 orderitems!
        for ($i = 0; $i < 50; $i++) {
            $orderitem = new OrderItems();
            $orderitem->setOrderId(mt_rand(1, 30));
            $orderitem->setProductId(mt_rand(1, 30));
            $orderitem->setQuantity(mt_rand(1, 10));
            $orderitem->setProductPrice(mt_rand(1, 100));
            $manager->persist($orderitem);
        }




        $manager->flush();
    }
}