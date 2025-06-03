<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    #[Route('/services', name: 'app_service')]
    public function index(ServiceRepository $repository): Response
    {
        $services = $repository->findAll();

        return $this->render('service/index.html.twig', [
            'services' => $services
        ]);
    }
}