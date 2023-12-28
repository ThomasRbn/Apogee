<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

class SecurityController extends AbstractController
{
    #[Route('/register', name: 'security.register')]
    public function register(): Response
    {
        return $this->render('security/register.html.twig');
    }

    #[Route('/login', name: 'security.login')]
    public function login(): Response
    {
        return $this->render('security/login.html.twig');
    }

    #[Route('/logout', name: 'security.logout')]
    public function logout(): Response
    {
        return new JsonResponse(['message' => 'You have been logged out'], Response::HTTP_OK);
    }
}
