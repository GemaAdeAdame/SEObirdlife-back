<?php

namespace App\Controller;

use App\Entity\Birds;
use App\Form\BirdsType;
use App\Repository\BirdsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/birds')]
class BirdsController extends AbstractController
{
    #[Route('/', name: 'app_birds_index', methods: ['GET'])]
    public function index(BirdsRepository $birdsRepository): Response
    {
        return $this->render('birds/index.html.twig', [
            'birds' => $birdsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_birds_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BirdsRepository $birdsRepository): Response
    {
        $bird = new Birds();
        $form = $this->createForm(BirdsType::class, $bird);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $birdsRepository->save($bird, true);

            return $this->redirectToRoute('app_birds_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('birds/new.html.twig', [
            'bird' => $bird,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_birds_show', methods: ['GET'])]
    public function show(Birds $bird): Response
    {
        return $this->render('birds/show.html.twig', [
            'bird' => $bird,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_birds_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Birds $bird, BirdsRepository $birdsRepository): Response
    {
        $form = $this->createForm(BirdsType::class, $bird);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $birdsRepository->save($bird, true);

            return $this->redirectToRoute('app_birds_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('birds/edit.html.twig', [
            'bird' => $bird,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_birds_delete', methods: ['POST'])]
    public function delete(Request $request, Birds $bird, BirdsRepository $birdsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bird->getId(), $request->request->get('_token'))) {
            $birdsRepository->remove($bird, true);
        }

        return $this->redirectToRoute('app_birds_index', [], Response::HTTP_SEE_OTHER);
    }
}
