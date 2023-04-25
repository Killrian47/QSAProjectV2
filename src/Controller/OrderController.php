<?php

namespace App\Controller;

use App\Entity\Echantillon;
use App\Entity\Order;
use App\Form\EchantillonType;
use App\Repository\EchantillonRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class OrderController extends AbstractController
{

    #[Route('/choisir-la-méthode-pour-envoyer-des-échantillons', name: 'app_choose_method')]
    public function selectMethodToAddEchantillon()
    {
        return $this->render('order/index.html.twig');
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/ajouter-des-échantillons-un-par-un', name: 'app_order_one_by_one')]
    public function orderAddEchantillonOneByOne(EntityManagerInterface $manager): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser()->isFirstConnection() === true) {
            $this->addFlash('warning', 'Vous devez changer votre mot de passe avant de pouvoir naviguer sur le site');
            return $this->redirectToRoute('app_edit_password');
        }

        date_default_timezone_set('Europe/Paris');
        $user = $this->getUser();
        $order = new Order();
        $order->setEntreprise($user);
        $order->setIsExported(false);
        $order->setCreatedAt(new \DateTime());

        $manager->persist($order);
        $manager->flush();

        return $this->redirectToRoute('app_add_echantillon', [
            'id' => $order->getId(),
        ]);

    }

    #[Route('/ajouter-des-échantillons-un-par-un/{id}', name: 'app_add_echantillon')]
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
            $echantillon->setDlcDluo($form->get('dlcDluo')->getData());

            $manager->persist($echantillon);
            $manager->flush();
            return $this->redirectToRoute('app_add_echantillon', [
                'id' => $order->getId(),
            ]);
        }

        return $this->render('order/addOneByOne.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/par-un-excel', name: 'app_order_by_excel')]
    public function orderAddEchantillonByexcel(EntityManagerInterface $manager): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser()->isFirstConnection() === true) {
            $this->addFlash('warning', 'Vous devez changer votre mot de passe avant de pouvoir naviguer sur le site');
            return $this->redirectToRoute('app_edit_password');
        }

        date_default_timezone_set('Europe/Paris');
        $user = $this->getUser();
        $order = new Order();
        $order->setEntreprise($user);
        $order->setIsExported(false);
        $order->setCreatedAt(new \DateTime());

        $manager->persist($order);
        $manager->flush();

        return $this->redirectToRoute('app_add_echantillon_by_excel', [
            'id' => $order->getId(),
        ]);

    }

    #[Route('/par-excel/{id}', name: 'app_add_echantillon_by_excel')]
    public function addEchantillonByExcel(Request $request, Order $order, EntityManagerInterface $manager)
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
            $echantillon->setDlcDluo($form->get('dlcDluo')->getData());

            $manager->persist($echantillon);
            $manager->flush();
            return $this->redirectToRoute('app_add_echantillon_by_excel', [
                'id' => $order->getId(),
            ]);
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/supprimer-bon-de-commande-sans-échantillons', name: 'app_delete_all_orders_without_echantillons')]
    #[IsGranted("ROLE_ADMIN")]
    public function deleteOrder(EntityManagerInterface $manager, OrderRepository $orderRepository, Request $request): RedirectResponse
    {
        $orders = $orderRepository->findAll();
        foreach ($orders as $order) {
            if (empty($order->getEchantillons()->toArray())) {
                $manager->remove($order);
            }
        }
        $manager->flush();

        $this->addFlash('success', 'Tous les bons de commandes sans échantillons ont été supprimés !');
        return $this->redirectToRoute('app_admin');
    }
}
