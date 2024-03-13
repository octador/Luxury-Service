<?php
namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Media;
use App\Entity\User;
use App\Form\CandidatType;
use App\Form\MediaType;
use App\Repository\CandidatRepository;
use App\Service\FileUploader;
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
    public function index(
        CandidatRepository $candidatRepository,
        User $user,EntityManagerInterface $entityManager,
        Request $request,
        FileUploader $fileUploader
        ): Response
    {
        $id = $user->getId();
        $candidat = $candidatRepository->findOneByUserId($id);
        
        if (!$candidat) {
            $candidat = new Candidat;
            $candidat->setUser($user);
            $candidat->setCreatedAt(new DateTimeImmutable());
            $candidat->setIsAvailable(true);
            $entityManager->persist($candidat);
            $entityManager->flush();
        }
        
        
        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);
        
        

        if ($form->isSubmitted() && $form->isValid()) {
            $candidat->setUpdatedAt(new DateTimeImmutable());
            $passportFile = $form->get('passportfile')->getData();

            if($passportFile) {
                $media = new Media();
                $passportFileName = $fileUploader->upload($passportFile);
                $media->setName($passportFileName);
                $candidat->setCv($media);
                $entityManager->persist($media);
                $entityManager->flush();
            }
            
            $cvfile = $form->get('cvfile')->getData();
            if($cvfile) {
                $media = new Media();
                $cvFileName = $fileUploader->upload($cvfile);
                $media->setName($cvFileName);
                $candidat->setCv($media);
                $entityManager->persist($media);
                $entityManager->flush();
            }
            $profilPictureFile = $form->get('profilPicture')->getData();
            if($profilPictureFile) {
                $media = new Media();
                $profilPictureName = $fileUploader->upload($profilPictureFile);
                $media->setName($profilPictureName);
                $candidat->setCv($media);
                $entityManager->persist($media);
                $entityManager->flush();
            }
        }
          
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'form'=> $form,
            'candidat'=>  $candidat,
           
        ]);
    }

}
