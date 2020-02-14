<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Form\AdvertType;
use App\Repository\AdvertRepository;
use App\Utils\PriceEstimation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdvertController extends AbstractController
{
    /**
     * @Route("/adverts", name="advert_list")
     */
    public function index(AdvertRepository $advertRepository)
    {
        $adverts = $advertRepository->findAll();
        return $this->render('advert/index.html.twig', [
            'adverts' => $adverts,
            'controller_name' => 'AdvertController',
        ]);
    }

    /**
     * @Route("/submit-advert", name="advert_form")
     */
    public function form(Request $request, EntityManagerInterface $em, PriceEstimation $priceEstimation) 
    {
        $advert = new Advert();

        $form = $this->createForm(AdvertType::class, $advert);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $advert->setPrice($priceEstimation->getPrice( $advert->getCarYear(),$advert->getNbKm(), $advert->getNbDays()));
             $this->addFlash(
                 'SuccessMsg',
                 'Your Advert Has Been Saved :)'
             );
            $em->persist($advert);
            $em->flush();
        }

        return $this->render('advert/advertForm.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
