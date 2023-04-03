<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
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

    #[Route('/admin/{letter}', name: 'app_entreprise')]
    public function firstLetter(string $letter, EntrepriseRepository $entrepriseRepository): Response
    {
        $entreprises = $entrepriseRepository->findBy([], ['name' => 'ASC']);
        $entreprisesStartByA = [];
        $entreprisesStartByB = [];
        $entreprisesStartByC = [];
        $entreprisesStartByD = [];
        $entreprisesStartByE = [];
        $entreprisesStartByF = [];
        $entreprisesStartByG = [];
        $entreprisesStartByH = [];
        $entreprisesStartByI = [];
        $entreprisesStartByJ = [];
        $entreprisesStartByK = [];
        $entreprisesStartByL = [];
        $entreprisesStartByM = [];
        $entreprisesStartByN = [];
        $entreprisesStartByO = [];
        $entreprisesStartByP = [];
        $entreprisesStartByQ = [];
        $entreprisesStartByR = [];
        $entreprisesStartByS = [];
        $entreprisesStartByT = [];
        $entreprisesStartByU = [];
        $entreprisesStartByV = [];
        $entreprisesStartByW = [];
        $entreprisesStartByX = [];
        $entreprisesStartByY = [];
        $entreprisesStartByZ = [];
        if ($letter === 'ABC' || $letter === 'abc') {
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
            return $this->render('admin/all_entreprise.html.twig', [
                'entreprisesStartByA' => $entreprisesStartByA,
                'entreprisesStartByB' => $entreprisesStartByB,
                'entreprisesStartByC' => $entreprisesStartByC,
            ]);
        } elseif ($letter === 'DEF' || $letter === 'def') {
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
            return $this->render('admin/all_entreprise.html.twig', [
                'entreprisesStartByD' => $entreprisesStartByD,
                'entreprisesStartByE' => $entreprisesStartByE,
                'entreprisesStartByF' => $entreprisesStartByF,
            ]);
        } elseif ($letter === 'GHIJ' || $letter === 'ghij') {
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
            return $this->render('admin/all_entreprise.html.twig', [
                'entreprisesStartByG' => $entreprisesStartByG,
                'entreprisesStartByH' => $entreprisesStartByH,
                'entreprisesStartByI' => $entreprisesStartByI,
                'entreprisesStartByJ' => $entreprisesStartByJ,
            ]);
        } elseif ($letter === 'KLM' || $letter === 'klm') {
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
        } elseif ($letter === 'NOPQ' || $letter === 'nopq') {
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
        } elseif ($letter === 'RSTU' || $letter === 'rstu') {
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
        } elseif ($letter === 'VWXYZ' || $letter === 'vwxyz') {
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
        }

        return $this->render('admin/all_entreprise.html.twig', [
            'controller_name' => 'AdminController',


            'entreprisesStartByK' => $entreprisesStartByK,
            'entreprisesStartByL' => $entreprisesStartByL,
            'entreprisesStartByM' => $entreprisesStartByM,
            'entreprisesStartByN' => $entreprisesStartByN,
            'entreprisesStartByO' => $entreprisesStartByO,
            'entreprisesStartByP' => $entreprisesStartByP,
            'entreprisesStartByQ' => $entreprisesStartByQ,
            'entreprisesStartByR' => $entreprisesStartByR,
            'entreprisesStartByS' => $entreprisesStartByS,
            'entreprisesStartByT' => $entreprisesStartByT,
            'entreprisesStartByU' => $entreprisesStartByU,
            'entreprisesStartByV' => $entreprisesStartByV,
            'entreprisesStartByW' => $entreprisesStartByW,
            'entreprisesStartByX' => $entreprisesStartByX,
            'entreprisesStartByY' => $entreprisesStartByY,
            'entreprisesStartByZ' => $entreprisesStartByZ,
        ]);
    }
}
