<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\History;
use App\Entity\Warehouses;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @Route("/products")
 */
class ProductsController extends AbstractController
{
    /**
     * @Route("/", name="products_index", methods={"GET"})
     */
    public function index(ProductsRepository $productsRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('base.html.twig', [
            'products' => $productsRepository->findAll(),
            'selected_view' => 'products/index.html.twig'

        ]);
    }

    /**
     * @Route("/new", name="products_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $repository = $this->getDoctrine()->getRepository(Products::class);
            $productbartest = $repository->findBy(['barcode' => $product->getBarcode()]);
            if($productbartest){
                $this->addFlash('failure', 'Product with this barcode already exists!');
//                return $this->redirectToRoute('products_in');
                return $this->redirectToRoute('products_show', ['id' => $productbartest[0] -> getId()]);
            }
            $history = new History();
            $history -> setOperationType('New stock');
            $history -> setProductName($product->getName());
            $s = date('d/m/Y');
            $date = date_create_from_format('d/m/Y', $s);
            $date->getTimestamp();
            $history -> setOperationDate($date);
            $history -> setProductQuantity($product->getQuantity());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->persist($history);
            $entityManager->flush();

            return $this->redirectToRoute('products_index');
        }

        return $this->render('base.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'selected_view' => 'products/new.html.twig'
        ]);
    }

    /**
     * @Route("/in", name="products_in", methods={"GET","POST"})
     */
    public function in(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $errors = array();
        $alerts = array();
        $warehousesRepository = $this->getDoctrine()
            ->getRepository(Warehouses::class);

        $freespace = $warehousesRepository->findempty();

        $array = array();
        foreach ($freespace as $value)
            array_push($array, array(
                $value['warehouse_id'].', '.$value['row_id'].', '.$value['rack_id'].', '.$value['shelf_id'] => $value['warehouse_id'].', '.$value['row_id'].', '.$value['rack_id'].', '.$value['shelf_id']
            ));

        $product = new Products();
        $form = $this->createFormBuilder()
            ->add('barcode', IntegerType::class,array(
                'attr' =>[
                    'placeholder' => 'Enter the barcode',
                    'class' => 'custom class'
                ]))
            ->add('name', TextType::class,array(
                'attr' =>[
                    'placeholder' => 'Enter the name',
                ]))
            ->add('price', IntegerType::class,array(
                'attr' =>[
                    'placeholder' => 'Enter the price',
                ]))
            ->add('quantity', IntegerType::class,array(
                'attr' =>[
                    'placeholder' => 'Enter the quantity',
                ]))
            ->add('location', ChoiceType::class,[
                'choices'  => $array,
                'label' => 'Location (Warehouse, Row, Rack, Shelf)'
            ])

            ->add('Save', SubmitType::class, [
                'attr' =>[
                    'placeholder' => 'Enter the barcode',
                    'class' => 'btn btn-dark mb-1'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form -> isSubmitted() && $form ->isValid())
        {
            $data = $form->getData();
//            var_dump($data);
            $entityManager = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(Products::class);
            $productbartest = $repository->findBy(['barcode' => $data['barcode']]);
            if($productbartest){
                $this->addFlash('failure', 'Product with this barcode already exists!');
//                return $this->redirectToRoute('products_in');
                return $this->redirectToRoute('products_show', ['id' => $productbartest[0] -> getId()]);
            }
            $choice = explode(", ", $data['location']);

            $history = new History();
            $history -> setOperationType('Stock in');
            $history -> setProductName($data['name']);
            $s = date('d/m/Y');
            $date = date_create_from_format('d/m/Y', $s);
            $date->getTimestamp();
            $history -> setOperationDate($date);
            $history -> setProductQuantity($data['quantity']);
//            var_dump($product);
            //Create product
            $product ->setBarcode($data['barcode']);
            $product ->setName($data['name']);
            $product ->setQuantity($data['quantity']);
            $product ->setPrice($data['price']);
            $product ->setWarehouseId($choice[0]);
            $product ->setRowId($choice[1]);
            $product ->setRackId($choice[2]);
            $product ->setShelfId($choice[3]);
            $freespace = $warehousesRepository->findempty();
            $request = array();
            // Save to DB!
            $em = $this->getDoctrine()->getManager();
            $em ->persist($product);
            $em ->persist($history);
            $em ->flush();
            if (empty($errors)){
//                array_push($alerts, 'Operation successful');
                $this->addFlash('success', 'Operation successfull!');
            }


        }

        return $this->render('base.html.twig', [
            'product' => $product,
            'product_form' => $form->createView(),
            'selected_view' => 'products/in.html.twig',
            'freespace' => $freespace,
            'form' => $form->createView(),
            'errors' => $errors,
            'alerts' => $alerts,
        ]);
    }


    /**
     * @Route("/out", name="products_out", methods={"GET","POST"})
     */
    public function out(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $errors = array();
        $alerts = array();
        # get quentity, set quantity to - quantity
        # set history zmiana ilosci
        # if quantity == 0 remove from database

        $form = $this->createFormBuilder()
            ->add('barcode', IntegerType::class, [
                'attr' =>[
                    'placeholder' => 'Enter the barcode'
                ]
            ])
            ->add('quantity', IntegerType::class,array(
                'attr' =>[
                    'placeholder' => 'Enter the quantity',
                ]))

            ->add('Confirm', SubmitType::class, [
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
            if (!$product) {
                array_push($errors, 'Product could not be found.');
                $this->addFlash('failure', 'Product could not be found!');
            }
            else{
                $history = new History();
                $history -> setOperationType('Stock out');
                $s = date('d/m/Y');
                $date = date_create_from_format('d/m/Y', $s);
                $date->getTimestamp();
                $history -> setOperationDate($date);
                $history -> setProductQuantity($data['quantity']);

                foreach ($product as $productproperty) {
                    if ($productproperty -> getQuantity()-$data['quantity']<=0){
                        var_dump('zero');
                        $entityManager->remove($productproperty);
                    }
                    $history -> setProductName($productproperty->getName());
                    $productproperty -> setQuantity($productproperty -> getQuantity()-$data['quantity']);


                }

                $entityManager->persist($history);
                $entityManager->flush();
            }

            if (empty($errors)){
//                array_push($alerts, 'Operation successful');
                $this->addFlash('success', 'Operation successfull!');
            }

        }

        return $this->render('base.html.twig', [
            'selected_view' => 'products/out.html.twig',
            'form' => $form ->createView(),
            'errors' => $errors,
            'alerts' => $alerts,
        ]);
    }

    /**
     * @Route("/replace", name="products_replace", methods={"GET","POST"})
     */
    public function replace(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $errors = array();
        $alerts = array();


        $form = $this->createFormBuilder()
            ->add('firstbarcode', IntegerType::class, [
                'attr' =>[
                    'placeholder' => 'Enter the barcode of first item'
                ]
            ])
            ->add('secondbarcode', IntegerType::class, [
                'attr' =>[
                    'placeholder' => 'Enter the barcode of second item'
                ]
            ])

            ->add('Swap', SubmitType::class, [
                'attr' =>[
                    'class' => 'btn btn-dark mb-1'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $product1 = $entityManager->getRepository(Products::class)->findBy(['barcode' => $data['firstbarcode']]);
            $product2 = $entityManager->getRepository(Products::class)->findBy(['barcode' => $data['secondbarcode']]);
            if (!$product1) {
//                array_push($errors, 'First product could not be found.');
                $this->addFlash('failure', 'First product could not be found!');
            }
            if (!$product2) {
//                array_push($errors, 'Second product could not be found.');
                $this->addFlash('failure', 'Second product could not be found!');
            }


            if ($product1 and $product2){
                $prod1war = $product1[0]->getWarehouseId();
                $prod1row = $product1[0]->getRowId();
                $prod1rac = $product1[0]->getRackId();
                $prod1she = $product1[0]->getShelfId();
                $prod2war = $product2[0]->getWarehouseId();
                $prod2row = $product2[0]->getRowId();
                $prod2rac = $product2[0]->getRackId();
                $prod2she = $product2[0]->getShelfId();


                $product1[0]->setWarehouseId($prod2war);
                $product2[0]->setWarehouseId($prod1war);

                $product1[0]->setRowId($prod2row);
                $product2[0]->setRowId($prod1row);

                $product1[0]->setRackId($prod2rac);
                $product2[0]->setRackId($prod1rac);

                $product1[0]->setShelfId($prod2she);
                $product2[0]->setShelfId($prod1she);
                $history = new History();
                $history -> setOperationType('Products swaped');
                $history -> setProductName(strval($product1[0] -> getBarcode().' swaped with '.strval($product1[0] -> getBarcode())));
                $s = date('d/m/Y');
                $date = date_create_from_format('d/m/Y', $s);
                $date->getTimestamp();
                $history -> setOperationDate($date);
                $history -> setProductQuantity(1);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($history);
                $entityManager->flush();
                if (empty($errors)){
                    $this->addFlash('success', 'Operation successfull!');
                }
            }



        }

        return $this->render('base.html.twig', [
            'selected_view' => 'products/replace.html.twig',
            'form' => $form ->createView(),
            'errors' => $errors,
            'alerts' => $alerts,
        ]);
    }

    /**
     * @Route("/{id}", name="products_show", methods={"GET"})
     */
    public function show(Products $product): Response
    {
        return $this->render('base.html.twig', [
            'product' => $product,
            'selected_view' => 'products/show.html.twig'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="products_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Products $product): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);
//        var_dump($product);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Operation successfull!');
            return $this->redirectToRoute('products_index');
        }

        return $this->render('products/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="products_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Products $product): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $errors = array();
            $alerts = array();
            $history = new History();
            $history -> setOperationType('Stock removed');
            $history -> setProductName($product->getName());
            $s = date('d/m/Y');
            $date = date_create_from_format('d/m/Y', $s);
            $date->getTimestamp();
            $history -> setOperationDate($date);
            $history -> setProductQuantity($product->getQuantity());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($history);
            $entityManager->remove($product);
            $entityManager->flush();
            $this->addFlash('success', 'Operation successfull!');
//
        }

        return $this->redirectToRoute('products_index');
    }


}
