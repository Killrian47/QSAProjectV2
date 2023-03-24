<?php

namespace App\Controller;

use App\Entity\Echantillon;
use App\Entity\Order;
use App\Form\EchantillonType;
use App\Repository\EchantillonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class EchantillonController extends AbstractController
{
    #[Route('/commande/{id}', name: 'app_details_order')]
    public function index(Order $order, EchantillonRepository $echantillonRepository): Response
    {
        $echantillons = $echantillonRepository->findBy(['numberOrder'=> $order->getId()]);

        return $this->render('echantillon/index.html.twig', [
            'order' => $order,
            'echantillons' => $echantillons,
        ]);
    }

    #[Route('/ajouter-echantillon-manquant/{id}', name: 'app_add_missing_echantillon')]
    public function addEchantillonBeforeExportation(Order $order,EntityManagerInterface $manager, Request $request)
    {
        $echantillon = new Echantillon;
        $form = $this->createForm(EchantillonType::class, $echantillon);
        $form->handleRequest($request);

        if ($order->isIsExported() === true) {
            $this->addFlash('info', 'Ce bon de commande à déjà été exporté par QSA');
            return $this->redirectToRoute('app_home');
        }

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
            return $this->redirectToRoute('app_details_order', [
                'id' => $order->getId(),
            ]);
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
