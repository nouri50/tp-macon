<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findAll();

        $imagePool = ['img1.jpg', 'img2.jpg', 'img3.jpg', 'cuisine.jpg', 'chape.jpg'];

        // assigner une image aléatoire à chaque service pour l’affichage uniquement
        foreach ($services as $service) {
            $randomImage = $imagePool[array_rand($imagePool)];
            $service->setImage($randomImage); // temporaire pour l’affichage
        }

        return $this->render('home/index.html.twig', [
            'services' => $services,
        ]);
    }
}
