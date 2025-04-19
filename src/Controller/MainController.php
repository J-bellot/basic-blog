<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\NewPostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $entity_manager): Response
    {
        $allposts = $entity_manager->getRepository(Post::class)->findAll();

        $post = new Post();

        $newpostform = $this->createForm(NewPostType::class, $post);

        return $this->render('main/index.html.twig', [
            'allposts' => $allposts,
            'newpostform' => $newpostform,
        ]);
    }
}
