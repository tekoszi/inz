<?php

namespace App\Controller;

use App\Entity\Warehouses;
use App\Form\WarehousesType;
use App\Repository\WarehousesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/warehouses")
 */
class WarehousesController extends AbstractController
{
    /**
     * @Route("/", name="warehouses_index", methods={"GET"})
     */
    public function index(WarehousesRepository $warehousesRepository): Response
    {
        return $this->render('warehouses/index.html.twig', [
            'warehouses' => $warehousesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="warehouses_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $warehouse = new Warehouses();
        $form = $this->createForm(WarehousesType::class, $warehouse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($warehouse);
            $entityManager->flush();

            return $this->redirectToRoute('warehouses_index');
        }

        return $this->render('warehouses/new.html.twig', [
            'warehouse' => $warehouse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="warehouses_show", methods={"GET"})
     */
    public function show(Warehouses $warehouse): Response
    {
        return $this->render('warehouses/show.html.twig', [
            'warehouse' => $warehouse,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="warehouses_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Warehouses $warehouse): Response
    {
        $form = $this->createForm(WarehousesType::class, $warehouse);
        $form->handleRequest($request);
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('warehouses_index');
        }

        return $this->render('warehouses/edit.html.twig', [
            'warehouse' => $warehouse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="warehouses_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Warehouses $warehouse): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$warehouse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($warehouse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('warehouses_index');
    }
}
