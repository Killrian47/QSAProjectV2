<?php

namespace App\Controller\Entreprise;

use App\Form\SearchEntrepriseType;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseStartByGHIJController extends AbstractController
{
    #[Route('/admin/GHIJ', name: 'app_entreprise_GHIJ')]
    public function index(
        EntrepriseRepository $entrepriseRepository,
        OrderRepository $orderRepository,
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
        $entreprisesStartByG = [];
        $entreprisesStartByH = [];
        $entreprisesStartByI = [];
        $entreprisesStartByJ = [];
        $orderEntreprisesG = [];
        $orderEntreprisesH = [];
        $orderEntreprisesI = [];
        $orderEntreprisesJ = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'g' || $value->getName()[$i] === 'G') {
                    $entreprisesStartByG[] = $value;
                } elseif ($value->getName()[$i] === 'h' || $value->getName()[$i] === 'H') {
                    $entreprisesStartByH[] = $value;
                } elseif ($value->getName()[$i] === 'i' || $value->getName()[$i] === 'I') {
                    $entreprisesStartByI[] = $value;
                } elseif ($value->getName()[$i] === 'j' || $value->getName()[$i] === 'J') {
                    $entreprisesStartByJ[] = $value;
                }
            }
        }
        foreach ($entreprisesStartByG as $entreprises) {
            $orderEntreprisesG[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByH as $entreprises) {
            $orderEntreprisesH[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByI as $entreprises) {
            $orderEntreprisesI[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByJ as $entreprises) {
            $orderEntreprisesJ[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByG' => $entreprisesStartByG,
            'orderForEntreprisesG' => $orderEntreprisesG,
            'entreprisesStartByH' => $entreprisesStartByH,
            'orderForEntreprisesH' => $orderEntreprisesH,
            'entreprisesStartByI' => $entreprisesStartByI,
            'orderForEntreprisesI' => $orderEntreprisesI,
            'entreprisesStartByJ' => $entreprisesStartByJ,
            'orderForEntreprisesJ' => $orderEntreprisesJ,
            'form' => $form->createView()
        ]);
    }
}
