<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        if ($this->getUser() === null) {
            $this->redirectToRoute('app_login');
        }


        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    #[Route('/compte/modifier-mot-de-passe', name: 'app_edit_password')]
    public function changePassword()
    {
        return $this->render('account/password.html.twig');
    }
}
