<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product.index')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig');
    }

    #[Route('/product/new', name: 'product.new')]
    public function new(): Response
    {
        return $this->render('product/new.html.twig');
    }


    #[Route('/product/{id}', name: 'product.show')]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product->toArray()
        ]);
    }

    #[Route('/product/edit/{id}', name: 'product.edit')]
    public function edit(Product $product): Response
    {
        return $this->render('product/edit.html.twig', [
            'product' => $product->toArray()
        ]);
    }

    #[Route('/product/delete/{id}', name: 'product.delete')]
    public function delete(Product $product, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->render('product/index.html.twig');
    }
}