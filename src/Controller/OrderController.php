<?php

namespace App\Controller;

use App\Entity\Echantillon;
use App\Entity\Order;
use App\Form\EchantillonType;
use App\Repository\EchantillonRepository;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
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

//        dd($this->getUser()->getRoles());
        $roles = ["ROLE_ADMIN", "ROLE_USER"];

        if ($this->getUser()->getRoles() === $roles) {
            $this->addFlash('danger', 'En tant qu\'administrateur du site vous ne pouvez pas créer de bon de commande ');
            return $this->redirectToRoute('app_home');
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
            $echantillon->setDlcDluo($form->get('dlcDluo')->getData());

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
