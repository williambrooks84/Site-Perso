<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CategoryController extends AbstractController
{
    #[Route('/api/categories/submit', name: 'api_category_submit', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function upload(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $name = trim((string) $request->request->get('description', ''));
        if ($name === '') {
            return $this->json(['error' => 'Le nom de la catégorie est obligatoire.'], Response::HTTP_BAD_REQUEST);
        }

        $category = new Category();
        $category->setName($name);

        $entityManager->persist($category);
        $entityManager->flush();

        return $this->json([
            'id' => $category->getId(),
            'title' => $category->getName(),
        ], Response::HTTP_CREATED);
    }

    #[Route('/admin/categories', name: 'api_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findBy([], ['id' => 'DESC']);

        return $this->json($categories);
    }

}
