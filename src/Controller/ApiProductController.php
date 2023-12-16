<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiProductController extends AbstractController
{
    #[Route('/api/product', name: 'apiProductList', methods: ['GET'])]
    public function getProducts(
        ProductRepository $productRepository,
        Request $request
    ): Response
    {
        $limit = $request->query->getInt('limit', 10);
        $page = $request->query->getInt('page', 1);
        $products = $productRepository->findByPage($limit, $page);
        $realProducts['products'] = [];
        foreach ($products as $product) {
            $realProducts['products'][] = $product->toArray();
        }
        $realProducts['count'] = $productRepository->countAll();
        return new JsonResponse($realProducts);
    }
}
