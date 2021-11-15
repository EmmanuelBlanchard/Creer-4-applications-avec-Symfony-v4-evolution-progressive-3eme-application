<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminSecuController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(InscriptionType::class,$utilisateur);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $passwordCrypte = $encoder->encodePassword($utilisateur, $utilisateur->getPassword()); // Dans le security.yaml on a indiqué quel algorithme utiliser
            $utilisateur->setPassword($passwordCrypte);

            $entityManager->persist($utilisateur);
            $entityManager->flush();
            return $this->redirectToRoute("aliments");
        }

        return $this->render('admin/admin_secu/inscription.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
