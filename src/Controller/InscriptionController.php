<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription', methods: ['GET', 'POST'] )]
    public function index(Request $request, EntityManagerInterface $manager,UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

                 // hash the password (based on the security.yaml config for the $user class)
                 $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                );
                $user->setPassword($hashedPassword);

            $this->addFlash(
                'success',
                'votre compte a bien été crée .'
            );

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_inscription');

        }
        

        return $this->render('pages/inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
            'form' => $form->createView()
        
        ]);
    }
    
}
