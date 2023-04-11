<?php

namespace App\Controller;

use App\Form\SearchEntrepriseType;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchEntrepriseController extends AbstractController
{
    #[Route('/search/entreprise', name: 'app_search_entreprise')]
    public function index(Request $request, EntrepriseRepository $entrepriseRepository, OrderRepository $orderRepository): Response
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

            }

            if ($form->get('date1')->getData() && $form->get('date2')->getData()) {
                $date1 = $form->get('date1')->getData();
                $date2 = $form->get('date2')->getData();
                $allOrders = $orderRepository->findByDate($date1, $date2);
                $orders = [];
                foreach ($allOrders as $order) {
                    if (!empty($order->getEchantillons()->toArray())) {
                        $orders[] = $order;
                    }
                }
            }


            return $this->render('admin/all_entreprise.html.twig', [
                'form' => $form->createView(),
                'entreprises' => $entreprises,
                'search' => $search,
//                'orders' => $orders,
//                'date1' => $date1,
//                'date2' => $date2,
            ]);
        }


        return $this->render('search_entreprise/index.html.twig', [
            'controller_name' => 'SearchEntrepriseController',
            'form' => $form->createView(),
        ]);
    }
}
