<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cartService): Response
    {

        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getCart(),
            'total'=> $cartService->getTotal()
        ]);
    }

    #[Route('/cart/add/{id}/{quantity}', name: 'app_cart_add')]
    #[Route('/cart/addfromcart/{id}/{quantity}', name: 'app_cart_add_fromcart')]
    public function addToCart(Request $request, Product $product, $quantity, CartService $cartService): Response
    {
        $cartService->addProduct($product, $quantity);

        $originRoute = $request->attributes->get('_route');
        $redirection = 'app_customer_index';
        if ($originRoute = "app_cart_add_fromcart") {
            $redirection = 'app_cart';
        }

        return $this->redirectToRoute($redirection);

    }

    #[Route('/cart/remove/one/{id}/{quantity}', name: 'app_cart_remove_one')]
    public function removeOneProduct(CartService $cartService, Product $product, $quantity): Response
    {
        $cartService->removeOneProduct($product, $quantity);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/row/{id}', name: 'app_cart_remove_row')]
    public function removeRow(CartService $cartService, Product $product)
    {
        $cartService->removeRow($product);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/empty', name: 'app_cart_empty')]
    public function emptyCart(CartService $cartService): Response
    {
        $cartService->emptyCart();
        return $this->redirectToRoute('app_cart');
    }
}