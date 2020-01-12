<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\History;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
            $history = new History();
            $history -> setOperationType('Dodano towar');
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

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

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
            $history = new History();
            $history -> setOperationType('Usunieto towar');
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
        }

        return $this->redirectToRoute('products_index');
    }


}
