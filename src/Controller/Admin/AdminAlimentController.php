<?php

namespace App\Controller\Admin;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAlimentController extends AbstractController
{
    /**
     * @Route("/admin/aliments", name="admin_aliments")
     */
    public function index(AlimentRepository $repository): Response
    {
        $aliments = $repository->findAll();
        return $this->render('admin/admin_aliment/adminAliments.html.twig', [
            'aliments' => $aliments,
        ]);
    }

    /**
     * @Route("/admin/aliment/creation", name="admin_aliment_creation")
     * @Route("/admin/aliment/{id}", name="admin_aliment_modification")
     */
    public function ajoutEtModification(Aliment $aliment = null,Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$aliment) {
            $aliment = new Aliment();
        }
        $form = $this->createForm(AlimentType::class,$aliment);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aliment);
            $entityManager->flush();
            return $this->redirectToRoute("admin_aliments");
        }

        return $this->render('admin/admin_aliment/ajoutEtModificationAliment.html.twig', [
            'aliment' => $aliment,
            'form' => $form->createView(),
            'isModification' => $aliment->getId() !== null
        ]);
    }

}
