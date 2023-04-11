<?php

namespace App\Controller\Entreprise;

use App\Form\SearchEntrepriseType;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseStartByNOPQController extends AbstractController
{
    #[Route('/admin/NOPQ', name: 'app_entreprise_NOPQ')]
    public function index(
        EntrepriseRepository $entrepriseRepository,
        OrderRepository      $orderRepository,
        Request $request
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
        $entreprisesStartByN = [];
        $entreprisesStartByO = [];
        $entreprisesStartByP = [];
        $entreprisesStartByQ = [];
        $orderEntreprisesN = [];
        $orderEntreprisesO = [];
        $orderEntreprisesP = [];
        $orderEntreprisesQ = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'n' || $value->getName()[$i] === 'N') {
                    $entreprisesStartByN[] = $value;
                } elseif ($value->getName()[$i] === 'o' || $value->getName()[$i] === 'O') {
                    $entreprisesStartByO[] = $value;
                } elseif ($value->getName()[$i] === 'p' || $value->getName()[$i] === 'P') {
                    $entreprisesStartByP[] = $value;
                } elseif ($value->getName()[$i] === 'q' || $value->getName()[$i] === 'Q') {
                    $entreprisesStartByQ[] = $value;
                }
            }
        }
        foreach ($entreprisesStartByN as $entreprises) {
            $orderEntreprisesN[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByO as $entreprises) {
            $orderEntreprisesO[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByP as $entreprises) {
            $orderEntreprisesP[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByQ as $entreprises) {
            $orderEntreprisesQ[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByN' => $entreprisesStartByN,
            'entreprisesStartByO' => $entreprisesStartByO,
            'entreprisesStartByP' => $entreprisesStartByP,
            'entreprisesStartByQ' => $entreprisesStartByQ,
            'orderForEntreprisesN' => $orderEntreprisesN,
            'orderForEntreprisesO' => $orderEntreprisesO,
            'orderForEntreprisesP' => $orderEntreprisesP,
            'orderForEntreprisesQ' => $orderEntreprisesQ,
            'form' => $form->createView()
        ]);
    }
}
