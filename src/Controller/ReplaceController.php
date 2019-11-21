<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReplaceController extends AbstractController
{
    /**
     * @Route("/replace", name="replace")
     */
    public function index()
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'ReplaceController',
            'selected_view' => 'pages/replace.html.twig'
        ]);
    }
}
