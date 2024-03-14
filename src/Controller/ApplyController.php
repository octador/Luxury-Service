<?php

namespace App\Controller;

use App\Entity\Apply;
use App\Entity\User;
use App\Repository\CandidatRepository;
use App\Repository\JobOfferRepository;
use App\Repository\StatusRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApplyController extends AbstractController
{
     /**
     * @Route("/apply/{userId}/{jobId}", name="app_apply")
     */
    #[Route('/apply/{userId}/{jobOfferId}', name: 'app_apply')]
    public function index($userId, $jobOfferId, UserRepository $userRepository,
                            CandidatRepository $candidatRepository,
                            JobOfferRepository $jobOfferRepository,
                            StatusRepository $statusRepository,
                            EntityManagerInterface $entityManagerInterface): Response
    {
        $user = $userRepository ->findby(array('id'=>$userId));

        $candidat = $candidatRepository -> findOneby(array('user'=> $user));

        $jobOffer = $jobOfferRepository -> findOneby(array('id' => $jobOfferId));

        $status = $statusRepository ->findOneBy(array('status' => 'pending'));
        // dd($status);
        $apply = new Apply;
        $apply -> setCandidat($candidat);
        $apply ->setJobOffer($jobOffer);
        $apply ->setCreatedAt(new DateTimeImmutable());
        $apply -> setStatus($status);

        $entityManagerInterface ->persist($apply);
        $entityManagerInterface ->flush();

        return $this->render('apply/index.html.twig', [
            'controller_name' => 'ApplyController',
        ]);
    }
}
