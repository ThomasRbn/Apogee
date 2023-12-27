<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIUserController extends AbstractController
{
    #[Route('/api/user', name: 'apiUserPOST', methods: ['POST'])]
    public function post(): Response
    {



    }
}
