<?php

namespace App\Controller;

use App\Entity\Foto;
use App\Form\FotoType;
use App\Repository\FotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/foto')]
class FotoController extends AbstractController
{
    #[Route('/', name: 'app_foto_index', methods: ['GET'])]
    public function index(FotoRepository $fotoRepository): Response
    {
        return $this->render('foto/index.html.twig', [
            'fotos' => $fotoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_foto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FotoRepository $fotoRepository): Response
    {
        $foto = new Foto();
        $form = $this->createForm(FotoType::class, $foto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('foto')->getData();
            $fileName = uniqid().'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads_directory'), $fileName);
            $foto->setFoto($fileName);

            $fotoRepository->save($foto, true);

            return $this->redirectToRoute('app_receta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('foto/new.html.twig', [
            'foto' => $foto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_foto_show', methods: ['GET'])]
    public function show(Foto $foto): Response
    {
        return $this->render('foto/show.html.twig', [
            'foto' => $foto,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_foto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Foto $foto, FotoRepository $fotoRepository): Response
    {
        $form = $this->createForm(FotoType::class, $foto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fotoRepository->save($foto, true);

            return $this->redirectToRoute('app_foto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('foto/edit.html.twig', [
            'foto' => $foto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_foto_delete', methods: ['POST'])]
    public function delete(Request $request, Foto $foto, FotoRepository $fotoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$foto->getId(), $request->request->get('_token'))) {
            $fotoRepository->remove($foto, true);
        }

        return $this->redirectToRoute('app_foto_index', [], Response::HTTP_SEE_OTHER);
    }
}
