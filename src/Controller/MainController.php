<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\NewPostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $entity_manager, Request $request): Response
    {
        $allposts = $entity_manager->getRepository(Post::class)->findBy(['relatedpost' => null], ['created_at' => 'DESC']);

        $newpostform = $this->createForm(NewPostType::class);

        return $this->render('main/index.html.twig', [
            'allposts' => $allposts,
            'newpostform' => $newpostform,
        ]);
    }
}
