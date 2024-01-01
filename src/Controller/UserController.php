<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    #[Route('/user/edit', name: 'user.edit')]
    #[IsGranted('ROLE_USER')]
    public function edit(): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        return $this->render('user/edit.html.twig', [
            'user' => $user->toArray(),
        ]);
    }
}
