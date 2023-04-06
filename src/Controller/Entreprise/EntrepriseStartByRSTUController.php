<?php

namespace App\Controller\Entreprise;

use App\Form\SearchEntrepriseType;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseStartByRSTUController extends AbstractController
{
    #[Route('/admin/RSTU', name: 'app_entreprise_RSTU')]
    public function index(
        EntrepriseRepository $entrepriseRepository,
        OrderRepository      $orderRepository,
         Request $request
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
        $entreprisesStartByR = [];
        $entreprisesStartByS = [];
        $entreprisesStartByT = [];
        $entreprisesStartByU = [];
        $orderEntreprisesR = [];
        $orderEntreprisesS = [];
        $orderEntreprisesT = [];
        $orderEntreprisesU = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'r' || $value->getName()[$i] === 'R') {
                    $entreprisesStartByR[] = $value;
                } elseif ($value->getName()[$i] === 's' || $value->getName()[$i] === 'S') {
                    $entreprisesStartByS[] = $value;
                } elseif ($value->getName()[$i] === 't' || $value->getName()[$i] === 'T') {
                    $entreprisesStartByT[] = $value;
                } elseif ($value->getName()[$i] === 'u' || $value->getName()[$i] === 'U') {
                    $entreprisesStartByU[] = $value;
                }
            }
        }
        foreach ($entreprisesStartByR as $entreprises) {
            $orderEntreprisesR[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByS as $entreprises) {
            $orderEntreprisesS[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByT as $entreprises) {
            $orderEntreprisesT[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByU as $entreprises) {
            $orderEntreprisesU[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByR' => $entreprisesStartByR,
            'entreprisesStartByS' => $entreprisesStartByS,
            'entreprisesStartByT' => $entreprisesStartByT,
            'entreprisesStartByU' => $entreprisesStartByU,
            'orderForEntreprisesR' => $orderEntreprisesR,
            'orderForEntreprisesS' => $orderEntreprisesS,
            'orderForEntreprisesT' => $orderEntreprisesT,
            'orderForEntreprisesU' => $orderEntreprisesU,
            'form' => $form->createView()
        ]);
    }
}
