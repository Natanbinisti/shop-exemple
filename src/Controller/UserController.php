<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/product', name: 'app_product', priority: 1)]
    public function index(ProductRepository $productRepository, Request $request): Response
    {


            $products = $productRepository->findAll();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products,
        ]);
    }

    #[Route('/product/show/{id}', name: 'app_show')]
    public function show(Product $product, Request $request, EntityManagerInterface $manager): Response
    {

        return $this->render('product/show.html.twig', [
            "product"=>$product,
        ]);
    }

}