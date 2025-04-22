<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Dislike;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class LikeDislikeController extends AbstractController
{
    #[Route('/add-like-dislike', name: 'add_like_dislike')]
    public function index(EntityManagerInterface $entity_manager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $like_dislike = ($data['action'] == 'like' ? new Like() :  new Dislike());

        $like_dislike
            ->setPost($entity_manager->getRepository(Post::class)->findOneBy(['id' => $data['postId']]))
            ->setUser($entity_manager->getRepository(User::class)->findOneBy(['id' => $data['userId']]));

        $entity_manager->persist($like_dislike);

        $entity_manager->flush();

        return new JsonResponse(['message' => 'Action enregistrée !']);
    }
}
