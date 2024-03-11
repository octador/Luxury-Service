<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\User;
use App\Form\CandidatType;
use App\Repository\CandidatRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function index(CandidatRepository $candidatRepository, User $user,EntityManagerInterface $entityManager,Request $request): Response
    {
        
        $id = $user->getId();
        $candidat = $candidatRepository->findOneByUserId($id);

        if (!$candidat) {
            $candidat = new Candidat;
            $candidat->setUser($user);
            $candidat->setCreatedAt(new DateTimeImmutable());
            $candidat->setIsAvailable(true);
            // dd($candidat);
            $entityManager->persist($candidat);
            $entityManager->flush();
        }

        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);
         
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'form'=> $form,
            'candidat'=>  $candidat

        ]);
    }

}
