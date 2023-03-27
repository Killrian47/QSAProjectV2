<?php

namespace App\Controller;

use App\Entity\Echantillon;
use App\Entity\Order;
use App\Form\EchantillonType;
use App\Repository\EchantillonRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class EchantillonController extends AbstractController
{
    #[Route('/commande/{id}', name: 'app_details_order')]
    public function index(Order $order, EchantillonRepository $echantillonRepository): Response
    {
        $echantillons = $echantillonRepository->findBy(['numberOrder' => $order->getId()]);

        return $this->render('echantillon/index.html.twig', [
            'order' => $order,
            'echantillons' => $echantillons,
        ]);
    }

    #[Route('/ajouter-echantillon-manquant/{id}', name: 'app_add_missing_echantillon')]
    public function addEchantillonBeforeExportation(Order $order, EntityManagerInterface $manager, Request $request)
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

    /**
     * @throws Exception
     */
    #[Route('exportOrder/{id}', name: 'export_order')]
    public function exportData(
        Order $order,
        EchantillonRepository $echantillonRepository,
        EntityManagerInterface $manager
    ): Response
    {
        $order->setIsExported(true);
        $manager->persist($order);
        $manager->flush();
        // Récupérer les données à exporter depuis la base de données
        $data = $echantillonRepository->findBy(['numberOrder' => $order->getId()]);

        // Créer une nouvelle feuille Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Échantillons');
        // Ajouter les en-têtes de colonne
        $sheet->setCellValue('A1', 'Email de contact');
        $sheet->setCellValue('B1', 'Nom de l\'entreprise');
        $sheet->setCellValue('C1', 'Nom de l\'échantillon');
        $sheet->setCellValue('D1', 'Numéro de lot');
        $sheet->setCellValue('E1', 'Fournisseur');
        $sheet->setCellValue('F1', 'Conditionnement');
        $sheet->setCellValue('G1', 'Température de l\'échantillon');
        $sheet->setCellValue('H1', 'Température de l\'enceinte');
        $sheet->setCellValue('I1', 'Date de fabrication');
        $sheet->setCellValue('J1', 'DLC/DLUO');
        $sheet->setCellValue('K1', 'Date de prélèvement');

        // Ajouter les données à partir de la deuxième ligne
        $row = 2;
        $entreprise = '';
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->getEntreprise()->getEmail());
            $sheet->setCellValue('B' . $row, $item->getEntreprise()->getName());
            $sheet->setCellValue('C' . $row, $item->getProductName());
            $sheet->setCellValue('D' . $row, $item->getNumberLot());
            $sheet->setCellValue('E' . $row, $item->getFournisseur());
            $sheet->setCellValue('F' . $row, $item->getConditionnement());
            $sheet->setCellValue('G' . $row, $item->getTempProduct());
            $sheet->setCellValue('H' . $row, $item->getTempEnceinte());
            $sheet->setCellValue('I' . $row, $item->getDateOfManufacturing());
            $sheet->setCellValue('J' . $row, $item->getDlcDluo());
            $sheet->setCellValue('K' . $row, $item->getDatePrelevement());
            $entreprise = $item->getEntreprise()->getName();
            $row++;
        }

        $date = new DateTime();
        $todayDate = $date->format('d-m-Y');
        // Générer le fichier Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = $todayDate . '_' . $entreprise . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFile);

        $this->addFlash('success', 'Les données ont bien été exportées');

        // Retourner le fichier Excel en réponse HTTP
        return $this->file($tempFile, $fileName);


    }

}
