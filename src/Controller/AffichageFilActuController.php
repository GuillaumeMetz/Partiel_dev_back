<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AffichageFilActuController extends AbstractController
{
    #[Route('/affichage/fil/actu', name: 'app_affichage_fil_actu')]
    public function index(): Response
    {
        return $this->render('affichage_fil_actu/index.html.twig', [
            'controller_name' => 'AffichageFilActuController',
        ]);
    }
}
