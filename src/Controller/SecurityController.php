<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\NewUserType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $entity_manager, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $user_authenticator, UserAuthenticator $authenticator): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $user = new User();

        $registerform = $this->createForm(NewUserType::class, $user);

        $registerform->handleRequest($request);

        if ($registerform->isSubmitted() && $registerform->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $registerform->get('password')->getData()
                )
            );

            $user->setRoles(['ROLE_USER']);

            $entity_manager->persist($user);
            $entity_manager->flush();


            return $user_authenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('/security/register.html.twig',[
            'registerform' => $registerform
        ]);
    }
}