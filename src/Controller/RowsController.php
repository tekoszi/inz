<?php

namespace App\Controller;

use App\Entity\Rows;
use App\Form\RowsType;
use App\Repository\RowsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rows")
 */
class RowsController extends AbstractController
{
    /**
     * @Route("/", name="rows_index", methods={"GET"})
     */
    public function index(RowsRepository $rowsRepository): Response
    {
        return $this->render('rows/index.html.twig', [
            'rows' => $rowsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rows_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $row = new Rows();
        $form = $this->createForm(RowsType::class, $row);
        $form->handleRequest($request);
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($row);
            $entityManager->flush();

            return $this->redirectToRoute('rows_index');
        }

        return $this->render('rows/new.html.twig', [
            'row' => $row,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rows_show", methods={"GET"})
     */
    public function show(Rows $row): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('rows/show.html.twig', [
            'row' => $row,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rows_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rows $row): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(RowsType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rows_index');
        }

        return $this->render('rows/edit.html.twig', [
            'row' => $row,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rows_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rows $row): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$row->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($row);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rows_index');
    }
}
