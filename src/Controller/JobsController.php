<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Repository\CandidatRepository;
use App\Repository\JobCategoryRepository;
use App\Repository\JobOfferRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JobsController extends AbstractController
{
    #[Route('/jobs', name: 'app_jobs')]
    public function index(JobOfferRepository $jobOfferRepository,
    JobCategoryRepository $jobCategoryRepository): Response
    {
        $jobs = $jobOfferRepository->findAll();
       $jobsCategories = $jobCategoryRepository->findAll();

        return $this->render('jobs/index.html.twig', [
            'controller_name' => 'JobsController',
            'jobs'=> $jobs,
            'jobsCategories'=> $jobsCategories
        ]);
    }
    #[Route('/jobs/show/{userId}/{jobofferid}', name: 'app_show')]
    public function show($userId, $jobofferid,
    UserRepository $userRepository,
    JobOfferRepository $jobCategoryRepository,
    CandidatRepository $candidatRepository): Response
    {
        $job = $jobCategoryRepository->findOneBy(array ('id' => $userId));
        $user = $userRepository->findOneBy(array('id'=>$userId));
        $candidat = $candidatRepository->findOneBy(array('user'=>$user));

        return $this->render('/jobs/show.html.twig', [
            'controller_name' => 'JobsController',
            'jobofferid'=> $jobofferid,
            'candidat'=> $candidat,
            'job' => $job
        ]);
    }
}
