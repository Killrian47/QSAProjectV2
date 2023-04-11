<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(PaginatorInterface $paginator, Request $request, EntityManagerInterface $manager): Response
    {
        $query = $manager->createQuery('SELECT e FROM App\Entity\Echantillon e');
        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 10);
        return $this->render('test/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
