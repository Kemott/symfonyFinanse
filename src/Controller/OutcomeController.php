<?php

namespace App\Controller;

use App\Entity\Outcome;
use App\Form\OutcomeType;
use App\Repository\OutcomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/outcome")
 */
class OutcomeController extends AbstractController
{
    /**
     * @Route("/", name="outcome_index", methods={"GET"})
     */
    public function index(OutcomeRepository $outcomeRepository): Response
    {
        return $this->render('outcome/index.html.twig', [
            'outcomes' => $outcomeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="outcome_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $outcome = new Outcome();
        $form = $this->createForm(OutcomeType::class, $outcome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($outcome);
            $entityManager->flush();

            /*
            Odjęcie kwoty kosztu z rachunku konta
            */
            $account = $outcome->getAccount();
            $account->setAmount($account->getAmount() - $outcome->getAmount());
            $entityManager->persist($account);
            $entityManager->flush();

            return $this->redirectToRoute('outcome_index');
        }

        return $this->render('outcome/new.html.twig', [
            'outcome' => $outcome,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="outcome_show", methods={"GET"})
     */
    public function show(Outcome $outcome): Response
    {
        return $this->render('outcome/show.html.twig', [
            'outcome' => $outcome,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="outcome_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Outcome $outcome): Response
    {
        $form = $this->createForm(OutcomeType::class, $outcome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('outcome_index');
        }

        return $this->render('outcome/edit.html.twig', [
            'outcome' => $outcome,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="outcome_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Outcome $outcome): Response
    {
        if ($this->isCsrfTokenValid('delete'.$outcome->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            /*
            Dodanie kwoty kosztu do rachunku konta
            */
            $account = $outcome->getAccount();
            $account->setAmount($account->getAmount() + $outcome->getAmount());
            $entityManager->persist($account);
            $entityManager->flush();

            $entityManager->remove($outcome);
            $entityManager->flush();
        }

        return $this->redirectToRoute('outcome_index');
    }
}
