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
    public function index(EntityManagerInterface $manager): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser()->isFirstConnection() === true) {
            $this->addFlash('warning', 'Vous devez changer votre mot de passe avant de pouvoir naviguer sur le site');
            return $this->redirectToRoute('app_edit_password');
        }
        $user = $this->getUser();
        $order = new Order();
        $order->setEntreprise($user);
        $order->setIsExported(false);

        $manager->persist($order);
        $manager->flush();

        return $this->redirectToRoute('app_add_echantillon', [
            'id' => $order->getId(),
        ]);

//        return $this->render('order/index.html.twig', [
//
//        ]);
    }

    #[Route('/order/{id}', name: 'app_add_echantillon')]
    public function addEchantillon(Request $request, Order $order, EntityManagerInterface $manager)
    {
        $echantillon = new Echantillon;
        $form = $this->createForm(EchantillonType::class, $echantillon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $echantillon->setEntreprise($this->getUser());
            $echantillon->setNumberOrder($order);
            $echantillon->setConditionnement($form->get('conditionnement')->getData());
            $echantillon->setDateOfManufacturing($form->get('dateOfManufacturing')->getData());
            $echantillon->setTempEnceinte($form->get('tempEnceinte')->getData());
            $echantillon->setFournisseur($form->get('fournisseur')->getData());
            $echantillon->setTempProduct($form->get('tempProduct')->getData());
            $echantillon->setDatePrelevement($form->get('datePrelevement')->getData());
            $echantillon->setDlcDluo($form->get('DlcDluo')->getData());

            $manager->persist($echantillon);
            $manager->flush();
            return $this->redirectToRoute('app_add_echantillon', [
                'id' => $order->getId(),
            ]);
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
