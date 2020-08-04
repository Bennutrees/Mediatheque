<?php

namespace App\Controller;

use App\Entity\MeetUp;
use App\Form\MeetUpType;
use App\Repository\MeetUpRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/meet_up")
 */
class MeetUpController extends AbstractController
{
    /**
     * @Route("/", name="meet_up_index", methods={"GET"})
     * @param MeetUpRepository $meetUpRepository
     * @return Response
     */
    public function index(MeetUpRepository $meetUpRepository): Response
    {
        return $this->render('admin/meet_up/index.html.twig', [
            'meet_ups' => $meetUpRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="meet_up_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $meetUp = new MeetUp();
        $form = $this->createForm(MeetUpType::class, $meetUp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $meetUp->setBookedPlaces(0);
            
            $entityManager->persist($meetUp);
            $entityManager->flush();

            return $this->redirectToRoute('meet_up_index');
        }

        return $this->render('admin/meet_up/new.html.twig', [
            'meet_up' => $meetUp,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="meet_up_edit", methods={"GET","POST"})
     * @param Request $request
     * @param MeetUp $meetUp
     * @return Response
     */
    public function edit(Request $request, MeetUp $meetUp): Response
    {
        $form = $this->createForm(MeetUpType::class, $meetUp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('meet_up_index');
        }

        return $this->render('admin/meet_up/edit.html.twig', [
            'meet_up' => $meetUp,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="meet_up_delete", methods={"DELETE"})
     * @param Request $request
     * @param MeetUp $meetUp
     * @return Response
     */
    public function delete(Request $request, MeetUp $meetUp): Response
    {
        if ($this->isCsrfTokenValid('delete'.$meetUp->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($meetUp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('meet_up_index');
    }
}
