<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em )
    {
        $this->em = $em;
    }

    /**
     * @Route("/compte/modification-password", name="account_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $oldPassword = $form->get('old_password')->getData();

            if ($encoder->isPasswordValid($user, $oldPassword))
            {
                $newPassword = $form->get('new_password')->getData();
                $password = $encoder->encodePassword($user, $newPassword);
                $user->setPassword($password);

                $this->em->flush();
                return $this->redirectToRoute('account');
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
