<?php

namespace App\Controller;

use App\Entity\Ingrediente;
use App\Form\IngredienteType;
use App\Repository\IngredienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ingrediente')]
class IngredienteController extends AbstractController
{
    #[Route('/', name: 'app_ingrediente_index', methods: ['GET'])]
    public function index(IngredienteRepository $ingredienteRepository): Response
    {
        return $this->render('ingrediente/index.html.twig', [
            'ingredientes' => $ingredienteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ingrediente_new', methods: ['GET', 'POST'])]
    public function new(Request $request, IngredienteRepository $ingredienteRepository): Response
    {
        $ingrediente = new Ingrediente();
        $form = $this->createForm(IngredienteType::class, $ingrediente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredienteRepository->save($ingrediente, true);

            return $this->redirectToRoute('app_ingrediente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ingrediente/new.html.twig', [
            'ingrediente' => $ingrediente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ingrediente_show', methods: ['GET'])]
    public function show(Ingrediente $ingrediente): Response
    {
        return $this->render('ingrediente/show.html.twig', [
            'ingrediente' => $ingrediente,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ingrediente_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ingrediente $ingrediente, IngredienteRepository $ingredienteRepository): Response
    {
        $form = $this->createForm(IngredienteType::class, $ingrediente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredienteRepository->save($ingrediente, true);

            return $this->redirectToRoute('app_ingrediente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ingrediente/edit.html.twig', [
            'ingrediente' => $ingrediente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ingrediente_delete', methods: ['POST'])]
    public function delete(Request $request, Ingrediente $ingrediente, IngredienteRepository $ingredienteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingrediente->getId(), $request->request->get('_token'))) {
            $ingredienteRepository->remove($ingrediente, true);
        }

        return $this->redirectToRoute('app_ingrediente_index', [], Response::HTTP_SEE_OTHER);
    }
}
