<?php

namespace App\Controller\Admin;

use App\Entity\Apply;
use App\Entity\Candidat;
use App\Entity\Client;
use App\Entity\Experience;
use App\Entity\Gender;
use App\Entity\JobCategory;
use App\Entity\JobOffer;
use App\Entity\JobType;
use App\Entity\Media;
use App\Entity\Status;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{   // Injectez l'EntityManagerInterface pour récupérer des données depuis la base de données
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $userRepos = $this->entityManager->getRepository(User::class);
        $users = $userRepos->findAll();
        $candidatsRepos= $this->entityManager->getRepository(Candidat::class);
        $candidats = $candidatsRepos->findAll();
        $clientrepos = $this->entityManager->getRepository(Client::class);
        $clients = $clientrepos->findAll();
        $candiaturerepos = $this->entityManager->getRepository(Apply::class);
        $candidatures = $candiaturerepos->findall();
        $postrepos = $this->entityManager->getRepository(JobOffer::class);
        $posts = $postrepos->findAll();

        
        
         return $this->render('admin/dashboard.html.twig',[
            'users'=> $users,
            'candidats'=> $candidats,
            'clients'=> $clients,
            'candidatures'=> $candidatures,
            'posts'=> $posts,
         ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Luxury Services');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Gender', 'fa-solid fa-person', Gender::class);
        yield MenuItem::linkToCrud('Status', 'fa-solid fa-power-off', Status::class);
        yield MenuItem::linkToCrud('JobType', 'fa-solid fa-puzzle-piece', JobType::class);
        yield MenuItem::linkToCrud('Experience', 'fa-solid fa-suitcase', Experience::class);
        yield MenuItem::linkToCrud('JobCategory', 'fa-solid fa-gear', JobCategory::class);
        yield MenuItem::linkToCrud('Client', 'fa-solid fa-user-group', Client::class);
        yield MenuItem::linkToCrud('JobOffer', 'fa-solid fa-pen-nib', JobOffer::class);
        yield MenuItem::linkToCrud('User', 'fa-solid fa-user-check', User::class);
        yield MenuItem::linkToCrud('Media', 'fa-solid fa-photo-film', Media::class);
        yield MenuItem::linkToCrud('Apply', 'fa-solid fa-check-to-slot', Apply::class);
        yield MenuItem::linkToCrud('Candidat', 'fa-solid fa-person-circle-check', Candidat::class);
    }

}
