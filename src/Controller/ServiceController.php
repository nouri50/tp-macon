<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceTypeForm;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ServiceController extends AbstractController
{
    #[Route('/services', name: 'app_service')]
    public function index(ServiceRepository $repository): Response
    {
        $services = $repository->findAll();
        $isAdmin = true;

        return $this->render('service/index.html.twig', [
            'services' => $services,
            'isAdmin' => $isAdmin,
        ]);
    }


#[Route('/service/new', name: 'app_service_new')]

public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
{
    
    $service = new Service();
    $form = $this->createForm(ServiceTypeForm::class, $service);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile|null $imageFile */
        $imageFile = $form->get('imageFile')->getData();

        if ($imageFile) {
            $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeName = $slugger->slug($originalName);
            $newFilename = $safeName.'-'.uniqid().'.'.$imageFile->guessExtension();

            $imageFile->move($this->getParameter('service_images_directory'), $newFilename);
            $service->setImage($newFilename);
        }

        $em->persist($service);
        $em->flush();

        return $this->redirectToRoute('app_service_show', ['id' => $service->getId()]);
    }

    return $this->render('service/form.html.twig', [
        'form' => $form->createView(),
        'editmode' => false,
        'service' => $service,
    ]);
}

    #[Route('/service/{id}', name: 'app_service_show')]
    public function show(Service $service): Response
    {
        return $this->render('service/show.html.twig', [
            'service' => $service,
        ]);
    }

#[Route('/service/{id}/edit', name: 'app_service_edit')]
public function edit(
    Service $service,
    Request $request,
    EntityManagerInterface $entityManager,
    SluggerInterface $slugger
): Response {
    $form = $this->createForm(ServiceTypeForm::class, $service);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile|null $imageFile */
        $imageFile = $form->get('imageFile')->getData();

        if ($imageFile) {
            $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeName = $slugger->slug($originalName);
            $newFilename = $safeName.'-'.uniqid().'.'.$imageFile->guessExtension();

            $imageFile->move($this->getParameter('service_images_directory'), $newFilename);
            $service->setImage($newFilename);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_service_show', ['id' => $service->getId()]);
    }

    return $this->render('service/form.html.twig', [
        'form' => $form->createView(),
        'editmode' => true,
        'service' => $service,
    ]);
}

}