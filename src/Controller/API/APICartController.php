<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class APICartController extends AbstractController
{
    #[Route('/api/cart/add', name: 'cart.add')]
    public function add(Request $request, ProductRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        /**
         * @var User $user
         */
        $user = $this->getUser();

        $product = $repository->findOneBy(['id' => $data['product']['id']]);

        $newItem = $user->getCart()->addItem($product, $data['quantity']);
        $entityManager->persist($newItem);
        $entityManager->flush();

        return new JsonResponse($data);
    }
}
