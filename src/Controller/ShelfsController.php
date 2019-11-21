<?php

namespace App\Controller;

use App\Entity\Shelfs;
use App\Form\ShelfsType;
use App\Repository\ShelfsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shelfs")
 */
class ShelfsController extends AbstractController
{
    /**
     * @Route("/", name="shelfs_index", methods={"GET"})
     */
    public function index(ShelfsRepository $shelfsRepository): Response
    {
        return $this->render('shelfs/index.html.twig', [
            'shelfs' => $shelfsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="shelfs_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $shelf = new Shelfs();
        $form = $this->createForm(ShelfsType::class, $shelf);
        $form->handleRequest($request);
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shelf);
            $entityManager->flush();

            return $this->redirectToRoute('shelfs_index');
        }

        return $this->render('shelfs/new.html.twig', [
            'shelf' => $shelf,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shelfs_show", methods={"GET"})
     */
    public function show(Shelfs $shelf): Response
    {
        return $this->render('shelfs/show.html.twig', [
            'shelf' => $shelf,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shelfs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Shelfs $shelf): Response
    {
        $form = $this->createForm(ShelfsType::class, $shelf);
        $form->handleRequest($request);
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shelfs_index');
        }

        return $this->render('shelfs/edit.html.twig', [
            'shelf' => $shelf,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shelfs_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Shelfs $shelf): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$shelf->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($shelf);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shelfs_index');
    }
}
