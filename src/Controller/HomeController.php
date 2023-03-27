<?php

namespace App\Controller;

use App\Repository\EchantillonRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EchantillonRepository $echantillonRepository, OrderRepository $orderRepository): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser()->isFirstConnection() === true) {
            $this->addFlash('warning', 'Vous devez changer votre mot de passe avant de pouvoir naviguer sur le site');
            return $this->redirectToRoute('app_edit_password');
        }

        $echantillons = [];
        $user = $this->getUser();
        $orders = $orderRepository->findBy(['entreprise' => $user]);
        foreach ($orders as $order) {
            $echantillons[] = $echantillonRepository->findBy(['numberOrder' => $order]);
        }

        $adminView = $orderRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'echantillons' => $echantillons,
            'orders' => $orders,
            'adminView' => $adminView,
        ]);
    }

}
