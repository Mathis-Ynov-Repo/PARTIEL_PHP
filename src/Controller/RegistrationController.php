<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->passwordEncoder = $userPasswordEncoderInterface;
    }
    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
             $this->addFlash(
                 'SuccessMsg',
                 'You have Been Saved :)'
             );
            $em->persist($user);
            $em->flush();
        }

        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController',
            'form' => $form->createView()
        ]);
    }
}
