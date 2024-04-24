<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{

    #[Route('/comment{id}', name: 'comment', priority: -1)]
    public function create(Product $product, EntityManagerInterface $manager, Request $request): Response
    {
        $comment = new Comment();
        $comment->setProduct($product);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($comment);
            $manager->flush();
        }
        return $this->redirectToRoute("show_product", ["id" => $product->getId()]);

    }
    #[Route('/comment/delete/{id}', name:'delete_comment',priority: -1)]
    public function delete(Comment $comment, Request $request, EntityManagerInterface $manager): Response
    {
        $manager->remove($comment);
        $manager->flush();
        return $this->redirectToRoute('show_product', ["id" => $comment->getProduct()->getId()]);
    }
}