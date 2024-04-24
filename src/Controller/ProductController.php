<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Product;
use App\Form\ImageType;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/create', name: 'create_product')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCreatedAt(new \DateTime());
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product', ["id"=>$product->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/create.html.twig', [
            'product' => $product,
            'formProduct' => $form,
        ]);
    }

    #[Route("/image/delete/{id}", name: 'app_product_image_delete',priority: -1)]
    public function deleteProductImage(Request $request, Image $image, EntityManagerInterface $entityManager): Response
    {
        $product = $image->getProduct();
        $entityManager->remove($image);
        $entityManager->flush();
        return $this->redirectToRoute('show_product', ["id"=>$product->getId()], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}', name: 'show_product',priority: -1)]
    public function show(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {



            $image->setProduct($product);
            $entityManager->persist($image);
            $entityManager->flush();
            return $this->redirectToRoute('show_product', ["id"=>$product->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'form'=> $form->createView(),
        ]);
    }


    #[Route('/delete/{id}', name: 'delete_product')]
    public function delete(Product $product, Request $request, EntityManagerInterface $manager): Response
    {
        $manager->remove($product);
        $manager->flush();

        return $this->redirectToRoute('app_product');
    }
}