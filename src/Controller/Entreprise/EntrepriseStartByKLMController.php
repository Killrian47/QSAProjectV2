<?php

namespace App\Controller\Entreprise;

use App\Form\SearchEntrepriseType;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseStartByKLMController extends AbstractController
{
    #[Route('/admin/KLM', name: 'app_entreprise_KLM')]
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
        $entreprisesStartByK = [];
        $entreprisesStartByL = [];
        $entreprisesStartByM = [];
        $orderEntreprisesK = [];
        $orderEntreprisesL = [];
        $orderEntreprisesM = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'k' || $value->getName()[$i] === 'K') {
                    $entreprisesStartByK[] = $value;
                } elseif ($value->getName()[$i] === 'l' || $value->getName()[$i] === 'L') {
                    $entreprisesStartByL[] = $value;
                } elseif ($value->getName()[$i] === 'm' || $value->getName()[$i] === 'M') {
                    $entreprisesStartByM[] = $value;
                }
            }
        }
        foreach ($entreprisesStartByK as $entreprises) {
            $orderEntreprisesK[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByL as $entreprises) {
            $orderEntreprisesL[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByM as $entreprises) {
            $orderEntreprisesM[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByK' => $entreprisesStartByK,
            'entreprisesStartByL' => $entreprisesStartByL,
            'entreprisesStartByM' => $entreprisesStartByM,
            'orderForEntreprisesK' => $orderEntreprisesK,
            'orderForEntreprisesL' => $orderEntreprisesL,
            'orderForEntreprisesM' => $orderEntreprisesM,
            'form' => $form->createView()
        ]);

    }
}
