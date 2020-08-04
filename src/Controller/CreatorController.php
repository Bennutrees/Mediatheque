<?php

namespace App\Controller;

use App\Entity\Creator;
use App\Form\CreatorType;
use App\Repository\CreatorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/creator")
 */
class CreatorController extends AbstractController
{
    /**
     * @Route("/", name="creator_index", methods={"GET"})
     * @param CreatorRepository $creatorRepository
     * @return Response
     */
    public function index(CreatorRepository $creatorRepository): Response
    {
        return $this->render('admin/creator/index.html.twig', [
            'creators' => $creatorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="creator_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $creator = new Creator();
        $form = $this->createForm(CreatorType::class, $creator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($creator);
            $entityManager->flush();

            return $this->redirectToRoute('creator_index');
        }

        return $this->render('admin/creator/new.html.twig', [
            'creator' => $creator,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="creator_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Creator $creator
     * @return Response
     */
    public function edit(Request $request, Creator $creator): Response
    {
        $form = $this->createForm(CreatorType::class, $creator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('creator_index');
        }

        return $this->render('admin/creator/edit.html.twig', [
            'creator' => $creator,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="creator_delete", methods={"DELETE"})
     * @param Request $request
     * @param Creator $creator
     * @return Response
     */
    public function delete(Request $request, Creator $creator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$creator->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($creator);
            $entityManager->flush();
        }

        return $this->redirectToRoute('creator_index');
    }
}
