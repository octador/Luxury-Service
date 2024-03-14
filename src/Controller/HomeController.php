<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Repository\JobCategoryRepository;
use App\Repository\JobOfferRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(JobOfferRepository $jobOfferRepository,
    JobCategoryRepository $jobCategoryRepository): Response
    {
    $lastTenJobs = $jobOfferRepository->findBy([], ['createdAt' => 'DESC'], 10);

    $jobCategories = $jobCategoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'jobs'=> $lastTenJobs,
            'jobCategories' => $jobCategories

        ]);
    }
    
}
