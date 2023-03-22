<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class OrderController extends AbstractController
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/order', name: 'app_order')]
//    #[IsGranted()]
    public function index(EntityManagerInterface $manager): Response
    {
        // mettre compteur pour ne pas créer plusieurs commandes !
        if ($this->getUser()) {
            if ($this->getUser()->getId() === 1) {
                dd('test');
            } else {
                $order = new Order;
                $order->setEntreprise($this->getUser());
                $manager->persist($order);
                $manager->flush();
            }
        }


        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }
}
