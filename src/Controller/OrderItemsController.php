<?php

namespace App\Controller;

use App\Entity\OrderItems;
use App\Form\OrderItemsType;
use App\Repository\OrderItemsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order/items")
 */
class OrderItemsController extends AbstractController
{
    /**
     * @Route("/", name="order_items_index", methods={"GET"})
     */
    public function index(OrderItemsRepository $orderItemsRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('order_items/index.html.twig', [
            'order_items' => $orderItemsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="order_items_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $orderItem = new OrderItems();
        $form2 = $this->createForm(OrderItemsType::class, $orderItem);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orderItem);
            $entityManager->flush();

            return $this->redirectToRoute('order_items_index');
        }

        return $this->render('order_items/new.html.twig', [
            'order_item' => $orderItem,
            'form2' => $form2->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="order_items_show", methods={"GET"})
     */
    public function show(OrderItems $orderItem): Response
    {
        return $this->render('order_items/show.html.twig', [
            'order_item' => $orderItem,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="order_items_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OrderItems $orderItem): Response
    {
        $form2 = $this->createForm(OrderItemsType::class, $orderItem);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_items_index');
        }

        return $this->render('order_items/edit.html.twig', [
            'order_item' => $orderItem,
            'form2' => $form2->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_items_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OrderItems $orderItem): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderItem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($orderItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('order_items_index');
    }
}
