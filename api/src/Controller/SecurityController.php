<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        // json_login intercepts this request before this method runs.
        return $this->json(['authenticated' => true]);
    }

    #[Route('/api/logout', name: 'api_logout', methods: ['POST'])]
    public function logout(): JsonResponse
    {
        return $this->json(['authenticated' => false]);
    }

    #[Route('/api/logout-success', name: 'api_logout_success', methods: ['GET'])]
    public function logoutSuccess(): JsonResponse
    {
        return $this->json(['authenticated' => false]);
    }

    #[Route('/api/me', name: 'api_me', methods: ['GET'])]
    public function me(): JsonResponse
    {
        $user = $this->getUser();

        if ($user === null) {
            return $this->json(['authenticated' => false]);
        }

        return $this->json([
            'authenticated' => true,
            'email' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
        ]);
    }

}