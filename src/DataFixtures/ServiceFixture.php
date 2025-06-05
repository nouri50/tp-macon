<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $services = [
            [
                'nom' => 'Cuisine',
                'description' => 'Aménagement sur-mesure, installation de mobilier, carrelage mural et sol. Optimisation de l’espace et finitions soignées.',
                'image' => 'cuisine.jpg',
            ],
            [
                'nom' => 'Salle de bain',
                'description' => 'Rénovation complète ou partielle de votre salle de bain. Nous assurons la pose de carrelage, plomberie et finitions modernes.',
                'image' => 'salle-bain.jpg',
            ],
            [
                'nom' => 'Carrelage',
                'description' => 'Pose de carrelage mural et sol, intérieur comme extérieur. Nombreux modèles et finitions.',
                'image' => 'carrelage.jpg',
            ],
            [
                'nom' => 'Chape fluide',
                'description' => 'Application de chape fluide pour un sol parfaitement nivelé. Idéal pour chauffage au sol ou revêtement.',
                'image' => 'chape.jpg',
            ],
            [
                'nom' => 'Terrasse',
                'description' => 'Création ou rénovation de terrasse en béton, pierre ou carrelage. Un extérieur agréable et résistant aux intempéries.',
                'image' => 'terrasse.jpg',
            ],

            [
                'nom' => 'Extension maison',
                'description' => 'Agrandissement de votre habitation avec des extensions sur-mesure. Optimisation de l’espace de vie.',
                'image' => 'extension.jpg'
            ],


        ];

        foreach ($services as $data) {
            $service = new Service();
            $service->setNom($data['nom']);
            $service->setDescription($data['description']);
            $service->setImage($data['image']);

            $manager->persist($service);
        }

        $manager->flush();
    }
}
