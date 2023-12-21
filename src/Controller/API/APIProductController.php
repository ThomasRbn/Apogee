<?php

namespace App\Controller\API;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class APIProductController extends AbstractController
{
    #[Route('/api/product', name: 'apiProductList', methods: ['GET'])]
    public function getProducts(
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

    #[Route('/api/product', name: 'apiProductCreate', methods: ['POST'])]
    public function createProduct(
        Request                $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface     $validator
    ): Response
    {
        $data = json_decode($request->getContent(), true);
        $product = Product::createProduct(
            $data['name'],
            $data['description'],
            $data['price']
        );

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            // Des erreurs de validation ont été détectées, vous pouvez les traiter ici
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            return new JsonResponse(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }

        //valider le produit en fonction des assert de l'entité

        $entityManager->persist($product);
        $entityManager->flush();
        return new JsonResponse($product->toArray());
    }
}
