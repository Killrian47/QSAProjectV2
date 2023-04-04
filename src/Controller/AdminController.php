<?php

namespace App\Controller;

use App\Repository\EchantillonRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/admin', name: 'app_admin')]
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        $totalEntreprise = $entrepriseRepository->createQueryBuilder('e')
            ->select(['count(e.id)'])
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'totalEntreprise' => $totalEntreprise
        ]);
    }

    #[Route('/admin/ABC', name: 'app_entreprise_ABC')]
    public function firstLetter(
        EntrepriseRepository $entrepriseRepository,
        OrderRepository      $orderRepository
    ): Response
    {
        $entreprises = $entrepriseRepository->findBy([], ['name' => 'ASC']);
        $entreprisesStartByA = [];
        $entreprisesStartByB = [];
        $entreprisesStartByC = [];
        $orderEntreprisesA = [];
        $orderEntreprisesB = [];
        $orderEntreprisesC = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'a' || $value->getName()[$i] === 'A') {
                    $entreprisesStartByA[] = $value;
                } elseif ($value->getName()[$i] === 'b' || $value->getName()[$i] === 'B') {
                    $entreprisesStartByB[] = $value;
                } elseif ($value->getName()[$i] === 'c' || $value->getName()[$i] === 'C') {
                    $entreprisesStartByC[] = $value;
                }
            }
        }
        foreach ($entreprisesStartByA as $entreprises) {
            $orderEntreprisesA[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByB as $entreprises) {
            $orderEntreprisesB[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByC as $entreprises) {
            $orderEntreprisesC[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByA' => $entreprisesStartByA,
            'orderForEntreprisesA' => $orderEntreprisesA,
            'entreprisesStartByB' => $entreprisesStartByB,
            'orderForEntreprisesB' => $orderEntreprisesB,
            'entreprisesStartByC' => $entreprisesStartByC,
            'orderForEntreprisesC' => $orderEntreprisesC,
        ]);
    }

    #[Route('admin/DEF', name: 'app_entreprise_DEF')]
    public function entreprisesStartByDEF(
        EntrepriseRepository $entrepriseRepository,
        OrderRepository      $orderRepository
    ): Response
    {
        $entreprises = $entrepriseRepository->findBy([], ['name' => 'ASC']);
        $entreprisesStartByD = [];
        $entreprisesStartByE = [];
        $entreprisesStartByF = [];
        $orderEntreprisesD = [];
        $orderEntreprisesE = [];
        $orderEntreprisesF = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'd' || $value->getName()[$i] === 'F') {
                    $entreprisesStartByD[] = $value;
                } elseif ($value->getName()[$i] === 'e' || $value->getName()[$i] === 'E') {
                    $entreprisesStartByE[] = $value;
                } elseif ($value->getName()[$i] === 'f' || $value->getName()[$i] === 'F') {
                    $entreprisesStartByF[] = $value;
                }
            }
        }
        foreach ($entreprisesStartByD as $entreprises) {
            $orderEntreprisesD[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByE as $entreprises) {
            $orderEntreprisesE[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByF as $entreprises) {
            $orderEntreprisesF[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByD' => $entreprisesStartByD,
            'orderForEntreprisesD' => $orderEntreprisesD,
            'entreprisesStartByE' => $entreprisesStartByE,
            'orderForEntreprisesE' => $orderEntreprisesE,
            'entreprisesStartByF' => $entreprisesStartByF,
            'orderForEntreprisesF' => $orderEntreprisesF,
        ]);
    }

    #[Route('admin/GHIJ', name: 'app_entreprise_GHIJ')]
    public function entreprisesStartByGHIJ(
        EntrepriseRepository $entrepriseRepository,
        OrderRepository      $orderRepository
    ): Response
    {
        $entreprises = $entrepriseRepository->findBy([], ['name' => 'ASC']);
        $entreprisesStartByG = [];
        $entreprisesStartByH = [];
        $entreprisesStartByI = [];
        $entreprisesStartByJ = [];
        $orderEntreprisesG = [];
        $orderEntreprisesH = [];
        $orderEntreprisesI = [];
        $orderEntreprisesJ = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'g' || $value->getName()[$i] === 'G') {
                    $entreprisesStartByG[] = $value;
                } elseif ($value->getName()[$i] === 'h' || $value->getName()[$i] === 'H') {
                    $entreprisesStartByH[] = $value;
                } elseif ($value->getName()[$i] === 'i' || $value->getName()[$i] === 'I') {
                    $entreprisesStartByI[] = $value;
                } elseif ($value->getName()[$i] === 'j' || $value->getName()[$i] === 'J') {
                    $entreprisesStartByJ[] = $value;
                }
            }
        }
        foreach ($entreprisesStartByG as $entreprises) {
            $orderEntreprisesG[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByH as $entreprises) {
            $orderEntreprisesH[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByI as $entreprises) {
            $orderEntreprisesI[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByJ as $entreprises) {
            $orderEntreprisesJ[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByG' => $entreprisesStartByG,
            'orderForEntreprisesG' => $orderEntreprisesG,
            'entreprisesStartByH' => $entreprisesStartByH,
            'orderForEntreprisesH' => $orderEntreprisesH,
            'entreprisesStartByI' => $entreprisesStartByI,
            'orderForEntreprisesI' => $orderEntreprisesI,
            'entreprisesStartByJ' => $entreprisesStartByJ,
            'orderForEntreprisesJ' => $orderEntreprisesJ,
        ]);
    }

    #[Route('admin/KLM', name: 'app_entreprise_KLM')]
    public function entreprisesStartByKLM(
        EntrepriseRepository $entrepriseRepository,
        OrderRepository      $orderRepository
    ): Response
    {
        $entreprises = $entrepriseRepository->findBy([], ['name' => 'ASC']);
        $entreprisesStartByK = [];
        $entreprisesStartByL = [];
        $entreprisesStartByM = [];
        $orderEntreprisesK = [];
        $orderEntreprisesL = [];
        $orderEntreprisesM = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'k' || $value->getName()[$i] === 'K') {
                    $entreprisesStartByK[] = $value;
                } elseif ($value->getName()[$i] === 'l' || $value->getName()[$i] === 'L') {
                    $entreprisesStartByL[] = $value;
                } elseif ($value->getName()[$i] === 'm' || $value->getName()[$i] === 'M') {
                    $entreprisesStartByM[] = $value;
                }
            }
        }
        foreach ($entreprisesStartByK as $entreprises) {
            $orderEntreprisesK[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByL as $entreprises) {
            $orderEntreprisesL[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByM as $entreprises) {
            $orderEntreprisesM[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByK' => $entreprisesStartByK,
            'entreprisesStartByL' => $entreprisesStartByL,
            'entreprisesStartByM' => $entreprisesStartByM,
            'orderForEntreprisesK' => $orderEntreprisesK,
            'orderForEntreprisesL' => $orderEntreprisesL,
            'orderForEntreprisesM' => $orderEntreprisesM,
        ]);
    }

    #[Route('admin/NOPQ', name: 'app_entreprise_NOPQ')]
    public function entreprisesStartByNOPQ(
        EntrepriseRepository $entrepriseRepository,
        OrderRepository      $orderRepository,
    ): Response
    {
        $entreprises = $entrepriseRepository->findBy([], ['name' => 'ASC']);
        $entreprisesStartByN = [];
        $entreprisesStartByO = [];
        $entreprisesStartByP = [];
        $entreprisesStartByQ = [];
        $orderEntreprisesN = [];
        $orderEntreprisesO = [];
        $orderEntreprisesP = [];
        $orderEntreprisesQ = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'n' || $value->getName()[$i] === 'N') {
                    $entreprisesStartByN[] = $value;
                } elseif ($value->getName()[$i] === 'o' || $value->getName()[$i] === 'O') {
                    $entreprisesStartByO[] = $value;
                } elseif ($value->getName()[$i] === 'p' || $value->getName()[$i] === 'P') {
                    $entreprisesStartByP[] = $value;
                } elseif ($value->getName()[$i] === 'q' || $value->getName()[$i] === 'Q') {
                    $entreprisesStartByQ[] = $value;
                }
            }
        }
        foreach ($entreprisesStartByN as $entreprises) {
            $orderEntreprisesN[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByO as $entreprises) {
            $orderEntreprisesO[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByP as $entreprises) {
            $orderEntreprisesP[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByQ as $entreprises) {
            $orderEntreprisesQ[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByN' => $entreprisesStartByN,
            'entreprisesStartByO' => $entreprisesStartByO,
            'entreprisesStartByP' => $entreprisesStartByP,
            'entreprisesStartByQ' => $entreprisesStartByQ,
            'orderForEntreprisesN' => $orderEntreprisesN,
            'orderForEntreprisesO' => $orderEntreprisesO,
            'orderForEntreprisesP' => $orderEntreprisesP,
            'orderForEntreprisesQ' => $orderEntreprisesQ,
        ]);
    }

    #[Route('admin/RSTU', name: 'app_entreprise_RSTU')]
    public function entreprisesStartByRSTU(
        EntrepriseRepository $entrepriseRepository,
        OrderRepository      $orderRepository
    ): Response
    {
        $entreprises = $entrepriseRepository->findBy([], ['name' => 'ASC']);
        $entreprisesStartByR = [];
        $entreprisesStartByS = [];
        $entreprisesStartByT = [];
        $entreprisesStartByU = [];
        $orderEntreprisesR = [];
        $orderEntreprisesS = [];
        $orderEntreprisesT = [];
        $orderEntreprisesU = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'r' || $value->getName()[$i] === 'R') {
                    $entreprisesStartByR[] = $value;
                } elseif ($value->getName()[$i] === 's' || $value->getName()[$i] === 'S') {
                    $entreprisesStartByS[] = $value;
                } elseif ($value->getName()[$i] === 't' || $value->getName()[$i] === 'T') {
                    $entreprisesStartByT[] = $value;
                } elseif ($value->getName()[$i] === 'u' || $value->getName()[$i] === 'U') {
                    $entreprisesStartByU[] = $value;
                }
            }
        }
        foreach ($entreprisesStartByR as $entreprises) {
            $orderEntreprisesR[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByS as $entreprises) {
            $orderEntreprisesS[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByT as $entreprises) {
            $orderEntreprisesT[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        foreach ($entreprisesStartByU as $entreprises) {
            $orderEntreprisesU[] = $orderRepository->findBy(['entreprise' => $entreprises], ['createdAt' => 'DESC']);
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByR' => $entreprisesStartByR,
            'entreprisesStartByS' => $entreprisesStartByS,
            'entreprisesStartByT' => $entreprisesStartByT,
            'entreprisesStartByU' => $entreprisesStartByU,
            'orderForEntreprisesN' => $orderEntreprisesR,
            'orderForEntreprisesO' => $orderEntreprisesS,
            'orderForEntreprisesP' => $orderEntreprisesT,
            'orderForEntreprisesQ' => $orderEntreprisesU,
        ]);
    }

    #[Route('admin/VWXYZ', name: 'app_entreprise_VWXYZ')]
    public function entreprisesStartByVWXYZ(EntrepriseRepository $entrepriseRepository): Response
    {
        $entreprises = $entrepriseRepository->findAll();
        $entreprisesStartByV = [];
        $entreprisesStartByW = [];
        $entreprisesStartByX = [];
        $entreprisesStartByY = [];
        $entreprisesStartByZ = [];
        foreach ($entreprises as $value) {
            for ($i = 0; $i < 1; $i++) {
                if ($value->getName()[$i] === 'v' || $value->getName()[$i] === 'V') {
                    $entreprisesStartByV[] = $value;
                } elseif ($value->getName()[$i] === 'w' || $value->getName()[$i] === 'W') {
                    $entreprisesStartByW[] = $value;
                } elseif ($value->getName()[$i] === 'x' || $value->getName()[$i] === 'X') {
                    $entreprisesStartByX[] = $value;
                } elseif ($value->getName()[$i] === 'y' || $value->getName()[$i] === 'Y') {
                    $entreprisesStartByY[] = $value;
                } elseif ($value->getName()[$i] === 'z' || $value->getName()[$i] === 'Z') {
                    $entreprisesStartByZ[] = $value;
                }
            }
        }
        return $this->render('admin/all_entreprise.html.twig', [
            'entreprisesStartByV' => $entreprisesStartByV,
            'entreprisesStartByW' => $entreprisesStartByW,
            'entreprisesStartByX' => $entreprisesStartByX,
            'entreprisesStartByY' => $entreprisesStartByY,
            'entreprisesStartByZ' => $entreprisesStartByZ,
        ]);
    }
}
