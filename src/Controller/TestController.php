<?php

namespace App\Controller;

use App\Entity\PDF;
use App\Form\PDFType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(Request $request, SluggerInterface $slugger, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(PDFType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pdf = new PDF();
            $fileName = $form->get('file')->getData();

            if ($fileName) {

                $originaleFileName = pathinfo($fileName->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originaleFileName);
                $newFileName = $safeFileName . '_' . uniqid() . '.' . $fileName->guessExtension();

                try {
                    $fileName->move(
                        $this->getParameter('pdf_dir'),
                        $newFileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $pdf->setFile($newFileName);

            }


            $manager->persist($pdf);
            $manager->flush();
        }


        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'form' => $form->createView()
        ]);
    }
}
