<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/new-post', name: 'new_post')]
    public function index(EntityManagerInterface $entity_manager_interface, Request $request): RedirectResponse
    {
        $user = $this->getUser();

        if ($user == null){
            return $this->redirectToRoute('app_login');
        }

        dd($request->query->all('new_post')['content']);
        $post = 0;

        return $this->redirectToRoute('home');
    }
}
