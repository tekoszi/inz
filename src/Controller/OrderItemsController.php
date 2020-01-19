<?php

namespace App\Controller;

use App\Entity\OrderItems;
use App\Entity\Orders;
use App\Form\OrderItemsType;
use App\Repository\OrderItemsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
        $errors = array();
        $alerts = array();
        $id = $request->query->all()['id'];
//        var_dump($request->query->all()['id']);
        $orderItem = new OrderItems();
//        $form2 = $this->createForm(OrderItemsType::class, $orderItem);
//        $form2->handleRequest($request);
        $form2 = $this->createFormBuilder()
            ->add('orderid', IntegerType::class,array(
                'disabled' => true,
                'data' => $id,
                'label' => 'Order Id',
                'attr' =>[
                    'class' => 'custom class'
                ]))
            ->add('productid', IntegerType::class,array(
                'label' => 'Product Id',
                'attr' =>[
                    'placeholder' => 'Enter the product id',
                ]))
            ->add('quantity', IntegerType::class,array(
                'attr' =>[
                    'placeholder' => 'Enter the quantity',
                ]))
            ->add('productprice', IntegerType::class,array(
                'label' => 'Product price',
                'attr' =>[
                    'placeholder' => 'Enter the product price',
                ]))
            ->add('token', HiddenType::class, [
                'data' => 'abcdef',
            ])

//            ->add('Save', SubmitType::class, [
//                'attr' =>[
//                    'placeholder' => 'Enter the barcode',
//                    'class' => 'btn btn-dark mb-1'
//                ]
//            ])
            ->getForm();
            $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $data = $form2->getData();
            $orderItem -> setOrderId($id);
            $orderItem -> setProductId($data['productid']);
            $orderItem -> setQuantity($data['quantity']);
            $orderItem -> setProductPrice($data['productprice']);
            $entityManager->persist($orderItem);
            $entityManager->flush();
            if (empty($errors)){
//                array_push($alerts, 'Operation successful');
                $this->addFlash('success', 'Operation successfull!');
            }
            return $this->redirectToRoute('orders_show', ['id' => $id]);
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
        $id = $orderItem->getOrderId();
        if ($form2->isSubmitted() && $form2->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $errors = array();
            if (empty($errors)){
                $this->addFlash('success', 'Operation successfull!');
            }
            return $this->redirectToRoute('orders_show', ['id' => $id]);
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

        $id = $orderItem->getOrderId();
        $errors = '';
        if ($this->isCsrfTokenValid('delete'.$orderItem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            var_dump($id);
            $entityManager->remove($orderItem);
            $entityManager->flush();
            if (empty($errors)){
//                array_push($alerts, 'Operation successful');
                $this->addFlash('success', 'Operation successfull!');
            }
        }

        return $this->redirectToRoute('orders_show', ['id' => $id]);
    }
}
