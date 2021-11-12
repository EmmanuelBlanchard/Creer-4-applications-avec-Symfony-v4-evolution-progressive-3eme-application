<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTypeController extends AbstractController
{
    /**
     * @Route("/admin/types", name="admin_types")
     */
    public function index(TypeRepository $repository): Response
    {
        $types = $repository->findAll();
        return $this->render('admin/admin_type/adminTypes.html.twig', [
            'types' => $types,
        ]);
    }

    /**
     * @Route("/admin/type/creation", name="admin_type_creation")
     * @Route("/admin/type/{id}", name="admin_type_modification", methods="GET|POST")
     */
    public function ajoutEtModification(Type $type = null,Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$type) {
            $type = new Type();
        }
        $form = $this->createForm(TypeType::class,$type);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $modification = $type->getId() !== null;
            $entityManager->persist($type);
            $entityManager->flush();
            $this->addFlash("success", ($modification) ? "La modification a été effectuée" : "L'ajout a été effectué");
            return $this->redirectToRoute("admin_types");
        }

        return $this->render('admin/admin_type/ajoutEtModificationType.html.twig', [
            'type' => $type,
            'form' => $form->createView(),
            'isModification' => $type->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/type/{id}", name="admin_type_suppression", methods="delete")
     */
    public function suppresion(Type $type,Request $request, EntityManagerInterface $entityManager): Response
    {
        if($this->isCsrfTokenValid("SUP" . $type->getId(), $request->get('_token'))) {
            $entityManager->remove($type);
            $entityManager->flush();
            $this->addFlash("success","La suppression a été effectuée");
            return $this->redirectToRoute("admin_types");
        }
    }

}
