<?php

namespace App\Controller\Admin;

use App\Entity\Advert;
use App\Form\Advert1Type;
use App\Repository\AdvertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/advert")
 */
class AdvertController extends AbstractController
{
    /**
     * @Route("/", name="advert_index", methods={"GET"})
     */
    public function index(AdvertRepository $advertRepository): Response
    {
        return $this->render('Admin/advert/index.html.twig', [
            'adverts' => $advertRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="advert_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $advert = new Advert();
        $form = $this->createForm(Advert1Type::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($advert);
            $entityManager->flush();

            return $this->redirectToRoute('advert_index');
        }

        return $this->render('Admin/advert/new.html.twig', [
            'advert' => $advert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="advert_show", methods={"GET"})
     */
    public function show(Advert $advert): Response
    {
        return $this->render('Admin/advert/show.html.twig', [
            'advert' => $advert,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="advert_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Advert $advert): Response
    {
        $form = $this->createForm(Advert1Type::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('advert_index');
        }

        return $this->render('Admin/advert/edit.html.twig', [
            'advert' => $advert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="advert_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Advert $advert): Response
    {
        if ($this->isCsrfTokenValid('delete'.$advert->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($advert);
            $entityManager->flush();
        }

        return $this->redirectToRoute('advert_index');
    }
}
