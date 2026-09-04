<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

final class LoginFailureHandler implements AuthenticationFailureHandlerInterface
{
    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception
    ): Response {
        return new JsonResponse([
            'authenticated' => false,
            'error' => 'Invalid credentials.',
        ], Response::HTTP_UNAUTHORIZED);
    }
}