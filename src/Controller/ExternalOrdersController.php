<?php

namespace App\Controller;

use App\Entity\ExternalOrders;
use App\Form\ExternalOrdersType;
use App\Repository\ExternalOrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/external/orders")
 */
class ExternalOrdersController extends AbstractController
{
    /**
     * @Route("/", name="external_orders_index", methods={"GET"})
     */
    public function index(ExternalOrdersRepository $externalOrdersRepository): Response
    {
        return $this->render('external_orders/index.html.twig', [
            'external_orders' => $externalOrdersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="external_orders_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $externalOrder = new ExternalOrders();
        $form = $this->createForm(ExternalOrdersType::class, $externalOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $externalOrder -> setProducts(['7'=>213,'5'=>12]);
            $entityManager->persist($externalOrder);
            $entityManager->flush();

            return $this->redirectToRoute('external_orders_index');
        }

        return $this->render('external_orders/new.html.twig', [
            'external_order' => $externalOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="external_orders_show", methods={"GET"})
     */
    public function show(ExternalOrders $externalOrder): Response
    {
        return $this->render('external_orders/show.html.twig', [
            'external_order' => $externalOrder,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="external_orders_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ExternalOrders $externalOrder): Response
    {
        $form = $this->createForm(ExternalOrdersType::class, $externalOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('external_orders_index');
        }

        return $this->render('external_orders/edit.html.twig', [
            'external_order' => $externalOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="external_orders_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ExternalOrders $externalOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$externalOrder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($externalOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('external_orders_index');
    }
}
