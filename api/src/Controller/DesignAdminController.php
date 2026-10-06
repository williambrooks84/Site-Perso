<?php

namespace App\Controller;

use App\Entity\Design;
use App\Repository\DesignRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DesignAdminController extends AbstractController
{
    #[Route('/api/designs/upload', name: 'api_design_upload', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function upload(
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $imageFile = $request->files->get('image')
            ?? $request->files->get('imageFile');

        $previewFile = $request->files->get('preview')
            ?? $request->files->get('previewFile');

        /*
         * Validate main image
         */
        if (!$imageFile instanceof UploadedFile || !$imageFile->isValid()) {
            $uploadError = $imageFile instanceof UploadedFile
                ? $imageFile->getError()
                : 'absent';

            return $this->json(
                [
                    'error' => 'Une image JPG, JPEG, PNG ou WEBP valide est obligatoire.',
                    'uploadError' => $uploadError,
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        if ($imageFile->getSize() > 10 * 1024 * 1024) {
            return $this->json(
                ['error' => 'L’image ne doit pas dépasser 10 Mo.'],
                Response::HTTP_REQUEST_ENTITY_TOO_LARGE
            );
        }

        /*
         * Validate main image MIME type
         */
        $imageInfo = @getimagesize($imageFile->getPathname());
        $mimeType = $imageInfo['mime'] ?? '';

        $allowedMimeTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        if (!isset($allowedMimeTypes[$mimeType])) {
            return $this->json(
                ['error' => 'Format d’image non accepté.'],
                Response::HTTP_BAD_REQUEST
            );
        }

        /*
         * Validate title and description
         */
        $title = trim((string) $request->request->get('title', ''));
        $description = trim((string) $request->request->get('description', ''));

        if ($title === '' || $description === '') {
            return $this->json(
                ['error' => 'Le titre et la description sont obligatoires.'],
                Response::HTTP_BAD_REQUEST
            );
        }

        /*
         * Upload directories
         */
        $imageDirectory =
            $this->getParameter('kernel.project_dir')
            . '/public/uploads/designs';

        $previewDirectory =
            $this->getParameter('kernel.project_dir')
            . '/public/uploads/designs/previews';

        /*
         * Create directories if necessary
         */
        foreach ([$imageDirectory, $previewDirectory] as $directory) {
            if (
                !is_dir($directory)
                && !mkdir($directory, 0775, true)
                && !is_dir($directory)
            ) {
                return $this->json(
                    ['error' => 'Impossible de créer le dossier des images.'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        }

        /*
         * Generate main image filename
         */
        $imageFilename =
            bin2hex(random_bytes(16))
            . '.'
            . $allowedMimeTypes[$mimeType];

        /*
         * Save main image
         */
        try {
            $imageFile->move(
                $imageDirectory,
                $imageFilename
            );
        } catch (\Throwable $exception) {
            return $this->json(
                ['error' => 'Impossible d’enregistrer l’image.'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        /*
         * Upload preview if provided
         */
        $previewPath = null;

        if ($previewFile instanceof UploadedFile) {
            if (!$previewFile->isValid()) {
                return $this->json(
                    ['error' => 'Le fichier de prévisualisation est invalide.'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            if ($previewFile->getSize() > 10 * 1024 * 1024) {
                return $this->json(
                    ['error' => 'La prévisualisation ne doit pas dépasser 10 Mo.'],
                    Response::HTTP_REQUEST_ENTITY_TOO_LARGE
                );
            }

            $previewInfo = @getimagesize($previewFile->getPathname());
            $previewMimeType = $previewInfo['mime'] ?? '';

            if (!isset($allowedMimeTypes[$previewMimeType])) {
                return $this->json(
                    ['error' => 'Format de prévisualisation non accepté.'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $previewFilename =
                bin2hex(random_bytes(16))
                . '.'
                . $allowedMimeTypes[$previewMimeType];

            try {
                $previewFile->move(
                    $previewDirectory,
                    $previewFilename
                );
            } catch (\Throwable $exception) {
                return $this->json(
                    ['error' => 'Impossible d’enregistrer la prévisualisation.'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            $previewPath =
                '/uploads/designs/previews/'
                . $previewFilename;
        }

        /*
         * Create Design
         */
        $design = new Design();

        $design->setTitle($title);
        $design->setDescription($description);

        $design->setImagePath(
            '/uploads/designs/' . $imageFilename
        );

        $design->setPreviewPath($previewPath);

        $entityManager->persist($design);
        $entityManager->flush();

        /*
         * Response
         */
        return $this->json(
            [
                'id' => $design->getId(),
                'title' => $design->getTitle(),
                'description' => $design->getDescription(),
                'imagePath' => $design->getImagePath(),
                'previewPath' => $design->getPreviewPath(),
            ],
            Response::HTTP_CREATED
        );
    }


    #[Route(
        '/api/designs/delete',
        name: 'api_design_delete',
        methods: ['DELETE'],
        priority: 10
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(
        Request $request,
        DesignRepository $designRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $id = (int) $request->query->get('id');

        $design = $designRepository->find($id);

        if (!$design) {
            return $this->json(
                ['error' => 'Pas de design avec cet ID.'],
                Response::HTTP_NOT_FOUND
            );
        }

        $entityManager->remove($design);
        $entityManager->flush();

        return new JsonResponse(
            null,
            Response::HTTP_NO_CONTENT
        );
    }


    #[Route(
        '/api/designs/{id}/update',
        name: 'api_design_update',
        methods: ['POST']
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function update(
        int $id,
        Request $request,
        DesignRepository $designRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $design = $designRepository->find($id);

        if (!$design) {
            return $this->json(
                ['error' => 'Design introuvable.'],
                Response::HTTP_NOT_FOUND
            );
        }

        /*
         * Validate text fields
         */
        $title = trim((string) $request->request->get('title', ''));
        $description = trim((string) $request->request->get('description', ''));

        if ($title === '' || $description === '') {
            return $this->json(
                ['error' => 'Le titre et la description sont obligatoires.'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $design->setTitle($title);
        $design->setDescription($description);

        /*
         * Optional main image replacement
         */
        $imageFile = $request->files->get('image');

        if ($imageFile instanceof UploadedFile) {
            if (!$imageFile->isValid()) {
                return $this->json(
                    ['error' => 'L’image est invalide.'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            if ($imageFile->getSize() > 10 * 1024 * 1024) {
                return $this->json(
                    ['error' => 'L’image ne doit pas dépasser 10 Mo.'],
                    Response::HTTP_REQUEST_ENTITY_TOO_LARGE
                );
            }

            $imageInfo = @getimagesize($imageFile->getPathname());
            $mimeType = $imageInfo['mime'] ?? '';

            $allowedMimeTypes = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
            ];

            if (!isset($allowedMimeTypes[$mimeType])) {
                return $this->json(
                    ['error' => 'Format d’image non accepté.'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $uploadDirectory =
                $this->getParameter('kernel.project_dir')
                . '/public/uploads/designs';

            if (
                !is_dir($uploadDirectory)
                && !mkdir($uploadDirectory, 0775, true)
                && !is_dir($uploadDirectory)
            ) {
                return $this->json(
                    ['error' => 'Impossible de créer le dossier des images.'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            $filename =
                bin2hex(random_bytes(16))
                . '.'
                . $allowedMimeTypes[$mimeType];

            try {
                $imageFile->move(
                    $uploadDirectory,
                    $filename
                );
            } catch (\Throwable $exception) {
                return $this->json(
                    ['error' => 'Impossible d’enregistrer la nouvelle image.'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            $design->setImagePath(
                '/uploads/designs/' . $filename
            );
        }

        /*
         * Optional preview replacement
         */
        $previewFile = $request->files->get('preview');

        if ($previewFile instanceof UploadedFile) {
            if (!$previewFile->isValid()) {
                return $this->json(
                    ['error' => 'La prévisualisation est invalide.'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            if ($previewFile->getSize() > 10 * 1024 * 1024) {
                return $this->json(
                    ['error' => 'La prévisualisation ne doit pas dépasser 10 Mo.'],
                    Response::HTTP_REQUEST_ENTITY_TOO_LARGE
                );
            }

            $previewInfo = @getimagesize($previewFile->getPathname());
            $previewMimeType = $previewInfo['mime'] ?? '';

            $allowedMimeTypes = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
            ];

            if (!isset($allowedMimeTypes[$previewMimeType])) {
                return $this->json(
                    ['error' => 'Format de prévisualisation non accepté.'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $previewDirectory =
                $this->getParameter('kernel.project_dir')
                . '/public/uploads/designs/previews';

            if (
                !is_dir($previewDirectory)
                && !mkdir($previewDirectory, 0775, true)
                && !is_dir($previewDirectory)
            ) {
                return $this->json(
                    ['error' => 'Impossible de créer le dossier des prévisualisations.'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            $previewFilename =
                bin2hex(random_bytes(16))
                . '.'
                . $allowedMimeTypes[$previewMimeType];

            try {
                $previewFile->move(
                    $previewDirectory,
                    $previewFilename
                );
            } catch (\Throwable $exception) {
                return $this->json(
                    ['error' => 'Impossible d’enregistrer la nouvelle prévisualisation.'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            $design->setPreviewPath(
                '/uploads/designs/previews/' . $previewFilename
            );
        }

        $entityManager->flush();

        return $this->json([
            'id' => $design->getId(),
            'title' => $design->getTitle(),
            'description' => $design->getDescription(),
            'imagePath' => $design->getImagePath(),
            'previewPath' => $design->getPreviewPath(),
        ]);
    }


    #[Route(
        '/api/designs',
        name: 'api_design_index',
        methods: ['GET']
    )]
    public function index(
        DesignRepository $designRepository
    ): Response {
        $designs = $designRepository->findBy(
            [],
            ['id' => 'DESC']
        );

        return $this->json($designs);
    }
}
