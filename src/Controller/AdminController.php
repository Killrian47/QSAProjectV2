<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/{letter}', name: 'app_start')]
    public function firstLetter(string $letter, EntrepriseRepository $entrepriseRepository): Response
    {
        $entreprises = $entrepriseRepository->findBy([], ['name' => 'ASC']);
        if ($letter === 'ABC' || $letter === 'abc') {
            $entreprisesStartByA = [];
            $entreprisesStartByB = [];
            $entreprisesStartByC = [];
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
        } elseif ($letter === 'DEF' || $letter === 'def') {
            $entreprisesStartByD = [];
            $entreprisesStartByE = [];
            $entreprisesStartByF = [];
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
        } elseif ($letter === 'GHIJ' || $letter === 'ghij') {
            $entreprisesStartByG = [];
            $entreprisesStartByH = [];
            $entreprisesStartByI = [];
            $entreprisesStartByJ = [];
            foreach ($entreprises as $value) {
                for ($i = 0; $i < 1; $i++) {
                    if ($value->getName()[$i] === 'g' || $value->getName()[$i] === 'G') {
                        $entreprisesStartByD[] = $value;
                    } elseif ($value->getName()[$i] === 'h' || $value->getName()[$i] === 'H') {
                        $entreprisesStartByE[] = $value;
                    } elseif ($value->getName()[$i] === 'i' || $value->getName()[$i] === 'I') {
                        $entreprisesStartByF[] = $value;
                    } elseif ($value->getName()[$i] === 'j' || $value->getName()[$i] === 'J') {
                        $entreprisesStartByF[] = $value;
                    }
                }
            }
        } elseif ($letter === 'KLM' || $letter === 'klm') {
            $entreprisesStartByK = [];
            $entreprisesStartByL = [];
            $entreprisesStartByM = [];
            foreach ($entreprises as $value) {
                for ($i = 0; $i < 1; $i++) {
                    if ($value->getName()[$i] === 'k' || $value->getName()[$i] === 'K') {
                        $entreprisesStartByD[] = $value;
                    } elseif ($value->getName()[$i] === 'l' || $value->getName()[$i] === 'L') {
                        $entreprisesStartByE[] = $value;
                    } elseif ($value->getName()[$i] === 'm' || $value->getName()[$i] === 'M') {
                        $entreprisesStartByF[] = $value;
                    }
                }
            }
        } elseif ($letter === 'NOPQ' || $letter === 'nopq') {
            $entreprisesStartByN = [];
            $entreprisesStartByO = [];
            $entreprisesStartByP = [];
            $entreprisesStartByQ = [];
            foreach ($entreprises as $value) {
                for ($i = 0; $i < 1; $i++) {
                    if ($value->getName()[$i] === 'n' || $value->getName()[$i] === 'N') {
                        $entreprisesStartByD[] = $value;
                    } elseif ($value->getName()[$i] === 'o' || $value->getName()[$i] === 'O') {
                        $entreprisesStartByE[] = $value;
                    } elseif ($value->getName()[$i] === 'p' || $value->getName()[$i] === 'P') {
                        $entreprisesStartByF[] = $value;
                    } elseif ($value->getName()[$i] === 'q' || $value->getName()[$i] === 'Q') {
                        $entreprisesStartByF[] = $value;
                    }
                }
            }
        } elseif ($letter === 'RSTU' || $letter === 'rstu') {
            $entreprisesStartByR = [];
            $entreprisesStartByS = [];
            $entreprisesStartByT = [];
            $entreprisesStartByU = [];
            foreach ($entreprises as $value) {
                for ($i = 0; $i < 1; $i++) {
                    if ($value->getName()[$i] === 'r' || $value->getName()[$i] === 'R') {
                        $entreprisesStartByD[] = $value;
                    } elseif ($value->getName()[$i] === 's' || $value->getName()[$i] === 'S') {
                        $entreprisesStartByE[] = $value;
                    } elseif ($value->getName()[$i] === 't' || $value->getName()[$i] === 'T') {
                        $entreprisesStartByF[] = $value;
                    } elseif ($value->getName()[$i] === 'u' || $value->getName()[$i] === 'U') {
                        $entreprisesStartByF[] = $value;
                    }
                }
            }
        } elseif ($letter === 'VWXYZ' || $letter === 'vwxyz') {
            $entreprisesStartByV = [];
            $entreprisesStartByW = [];
            $entreprisesStartByX = [];
            $entreprisesStartByY = [];
            $entreprisesStartByZ = [];
            foreach ($entreprises as $value) {
                for ($i = 0; $i < 1; $i++) {
                    if ($value->getName()[$i] === 'v' || $value->getName()[$i] === 'V') {
                        $entreprisesStartByD[] = $value;
                    } elseif ($value->getName()[$i] === 'w' || $value->getName()[$i] === 'W') {
                        $entreprisesStartByE[] = $value;
                    } elseif ($value->getName()[$i] === 'x' || $value->getName()[$i] === 'X') {
                        $entreprisesStartByF[] = $value;
                    } elseif ($value->getName()[$i] === 'y' || $value->getName()[$i] === 'Y') {
                        $entreprisesStartByF[] = $value;
                    } elseif ($value->getName()[$i] === 'z' || $value->getName()[$i] === 'Z') {
                        $entreprisesStartByF[] = $value;
                    }
                }
            }
        }

        return $this->render('admin/test.html.twig', [
            'controller_name' => 'AdminController',
            'entreprisesStartByA' => $entreprisesStartByA,
            'entreprisesStartByB' => $entreprisesStartByB,
            'entreprisesStartByC' => $entreprisesStartByC,
            'entreprisesStartByD' => $entreprisesStartByD,
            'entreprisesStartByE' => $entreprisesStartByE,
            'entreprisesStartByF' => $entreprisesStartByF,
            'entreprisesStartByG' => $entreprisesStartByG,
            'entreprisesStartByH' => $entreprisesStartByH,
            'entreprisesStartByI' => $entreprisesStartByI,
            'entreprisesStartByJ' => $entreprisesStartByJ,
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
