<?php

namespace App\Controller\Entreprise;

use App\Form\SearchEntrepriseType;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseStartByDEFController extends AbstractController
{
    #[Route('/admin/DEF', name: 'app_entreprise_DEF')]
    public function index(
        EntrepriseRepository $entrepriseRepository,
        OrderRepository      $orderRepository,
        Request $request,
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
                $allOrders = $orderRepository->findByTwoDate($date1, $date2);
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
        $entreprisesStartByD = [];
        $entreprisesStartByE = [];
        $entreprisesStartByF = [];
        $orderEntreprisesD = [];
        $orderEntreprisesE = [];
        $orderEntreprisesF = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'd' || $value->getName()[$i] === 'F') {
                    $entreprisesStartByD[] = $value;
                } elseif ($value->getName()[$i] === 'e' || $value->getName()[$i] === 'E') {
                    $entreprisesStartByE[] = $value;
                } elseif ($value->getName()[$i] === 'f' || $value->getName()[$i] === 'F') {
                    $entreprisesStartByF[] = $value;
                }
            }
        }
        foreach ($entreprisesStartByD as $entreprises) {
            $orderEntreprisesD[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByE as $entreprises) {
            $orderEntreprisesE[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByF as $entreprises) {
            $orderEntreprisesF[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByD' => $entreprisesStartByD,
            'orderForEntreprisesD' => $orderEntreprisesD,
            'entreprisesStartByE' => $entreprisesStartByE,
            'orderForEntreprisesE' => $orderEntreprisesE,
            'entreprisesStartByF' => $entreprisesStartByF,
            'orderForEntreprisesF' => $orderEntreprisesF,
            'form' => $form->createView()
        ]);
    }
}
