<?php

namespace App\Controller;

use App\Entity\Entreprise;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise/{id}', name: 'app_entreprise')]
    public function index(Entreprise $entreprise): Response
    {

        return $this->render('entreprise/index.html.twig', [
            'entreprise' => $entreprise
        ]);
    }
}
