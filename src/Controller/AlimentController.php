<?php

namespace App\Controller;

use App\Repository\AlimentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlimentController extends AbstractController
{
    /**
     * @Route("/", name="aliments")
     */
    public function index(AlimentRepository $repository): Response
    {
        $aliments = $repository->findAll();
        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false
        ]);
    }

    /**
     * @Route("/aliments/{calorie}", name="alimentsParCalorie")
     */
    public function alimentsMoinsCaloriques(AlimentRepository $repository,$calorie): Response
    {
        $aliments = $repository->getAlimentParNombreCalories($calorie);
        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => true
        ]);
    }

}
