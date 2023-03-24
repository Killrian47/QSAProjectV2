<?php

namespace App\Controller;

use App\Entity\Echantillon;
use App\Entity\Order;
use App\Form\EchantillonType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(EntityManagerInterface $manager, Request $request): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser()->isFirstConnection() === true) {
            $this->addFlash('warning', 'Vous devez changer votre mot de passe avant de pouvoir naviguer sur le site');
            return $this->redirectToRoute('app_edit_password');
        }

        // mettre compteur pour ne pas créer plusieurs commandes !
        $count =0;
        $echantillon = new Echantillon;
        $form = $this->createForm(EchantillonType::class, $echantillon);
        $form->handleRequest($request);
        if ($this->getUser()) {

            if ($form->isSubmitted()) {
                $user = $this->getUser();
                $order = new Order();

                if ($count <= 0) {
                    $order->setEntreprise($user);
                    $order->setIsExported(false);
                    $manager->persist($order);
                    $manager->flush();

                }

                $echantillon->setEntreprise($user);
                $echantillon->setNumberOrder($order);

                $manager->persist($echantillon);
                $manager->flush();

            }
        } else {
            return $this->redirectToRoute('app_login');
        }


        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'form' => $form->createView(),
        ]);
    }
}
