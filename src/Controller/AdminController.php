<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UsersRepository;
use App\Repository\WarehousesRepository;
use App\Repository\RowsRepository;
use App\Repository\RacksRepository;
use App\Repository\ShelfsRepository;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UsersRepository $usersRepository, WarehousesRepository $warehousesRepository, RowsRepository $rowsRepository, RacksRepository $racksRepository, ShelfsRepository $shelfsRepository)
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'AdminController',
            'selected_view' => 'pages/admin.html.twig',
            'users' => $usersRepository->findAll(),
            'warehouses' => $warehousesRepository->findAll(),
            'racks' => $racksRepository->findAll(),
            'rows' => $rowsRepository->findAll(),
            'shelfs' => $shelfsRepository->findAll(),
        ]);
    }
}
