<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectAdminController extends AbstractController
{
    #[Route('/api/projects/upload', name: 'api_project_upload', methods: ['POST'])]
    public function upload(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $imageFile = $request->files->get('image') ?? $request->files->get('imageFile');
        if (!$imageFile instanceof UploadedFile || !$imageFile->isValid()) {
            $uploadError = $imageFile instanceof UploadedFile ? $imageFile->getError() : 'absent';

            return $this->json(['error' => 'Une image JPG, JPEG ou PNG valide est obligatoire.', 'uploadError' => $uploadError], Response::HTTP_BAD_REQUEST);
        }

        if ($imageFile->getSize() > 10 * 1024 * 1024) {
            return $this->json(['error' => 'L’image ne doit pas dépasser 10 Mo.'], Response::HTTP_REQUEST_ENTITY_TOO_LARGE);
        }

        $imageInfo = @getimagesize($imageFile->getPathname());
        $mimeType = $imageInfo['mime'] ?? '';
        $allowedMimeTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        if (!isset($allowedMimeTypes[$mimeType])) {
            return $this->json(['error' => 'Format d’image non accepté.'], Response::HTTP_BAD_REQUEST);
        }

        $title = trim((string) $request->request->get('title', ''));
        $description = trim((string) $request->request->get('description', ''));
        if ($title === '' || $description === '') {
            return $this->json(['error' => 'Le titre et la description sont obligatoires.'], Response::HTTP_BAD_REQUEST);
        }

        $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/projects';
        if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0775, true) && !is_dir($uploadDirectory)) {
            return $this->json(['error' => 'Impossible de créer le dossier des images.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $allowedMimeTypes[$mimeType];
        try {
            $imageFile->move($uploadDirectory, $filename);
        } catch (\Throwable $exception) {
            return $this->json(['error' => 'Impossible d’enregistrer l’image.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $project = new Project();
        $project->setTitle($title);
        $project->setDescription($description);
        $project->setProjectLink($this->nullableString($request->request->get('projectLink')));
        $project->setSiteLink($this->nullableString($request->request->get('siteLink')));
        $project->setImagePath('/uploads/projects/' . $filename);

        $entityManager->persist($project);
        $entityManager->flush();

        return $this->json([
            'id' => $project->getId(),
            'title' => $project->getTitle(),
            'description' => $project->getDescription(),
            'projectLink' => $project->getProjectLink(),
            'siteLink' => $project->getSiteLink(),
            'imagePath' => $project->getImagePath(),
        ], Response::HTTP_CREATED);
    }

    private function nullableString(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value !== '' ? $value : null;
    }

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
        ];

        if ($request->isMethod('POST')) {
            $data['title'] = trim((string) $request->request->get('title', ''));
            $data['description'] = trim((string) $request->request->get('description', ''));
            $data['projectLink'] = trim((string) $request->request->get('projectLink', ''));
            $data['siteLink'] = trim((string) $request->request->get('siteLink', ''));
            $imageFile = $request->files->get('imageFile');

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
                }
            }

            if ($imageFile instanceof UploadedFile && !$imageFile->isValid()) {
                $errors[] = 'Téléversement échoué (code erreur : ' . $imageFile->getError() . ')';
            }

            if ($errors === []) {
                $project = new Project();
                $project->setTitle($data['title']);
                $project->setDescription($data['description']);
                $project->setProjectLink($data['projectLink'] !== '' ? $data['projectLink'] : null);
                $project->setSiteLink($data['siteLink'] !== '' ? $data['siteLink'] : null);

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
