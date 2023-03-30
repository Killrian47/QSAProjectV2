<?php

namespace App\Controller;

use App\Entity\PDF;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    #[Route('/pdf/{slug}', name: 'app_pdf')]
    public function afficherPdf(string $slug, PDF $PDF): Response
    {
        $pathFile = $this->getParameter('pdf_dir').'/'. $PDF->getFile();

        // Vérifie si le fichier existe
        if (!file_exists($pathFile)) {
            throw $this->createNotFoundException('Le fichier PDF demandé n\'existe pas.');
        }

        // Créer la réponse du fichier
        $response = new BinaryFileResponse($pathFile);
        $response->headers->set('Content-Type', 'application/pdf');

        // Ajouter un header pour forcer le téléchargement
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $slug
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
