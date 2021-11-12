<?php

namespace App\DataFixtures;

use App\Entity\Type;
use App\Entity\Aliment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $type1 = new Type();
        $type1->setLibelle("Fruits")
            ->setImage("fruits.jpg");
        $manager->persist($type1);
        $type2 = new Type();
        $type2->setLibelle("Legumes")
            ->setImage("legumes.jpg");
        $manager->persist($type2);

        $alimentRepository = $manager->getRepository(Aliment::class);

        $aliment1 = $alimentRepository->findOneBy(["nom" => "Patate"]);
        $aliment1->setType($type2);
        $manager->persist($aliment1);

        $aliment2 = $alimentRepository->findOneBy(["nom" => "Tomate"]);
        $aliment2->setType($type2);
        $manager->persist($aliment2);

        $aliment3 = $alimentRepository->findOneBy(["nom" => "Pomme"]);
        $aliment3->setType($type1);
        $manager->persist($aliment3);

        $aliment4 = $alimentRepository->findOneBy(["nom" => "Carotte"]);
        $aliment4->setType($type2);
        $manager->persist($aliment4);

        $aliment5 = $alimentRepository->findOneBy(["nom" => "Tomate3"]);
        $aliment5->setType($type2);
        $manager->persist($aliment5);

        $aliment6 = $alimentRepository->findOneBy(["nom" => "Pomme2"]);
        $aliment6->setType($type1);
        $manager->persist($aliment6);

        $aliment7 = $alimentRepository->findOneBy(["nom" => "Pomme3"]);
        $aliment7->setType($type1);
        $manager->persist($aliment7);

        $manager->flush();
    }
}
