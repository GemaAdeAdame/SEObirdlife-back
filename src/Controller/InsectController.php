<?php

namespace App\Controller;

use App\Entity\Insect;
use App\Form\InsectType;
use App\Repository\InsectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/insect')]
class InsectController extends AbstractController
{
    #[Route('/', name: 'app_insect_index', methods: ['GET'])]
    public function index(InsectRepository $insectRepository): Response
    {
        return $this->render('insect/index.html.twig', [
            'insects' => $insectRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_insect_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InsectRepository $insectRepository): Response
    {
        $insect = new Insect();
        $form = $this->createForm(InsectType::class, $insect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $insectRepository->save($insect, true);

            return $this->redirectToRoute('app_insect_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('insect/new.html.twig', [
            'insect' => $insect,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_insect_show', methods: ['GET'])]
    public function show(Insect $insect): Response
    {
        return $this->render('insect/show.html.twig', [
            'insect' => $insect,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_insect_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Insect $insect, InsectRepository $insectRepository): Response
    {
        $form = $this->createForm(InsectType::class, $insect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $insectRepository->save($insect, true);

            return $this->redirectToRoute('app_insect_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('insect/edit.html.twig', [
            'insect' => $insect,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_insect_delete', methods: ['POST'])]
    public function delete(Request $request, Insect $insect, InsectRepository $insectRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$insect->getId(), $request->request->get('_token'))) {
            $insectRepository->remove($insect, true);
        }

        return $this->redirectToRoute('app_insect_index', [], Response::HTTP_SEE_OTHER);
    }
}
