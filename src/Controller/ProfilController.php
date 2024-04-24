<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Entity\PaymentMethod;
use App\Form\AdressType;
use App\Form\PaymentMethodType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        $newAdress = new Adress();
        $newPaymentMethod = new PaymentMethod();
        $formPayment = $this->createForm(PaymentMethodType::class, $newPaymentMethod);
        $formAdress = $this->createForm(AdressType::class, $newAdress);
        return $this->render('profil/index.html.twig', [
            'formPayment' => $formPayment->createView(),
            'formAdress' => $formAdress->createView(),
        ]);
    }

    #[Route('/profil/adress', name: 'app_profil_adress')]
    public function addAdress(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newAdress = new Adress();
        $formAdress = $this->createForm(AdressType::class, $newAdress);
        $formAdress->handleRequest($request);
        if ($formAdress->isSubmitted() && $formAdress->isValid()) {
            $newAdress->setOwner($this->getUser());
            $entityManager->persist($newAdress);
            $entityManager->flush();

        }
        return $this->redirectToRoute('app_profil');

    }


    #[Route('/profil/paymentmethod', name: 'app_profil_paymentmethod')]
    public function addPaymentMethods(Request $request, EntityManagerInterface $entityManager): Response
    {

        $newPaymentMethod = new PaymentMethod();
        $formPayment = $this->createForm(PaymentMethodType::class, $newPaymentMethod);
        $formPayment->handleRequest($request);
        if ($formPayment->isSubmitted() && $formPayment->isValid()) {

            $newPaymentMethod->setOwner($this->getUser());
            $entityManager->persist($newPaymentMethod);
            $entityManager->flush();
        }



        return $this->redirectToRoute('app_profil');

    }

}