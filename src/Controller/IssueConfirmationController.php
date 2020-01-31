<?php

namespace App\Controller;

use App\Entity\IssueConfirmation;
use App\Form\IssueConfirmationType;
use App\Repository\IssueConfirmationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/issue/confirmation")
 */
class IssueConfirmationController extends AbstractController
{
    /**
     * @Route("/", name="issue_confirmation_index", methods={"GET"})
     */
    public function index(IssueConfirmationRepository $issueConfirmationRepository): Response
    {
        return $this->render('issue_confirmation/index.html.twig', [
            'issue_confirmations' => $issueConfirmationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="issue_confirmation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $issueConfirmation = new IssueConfirmation();
        $form = $this->createForm(IssueConfirmationType::class, $issueConfirmation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($issueConfirmation);
            $entityManager->flush();

            return $this->redirectToRoute('issue_confirmation_index');
        }

        return $this->render('issue_confirmation/new.html.twig', [
            'issue_confirmation' => $issueConfirmation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="issue_confirmation_show", methods={"GET"})
     */
    public function show(IssueConfirmation $issueConfirmation): Response
    {
        return $this->render('issue_confirmation/show.html.twig', [
            'issue_confirmation' => $issueConfirmation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="issue_confirmation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, IssueConfirmation $issueConfirmation): Response
    {
        $form = $this->createForm(IssueConfirmationType::class, $issueConfirmation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('issue_confirmation_index');
        }

        return $this->render('issue_confirmation/edit.html.twig', [
            'issue_confirmation' => $issueConfirmation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="issue_confirmation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, IssueConfirmation $issueConfirmation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$issueConfirmation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($issueConfirmation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('issue_confirmation_index');
    }
}
