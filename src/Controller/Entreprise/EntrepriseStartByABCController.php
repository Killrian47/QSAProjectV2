<?php

namespace App\Controller\Entreprise;

use App\Form\SearchEntrepriseType;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseStartByABCController extends AbstractController
{
    #[Route('/admin/ABC', name: 'app_entreprise_ABC')]
    public function index(
        EntrepriseRepository $entrepriseRepository,
        OrderRepository      $orderRepository,
        Request              $request
    ): Response
    {
        $form = $this->createForm(SearchEntrepriseType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
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
        $entreprises = $entrepriseRepository->findBy([], ['name' => 'ASC']);
        $entreprisesStartByA = [];
        $entreprisesStartByB = [];
        $entreprisesStartByC = [];
        $orderEntreprisesA = [];
        $orderEntreprisesB = [];
        $orderEntreprisesC = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'a' || $value->getName()[$i] === 'A') {
                    $entreprisesStartByA[] = $value;
                } elseif ($value->getName()[$i] === 'b' || $value->getName()[$i] === 'B') {
                    $entreprisesStartByB[] = $value;
                } elseif ($value->getName()[$i] === 'c' || $value->getName()[$i] === 'C') {
                    $entreprisesStartByC[] = $value;
                }
            }
        }
        foreach ($entreprisesStartByA as $entreprises) {
            $orderEntreprisesA[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByB as $entreprises) {
            $orderEntreprisesB[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByC as $entreprises) {
            $orderEntreprisesC[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByA' => $entreprisesStartByA,
            'orderForEntreprisesA' => $orderEntreprisesA,
            'entreprisesStartByB' => $entreprisesStartByB,
            'orderForEntreprisesB' => $orderEntreprisesB,
            'entreprisesStartByC' => $entreprisesStartByC,
            'orderForEntreprisesC' => $orderEntreprisesC,
            'form' => $form->createView(),
        ]);
    }
}
