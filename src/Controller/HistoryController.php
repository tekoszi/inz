<?php

namespace App\Controller;

use App\Repository\HistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    /**
     * @Route("/history", name="history")
     */
    public function index(HistoryRepository $historyRepository)
    {
        return $this->render('history/index.html.twig', [
            'controller_name' => 'HistoryController'
        ]);
    }
}
