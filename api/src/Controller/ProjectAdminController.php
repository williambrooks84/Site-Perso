<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProjectAdminController extends AbstractController
{
    #[Route('/api/projects/upload', name: 'api_project_upload', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function upload(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): JsonResponse
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

        $categoryId = $request->request->get('categoryId');

        if ($categoryId === null || !ctype_digit((string) $categoryId)) {
            return $this->json(
                ['error' => 'Une catégorie valide est obligatoire.'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $category = $categoryRepository->find((int) $categoryId);

        if ($category === null) {
            return $this->json(
                ['error' => 'Catégorie introuvable.'],
                Response::HTTP_BAD_REQUEST
            );
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
        $project->setCategory($category);
        $project->setProjectLink($this->nullableString($request->request->get('projectLink')));
        $project->setSiteLink($this->nullableString($request->request->get('siteLink')));
        $project->setImagePath('/uploads/projects/' . $filename);

        $entityManager->persist($project);
        $entityManager->flush();

        return $this->json([
            'id' => $project->getId(),
            'title' => $project->getTitle(),
            'description' => $project->getDescription(),
            'category' => [
                'id' => $project->getCategory()->getId(),
                'name' => $project->getCategory()->getName(),
            ],
            'projectLink' => $project->getProjectLink(),
            'siteLink' => $project->getSiteLink(),
            'imagePath' => $project->getImagePath(),
        ], Response::HTTP_CREATED);
    }

    #[Route('/api/projects/delete', name: 'api_project_delete', methods: ['DELETE'], priority: 10)]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, ProjectRepository $projectRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $id = (int) $request->query->get('id');
        $project = $projectRepository->find($id);

        if (!$project) {
            return $this->json(['error' => 'Pas de projet avec cet ID.'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($project);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    private function nullableString(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value !== '' ? $value : null;
    }

    #[Route('/admin/projects', name: 'api_project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findBy([], ['id' => 'DESC']);

        return $this->json($projects);
    }
}
