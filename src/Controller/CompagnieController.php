<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CompagnieController extends AbstractController
{
    #[Route('/compagnie', name: 'app_compagnie')]
    public function index(): Response
    {
        return $this->render('compagnie/index.html.twig', [
            'controller_name' => 'CompagnieController',
        ]);
    }
}
