<?php

namespace App\Controller;

use App\Entity\Technology;
use App\Repository\TechnologyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TechnologyController extends AbstractController
{
    #[Route('/api/technologies/submit', name: 'api_technology_submit', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function upload(
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $name = trim((string) $request->request->get('description', ''));

        if ($name === '') {
            return $this->json(
                ['error' => 'Le nom de la technologie est obligatoire.'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $imageFile = $request->files->get('image')
            ?? $request->files->get('imageFile');

        if (!$imageFile instanceof UploadedFile || !$imageFile->isValid()) {
            return $this->json(
                ['error' => 'Une icône SVG est obligatoire.'],
                Response::HTTP_BAD_REQUEST
            );
        }

        if ($imageFile->getSize() > 10 * 1024 * 1024) {
            return $this->json(
                ['error' => 'L’image ne doit pas dépasser 10 Mo.'],
                Response::HTTP_REQUEST_ENTITY_TOO_LARGE
            );
        }

        $extension = strtolower($imageFile->getClientOriginalExtension());
        $mimeType = $imageFile->getMimeType();

        if (
            $extension !== 'svg'
            || !in_array($mimeType, ['image/svg+xml', 'image/svg'], true)
        ) {
            return $this->json(
                ['error' => 'Seuls les fichiers SVG sont acceptés.'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $filename = uniqid('', true) . '.svg';

        $uploadDirectory = $this->getParameter('kernel.project_dir')
            . '/public/uploads/technologies';

        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        $imageFile->move($uploadDirectory, $filename);

        $technology = new Technology();
        $technology->setName($name);
        $technology->setIconPath('/uploads/technologies/' . $filename);

        $entityManager->persist($technology);
        $entityManager->flush();

        return $this->json([
            'id' => $technology->getId(),
            'name' => $technology->getName(),
            'iconPath' => $technology->getIconPath(),
        ], Response::HTTP_CREATED);
    }

    #[Route('/api/technologies/delete', name: 'api_technology_delete', methods: ['DELETE'], priority: 10)]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, TechnologyRepository $technologyRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $id = (int) $request->query->get('id');
        $technology = $technologyRepository->find($id);

        if (!$technology) {
            return $this->json(['error' => 'Pas de technologie avec cet ID.'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($technology);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/technologies', name: 'api_technology_index', methods: ['GET'])]
    public function index(TechnologyRepository $technologyRepository): Response
    {
        $technologies = $technologyRepository->findBy([], ['id' => 'DESC']);

        return $this->json($technologies);
    }

}
