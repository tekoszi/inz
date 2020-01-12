<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Warehouses;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlaceFinderController extends AbstractController
{
    /**
     * @Route("/findplace", name="findplace")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {

        $warehousesRepository = $this->getDoctrine()
            ->getRepository(Warehouses::class);

        $freespace = $warehousesRepository->findempty();


        return $this->render('base.html.twig', [
            'selected_view' => 'pages/findPlace.html.twig',
            'freespace' => $freespace

        ]);
    }
}
