<?php

namespace App\Controller\Entreprise;

use App\Form\SearchEntrepriseType;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseStartByVWXYZController extends AbstractController
{
    #[Route('/admin/VWXYZ', name: 'app_entreprise_VWXYZ')]
    public function index(
        EntrepriseRepository $entrepriseRepository,
        OrderRepository      $orderRepository,
        Request              $request,
    ): Response
    {
        $form = $this->createForm(SearchEntrepriseType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->get('search')->getData() && $form->get('date1')->getData() ||
                $form->get('search')->getData() && $form->get('date2')->getData() ||
                $form->get('search')->getData() && $form->get('date1')->getData() && $form->get('date2')->getData()
            ) {
                $this->addFlash('danger', 'Il faut rechercher soit par nom de l\'entreprise soit entre la 1ère et la 2ème date');

                return $this->redirectToRoute('app_search_entreprise');
            }

            if ($form->get('search')->getData()) {
                $search = $form->get('search')->getData();
                $entreprises = $entrepriseRepository->findByEntrepriseName($search);

                return $this->render('admin/all_entreprise.html.twig', [
                    'form' => $form->createView(),
                    'entreprises' => $entreprises,
                    'search' => $search,
                ]);
            }
            if ($form->get('date1')->getData() && $form->get('date2')->getData()) {
                $date1 = $form->get('date1')->getData();
                $date2 = $form->get('date2')->getData();
                $allOrders = $orderRepository->findByDate($date1, $date2);
                $orders = [];
                if (isset($allOrders)) {
                    foreach ($allOrders as $order) {
                        if (!empty($order->getEchantillons()->toArray())) {
                            $orders[] = $order;
                        }
                    }
                }

                return $this->render('admin/all_entreprise.html.twig', [
                    'form' => $form->createView(),
                    'orders' => $orders,
                    'date1' => $date1,
                    'date2' => $date2,
                ]);
            }
        }
        $entreprises = $entrepriseRepository->findAll();
        $entreprisesStartByV = [];
        $entreprisesStartByW = [];
        $entreprisesStartByX = [];
        $entreprisesStartByY = [];
        $entreprisesStartByZ = [];
        $orderEntreprisesV = [];
        $orderEntreprisesW = [];
        $orderEntreprisesX = [];
        $orderEntreprisesY = [];
        $orderEntreprisesZ = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'v' || $value->getName()[$i] === 'V') {
                    $entreprisesStartByV[] = $value;
                } elseif ($value->getName()[$i] === 'w' || $value->getName()[$i] === 'W') {
                    $entreprisesStartByW[] = $value;
                } elseif ($value->getName()[$i] === 'x' || $value->getName()[$i] === 'X') {
                    $entreprisesStartByX[] = $value;
                } elseif ($value->getName()[$i] === 'y' || $value->getName()[$i] === 'Y') {
                    $entreprisesStartByY[] = $value;
                } elseif ($value->getName()[$i] === 'z' || $value->getName()[$i] === 'Z') {
                    $entreprisesStartByZ[] = $value;
                }
            }
        }
        foreach ($entreprisesStartByV as $entreprises) {
            $orderEntreprisesV[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByW as $entreprises) {
            $orderEntreprisesW[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByX as $entreprises) {
            $orderEntreprisesX[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByY as $entreprises) {
            $orderEntreprisesY[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByZ as $entreprises) {
            $orderEntreprisesZ[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByV' => $entreprisesStartByV,
            'entreprisesStartByW' => $entreprisesStartByW,
            'entreprisesStartByX' => $entreprisesStartByX,
            'entreprisesStartByY' => $entreprisesStartByY,
            'entreprisesStartByZ' => $entreprisesStartByZ,
            'orderForEntreprisesV' => $orderEntreprisesV,
            'orderForEntreprisesW' => $orderEntreprisesW,
            'orderForEntreprisesX' => $orderEntreprisesX,
            'orderForEntreprisesY' => $orderEntreprisesY,
            'orderForEntreprisesZ' => $orderEntreprisesZ,
            'form' => $form
        ]);
    }
}
