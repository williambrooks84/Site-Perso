<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectAdminController extends AbstractController
{
    #[Route('/admin/projects', name: 'admin_projects_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('admin/projects_index.html.twig', [
            'projects' => $projectRepository->findBy([], ['id' => 'DESC']),
        ]);
    }

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
            $imageFile = $request->files->get('imageFile');
            $imageBase64 = null;

            if ($data['title'] === '') {
                $errors[] = 'Le titre est obligatoire.';
            }

            if ($data['description'] === '') {
                $errors[] = 'La description est obligatoire.';
            }

            if ($imageFile instanceof UploadedFile && $imageFile->isValid()) {
                $imageInfo = @getimagesize($imageFile->getPathname());
                $mimeType = $imageInfo['mime'] ?? $imageFile->getClientMimeType();

                if ($mimeType === null || !str_starts_with($mimeType, 'image/')) {
                    $errors[] = 'Le fichier sélectionné doit être une image.';
                } else {
                    $imageBase64 = 'data:' . $mimeType . ';base64,' . base64_encode((string) file_get_contents($imageFile->getPathname()));
                }
            }

            if ($imageFile instanceof UploadedFile && !$imageFile->isValid()) {
                $errors[] = 'Le téléversement de l\'image a échoué.';
            }

            if ($errors === []) {
                $project = new Project();
                $project->setTitle($data['title']);
                $project->setDescription($data['description']);
                $project->setProjectLink($data['projectLink'] !== '' ? $data['projectLink'] : null);
                $project->setSiteLink($data['siteLink'] !== '' ? $data['siteLink'] : null);
                $project->setIllustration($data['illustration'] !== '' ? $data['illustration'] : null);
                call_user_func([$project, 'setImageBase64'], $imageBase64);

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