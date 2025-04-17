<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entity_manager): Response
    {
        $posts = $entity_manager->getRepository(Post::class)->findAll();

        return $this->render('main/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
