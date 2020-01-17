<?php

namespace App\Controller;

use App\Repository\HistoryRepository;
use App\Entity\History;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    /**
     * @Route("/history", name="history")
     */
    public function index(HistoryRepository $historyRepository)
    {
        $history = new History();
        $history -> setOperationType('Stock in');
        $history -> setProductName('product1');
//        $s = date('Y-m-d', '2020-01-16');
        $s = date('d/m/Y');
        $date = date_create_from_format('d/m/Y', $s);
        $history -> setOperationDate($date);
        $history -> setProductQuantity(1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($history);
        return $this->render('history/index.html.twig', [
            'controller_name' => 'HistoryController'
        ]);
    }
}
