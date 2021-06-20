<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/compte/adresse", name="account_address")
     */
    public function index(): Response
    {
        return $this->render('account/address.html.twig'
        );
    }

    /**
     * @Route("/compte/ajouter-une-adresse", name="account_add_address")
     */
    public function add(Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();
            $user = $this->getUser();
            $user->addAddress($address);
            $address->setUser($user);
            $this->em->persist($user);
            $this->em->persist($address);
            $this->em->flush();
            return $this->redirectToRoute('account_address');
        }

        return $this->render(
            'account/form-address.html.twig', [
                "form" => $form->createView()
            ]
        );
    }
    /**
     * @Route("/compte/modifier/adresse/{name}", name="account_modify_address")
     */
    public function modify(Request $request, Address $address): Response
    {
        $selectedAddress = $this->em->getRepository(Address::class)
            ->find($address->getId());

        if (!$selectedAddress || $selectedAddress->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_address');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('account_address');
        }

        return $this->render(
            'account/form-address.html.twig',
            [
                "form" => $form->createView()
            ]
        );
    }
    /**
     * @Route("/compte/supprimer/adresse/{name}", name="account_delete_address")
     */
    public function delete(Address $address): Response
    {
        $selectedAddress = $this->em->getRepository(Address::class)
            ->find($address->getId());

        if ($selectedAddress && $selectedAddress->getUser() == $this->getUser()) {
            $this->em->remove($selectedAddress);
            $this->em->flush();
        }

        return $this->redirectToRoute('account_address');
    }
}
