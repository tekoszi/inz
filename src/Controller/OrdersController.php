<?php

namespace App\Controller;

use App\Entity\OrderItems;
use App\Entity\Orders;
use App\Form\OrderItemsType;
use App\Form\OrdersType;
use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/orders")
 */
class OrdersController extends AbstractController
{
    /**
     * @Route("/", name="orders_index", methods={"GET"})
     */
    public function index(OrdersRepository $ordersRepository): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        return $this->render('base.html.twig', [
            'orders' => $ordersRepository->findAll(),
            'userorders' => $ordersRepository->findBy(['user_id' => $user]),
            'selected_view' => 'orders/index.html.twig'
        ]);
    }

    /**
     * @Route("/new", name="orders_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $order = new Orders();
        $orderitem = new OrderItems();
        $form = $this->createForm(OrdersType::class, $order);
        $form2 = $this->createForm(OrderItemsType::class, $orderitem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('orders_index');
        }

        return $this->render('base.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'selected_view' => 'orders/new.html.twig'
        ]);
    }

    /**
     * @Route("/{id}", name="orders_show", methods={"GET"})
     */
    public function show(Orders $order): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $items = $entityManager->getRepository(OrderItems::class)->findBy(['order_id' => $order ->getId()]);
        return $this->render('base.html.twig', [
            'order' => $order,
            'items' => $items,
            'selected_view' => 'orders/show.html.twig'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="orders_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Orders $order): Response
    {
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('orders_index');
        }

        return $this->render('base.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
            'selected_view' => 'orders/edit.html.twig'
        ]);
    }

    /**
     * @Route("/{id}", name="orders_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Orders $order): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('orders_index');
    }
}
