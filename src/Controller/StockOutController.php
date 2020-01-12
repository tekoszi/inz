<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\History;
#use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
use Symfony\Component\HttpFoundation\Response;

class StockOutController extends AbstractController
{
    /**
     * @Route("/out", name="StockOut")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {

        $form = $this->createFormBuilder()
            ->add('barcode', IntegerType::class, [
                'attr' =>[
                    'placeholder' => 'Enter the barcode'
                ]
            ])
            ->add('quantity', IntegerType::class)

            ->add('Wydaj', SubmitType::class, [
                'attr' =>[
                    'class' => 'btn btn-dark mb-1'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(Products::class);
            $product = $repository->findBy(['barcode' => $data]);
            foreach ($product as $productproperty) {
                $entityManager->remove($productproperty);
            }

            $entityManager->flush();
        }

        return $this->render('base.html.twig', [
            'selected_view' => 'pages/out.html.twig',
            'form' => $form ->createView()

        ]);
    }
    /**
     * @Route("/out", name="products_delete", methods={"DELETE"})
     */

}
