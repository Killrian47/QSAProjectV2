<?php

namespace App\Controller;

use App\Form\SearchEntrepriseType;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/admin', name: 'app_admin')]
    #[IsGranted("ROLE_ADMIN")]
    public function index(
        EntrepriseRepository $entrepriseRepository,
        OrderRepository      $orderRepository,
        Request              $request
    ): Response
    {
        $form = $this->createForm(SearchEntrepriseType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->get('search')->getData() && $form->get('date1')->getData() && $form->get('date2')->getData()) {
                $search = $form->getData()['search'];
                $date1 = $form->get('date1')->getData();
                $date2 = $form->get('date2')->getData();
                $interval = $date1->diff($date2);
                if ($interval->d == 0) {
                    $date2->modify('+23 hour 59 minutes 59 seconds');
                }
                $allOrders = [];
                $orders = [];
                $entreprises = $entrepriseRepository->findByEntrepriseName($search);
                foreach ($entreprises as $entreprise) {
                    $allOrders[] = $orderRepository->findByEntrepriseAndDate($entreprise->getId(), $date1, $date2);
                }
                foreach ($allOrders as $order) {
                    foreach ($order as $value) {
                        if (!empty($value->getEchantillons()->toArray())) {
                            $orders[] = $value;
                        }
                    }
                }
                return $this->render('admin/entreprise/searchEntrepriseAndOrder.html.twig', [
                    'form' => $form->createView(),
                    'entreprises' => $entreprises,
                    'search' => $search,
                    'orders' => $orders,
                    'date1' => $date1,
                    'date2' => $date2,
                ]);
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
                $interval = $date1->diff($date2);
                if ($interval->d == 0) {
                    $date2->modify('+23 hour 59 minutes 59 seconds');
                }
                $allOrders = $orderRepository->findByTwoDate($date1, $date2);
                $orders = [];
                foreach ($allOrders as $order) {
                    if (!empty($order->getEchantillons()->toArray())) {
                        $orders[] = $order;
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

        $totalEntreprise = $entrepriseRepository->createQueryBuilder('e')
            ->select(['count(e.id)'])
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('admin/index.html.twig', ['controller_name' => 'AdminController',
            'totalEntreprise' => $totalEntreprise,
            'form' => $form->createView(),]);

    }
}
