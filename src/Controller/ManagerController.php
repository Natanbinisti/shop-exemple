<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ManagerController extends AbstractController
{
    #[Route('/manager', name: 'app_manager')]
    public function index(OrderRepository $orderRepository): Response
    {

        return $this->render('manager/index.html.twig', [
            'controller_name' => 'ManagerController',
            'orders' => $orderRepository->findAll(),
        ]);
    }
    #[Route('/manager/status/{id}', name:'app_manager_status')]
    public function status(Order $order, EntityManagerInterface $manager)
    {
        $order->setStatus(2);
        $manager->persist($order);
        $manager->flush();

        return $this->redirectToRoute('app_manager', [
        ]);
    }
}
