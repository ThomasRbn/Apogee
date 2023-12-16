<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product.index')]
    public function index(
        PaginatorInterface $paginator,
        ProductRepository  $productRepository,
        Request            $request): Response
    {
        $products = $paginator->paginate(
            $productRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        $realProducts = [];
        foreach ($products->getItems() as $product) {
            $realProducts[] = $product->toArray();
        }

//        dd($realProducts);
        return $this->render('product/index.html.twig', [
            'products' => $realProducts,
        ]);
    }
}
