<?php

namespace App\Controller;

use App\Entity\OrderItems;
use App\Entity\Orders;
use App\Entity\History;
use App\Form\OrderItemsType;
use App\Form\OrdersType;
use function PHPSTORM_META\type;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/orders")
 */
class OrdersController extends AbstractController
{
    /**
     * @Route("/", name="orders_index", methods={"GET","POST"})
     */
    public function index(OrdersRepository $ordersRepository,Request $request): Response
    {

        $s = date('d/m/Y');
        $date = date_create_from_format('d/m/Y', $s);
        $date->getTimestamp();
        $order = new Orders();
        $orderitem = new OrderItems();
        $user = $this->get('security.token_storage')->getToken()->getUser();
//        $form = $this->createForm(OrdersType::class, $order);
        $form = $this->createFormBuilder()

            ->getForm();
        $form2 = $this->createForm(OrderItemsType::class, $orderitem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order -> setUserId($user -> getId());
            $order -> setStatus('New');
            $order -> setCreatedAt($date);
            $repository = $this->getDoctrine()->getRepository(Orders::class);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();
            $dborder = $repository->findBy(['user_id' => $user -> getId(), 'status' => 'New', 'created_at' => $date]);
            $id = $dborder[0] -> getId();
            $history = new History();
            $history -> setOperationType('New order');
            $history -> setProductName('Order id: '.$id);
            $s = date('d/m/Y');
            $date = date_create_from_format('d/m/Y', $s);
            $date->getTimestamp();
            $history -> setOperationDate($date);
            $history -> setProductQuantity(1);
            $entityManager->persist($history);
            $entityManager->flush();



            return $this->redirectToRoute('orders_show', ['id' => $id]);
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        return $this->render('base.html.twig', [
            'orders' => $ordersRepository->findAll(),
            'userorders' => $ordersRepository->findBy(['user_id' => $user]),
            'selected_view' => 'orders/index.html.twig',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="orders_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
//        adding new order was processed in orders/index

        return $this->render('base.html.twig', [
            'selected_view' => 'orders/new.html.twig'
        ]);
    }

    /**
     * @Route("/{id}", name="orders_show", methods={"GET","POST"})
     */
    public function show(Request $request,Orders $order): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $items = $entityManager->getRepository(OrderItems::class)->findBy(['order_id' => $order ->getId()]);
        $form = $this->createFormBuilder()
            ->add('submit', SubmitType::class, [
                'label' => 'Submit form',
                'attr' =>[
                    'class' => 'btn btn-dark mb-1'
                ]
            ])
            ->getForm();
        $id = $order->getId();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $order -> setStatus('Accepted');
            $history = new History();
            $history -> setOperationType('Order accepted');
            $history -> setProductName('Order id: '.$id);
            $s = date('d/m/Y');
            $date = date_create_from_format('d/m/Y', $s);
            $date->getTimestamp();
            $history -> setOperationDate($date);
            $history -> setProductQuantity(1);
            $entityManager->persist($history);
            $entityManager->flush();
            $errors = '';
            if (empty($errors)){
                $this->addFlash('success', 'Operation successfull!');
            }
            return $this->redirectToRoute('orders_show', ['id' => $id]);
        }
        return $this->render('base.html.twig', [
            'order' => $order,
            'items' => $items,
            'form' => $form->createView(),
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
            $id = $order -> getId();
            $entityManager = $this->getDoctrine()->getManager();
            $history = new History();
            $history -> setOperationType('Order edited');
            $history -> setProductName('Order id: '.$id);
            $s = date('d/m/Y');
            $date = date_create_from_format('d/m/Y', $s);
            $date->getTimestamp();
            $history -> setOperationDate($date);
            $history -> setProductQuantity(1);
            $entityManager->persist($history);
            $entityManager->flush();
            $errors = '';
            if (empty($errors)){
                $this->addFlash('success', 'Operation successfull!');
            }
            return $this->redirectToRoute('orders_show', ['id' => $id]);
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
            $id = $order -> getId();
            $entityManager->remove($order);
            $entityManager->flush();
            $history = new History();
            $history -> setOperationType('Order removed');
            $history -> setProductName('Order id: '.$id);
            $s = date('d/m/Y');
            $date = date_create_from_format('d/m/Y', $s);
            $date->getTimestamp();
            $history -> setOperationDate($date);
            $history -> setProductQuantity(1);
            $entityManager->persist($history);
            $entityManager->flush();
            $errors = '';
            if (empty($errors)){
                $this->addFlash('success', 'Operation successfull!');
            }
        }

        return $this->redirectToRoute('orders_index');
    }
}
