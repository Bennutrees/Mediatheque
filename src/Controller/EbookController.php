<?php

namespace App\Controller;

use App\Entity\Ebook;
use App\Form\EbookType;
use App\Repository\EbookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;

/**
 * @Route("/ebook")
 */
class EbookController extends AbstractController
{
    /**
     * @Route("/", name="ebook_index", methods={"GET"})
     * @param EbookRepository $ebookRepository
     * @return Response
     */
    public function index(EbookRepository $ebookRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $ebookRepository->findAll(),
            $request->query->getInt('page', 1),
            5
        );
        
        return $this->render('ebook/index.html.twig', [
            'pagination' => $pagination,
            /*
            'ebooks' => $ebookRepository->findAll()
            */
        ]);
    }

    /**
     * @Route("/new", name="ebook_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $ebook = new Ebook();
        $form = $this->createForm(EbookType::class, $ebook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ebook);
            $entityManager->flush();

            return $this->redirectToRoute('ebook_index');
        }

        return $this->render('ebook/new.html.twig', [
            'ebook' => $ebook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ebook_show", methods={"GET"})
     * @param Ebook $ebook
     * @return Response
     */
    public function show(Ebook $ebook): Response
    {
        return $this->render('ebook/show.html.twig', [
            'ebook' => $ebook,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ebook_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Ebook $ebook
     * @return Response
     */
    public function edit(Request $request, Ebook $ebook): Response
    {
        $form = $this->createForm(EbookType::class, $ebook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ebook_index');
        }

        return $this->render('ebook/edit.html.twig', [
            'ebook' => $ebook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ebook_delete", methods={"DELETE"})
     * @param Request $request
     * @param Ebook $ebook
     * @return Response
     */
    public function delete(Request $request, Ebook $ebook): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ebook->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ebook);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ebook_index');
    }
}
