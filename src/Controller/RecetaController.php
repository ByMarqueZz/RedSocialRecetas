<?php

namespace App\Controller;

use App\Entity\Receta;
use App\Form\Receta1Type;
use App\Repository\RecetaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Foto;
use App\Repository\FotoRepository;

#[Route('/receta')]
class RecetaController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'app_receta_index', methods: ['GET'])]
    public function index(RecetaRepository $recetaRepository, FotoRepository $fotoRepository): Response
    {
        $recetas = $this->entityManager->getRepository(Receta::class)->findAll();
        $ingredientes = [];
        for ($i = 0; $i < count($recetas); $i++) {
            $recetaId = $recetas[$i]->getId();
            $qb = $this->entityManager->createQueryBuilder()
                ->select('i')
                ->from('App\Entity\Ingrediente', 'i')
                ->join('i.recetas', 'r')
                ->where('r.id = :recetaId')
                ->setParameter('recetaId', $recetaId);

            $ingredientesQuery = $qb->getQuery();
            $ingredientes[$i] = $ingredientesQuery->getResult();
        }
        return $this->render('receta/index.html.twig', [
            'recetas' => $recetas,
            'fotos' => $fotoRepository->findAll(),
            'key' => 0,
            'ingredientes' => $ingredientes,
        ]);
    }

    #[Route('/new', name: 'app_receta_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RecetaRepository $recetaRepository): Response
    {
        $recetum = new Receta();
        $form = $this->createForm(Receta1Type::class, $recetum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recetaRepository->save($recetum, true);

            return $this->redirectToRoute('app_foto_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('receta/new.html.twig', [
            'recetum' => $recetum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_receta_show', methods: ['GET'])]
    public function show(Receta $recetum): Response
    {
        return $this->render('receta/show.html.twig', [
            'recetum' => $recetum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_receta_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Receta $recetum, RecetaRepository $recetaRepository): Response
    {
        $form = $this->createForm(Receta1Type::class, $recetum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recetaRepository->save($recetum, true);

            return $this->redirectToRoute('app_receta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('receta/edit.html.twig', [
            'recetum' => $recetum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_receta_delete', methods: ['POST'])]
    public function delete(Request $request, Receta $recetum, RecetaRepository $recetaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recetum->getId(), $request->request->get('_token'))) {
            $recetaRepository->remove($recetum, true);
        }

        return $this->redirectToRoute('app_receta_index', [], Response::HTTP_SEE_OTHER);
    }
}
