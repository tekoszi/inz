<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'AdminController',
            'selected_view' => 'pages/admin.html.twig',
        ]);
    }
}
