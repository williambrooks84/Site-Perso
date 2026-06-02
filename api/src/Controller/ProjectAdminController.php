<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectAdminController extends AbstractController
{
    #[Route('/admin/projects/new', name: 'admin_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $errors = [];
        $data = [
            'title' => '',
            'description' => '',
            'projectLink' => '',
            'siteLink' => '',
            'illustration' => '',
        ];

        if ($request->isMethod('POST')) {
            $data['title'] = trim((string) $request->request->get('title', ''));
            $data['description'] = trim((string) $request->request->get('description', ''));
            $data['projectLink'] = trim((string) $request->request->get('projectLink', ''));
            $data['siteLink'] = trim((string) $request->request->get('siteLink', ''));
            $data['illustration'] = trim((string) $request->request->get('illustration', ''));

            if ($data['title'] === '') {
                $errors[] = 'Le titre est obligatoire.';
            }

            if ($data['description'] === '') {
                $errors[] = 'La description est obligatoire.';
            }

            if ($errors === []) {
                $project = new Project();
                $project->setTitle($data['title']);
                $project->setDescription($data['description']);
                $project->setProjectLink($data['projectLink'] !== '' ? $data['projectLink'] : null);
                $project->setSiteLink($data['siteLink'] !== '' ? $data['siteLink'] : null);
                $project->setIllustration($data['illustration'] !== '' ? $data['illustration'] : null);

                $entityManager->persist($project);
                $entityManager->flush();

                $this->addFlash('success', 'Le projet a été ajouté.');

                return $this->redirectToRoute('admin_project_new');
            }
        }

        return $this->render('admin/project_new.html.twig', [
            'errors' => $errors,
            'data' => $data,
        ]);
    }
}