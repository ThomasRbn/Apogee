<?php

namespace App\Controller\API;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class APIProductController extends AbstractController
{
    #[Route('/api/product', name: 'apiProductGET', methods: ['GET'])]
    public function get(
        ProductRepository $productRepository,
        Request           $request
    ): Response
    {
        $limit = $request->query->getInt('limit', 10);
        $page = $request->query->getInt('page', 1);
        $productId = $request->query->get('id');

        if ($productId) {
            $product = $productRepository->find($productId);
            return new JsonResponse($product->toArray());
        }

        $products = $productRepository->findByPage($limit, $page);
        $realProducts['products'] = [];
        foreach ($products as $product) {
            $realProducts['products'][] = $product->toArray();
        }
        $realProducts['count'] = $productRepository->countAll();
        return new JsonResponse($realProducts);
    }

    #[Route('/api/product', name: 'apiProductPOST', methods: ['POST'])]
    public function post(
        Request                $request,
        ProductRepository      $productRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface     $validator
    ): Response
    {
        $data = json_decode($request->getContent(), true);

        if (isset($data['id'])) {
            $product = $productRepository->find($data['id']);
        } else {
            $product = new Product();
        }
        $product->updateProduct($data['name'], $data['description'], $data['price']);

        return APIController::validateAndPersist($product, $validator, $entityManager);
    }
}
