<?php

namespace App\Controller;

use App\Repository\EchantillonRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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

    #[Route('/admin', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function adminSide(EntrepriseRepository $entrepriseRepository, EntityManagerInterface $manager): Response
    {
        $allEntrepriseWithoutAdmin = [];
        $entreprises = $entrepriseRepository->startedByA($manager);
        dd($entreprises);


        foreach ($entreprises as $entreprise) {
            if ($this->getUser() !== $entreprise) {
                $allEntrepriseWithoutAdmin[] = $entreprise;
            }
        }

        return $this->render('home/all_entreprise.html.twig', [
            'entreprises' => $allEntrepriseWithoutAdmin
        ]);
    }
}
