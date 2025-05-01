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

final class LikeController extends AbstractController
{
    #[Route('/add-like', name: 'add_like')]
    public function index(EntityManagerInterface $entity_manager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $like_repository = $entity_manager->getRepository(Like::class);

        $like = $like_repository->checkLikeExists($data['postId'], $data['userId']);

        if ($like != null) {
            $entity_manager->remove($like);

            $entity_manager->flush();

            $post_likes = count($like_repository->findBy([
                'post' => $data['postId']
            ]));
    
            $post_dislikes = count($entity_manager->getRepository(Dislike::class)->findBy([
                'post' => $data['postId']
            ]));    

            return new JsonResponse([
                'like' => $post_likes,
                'dislike' => $post_dislikes, 
                ]);
        }

        $dislike = $entity_manager->getRepository(Dislike::class)->checkDislikeExists($data['postId'], $data['userId']);

        if ($dislike != null) {
            $entity_manager->remove($dislike);
        }

        $like = new Like();
            
        $like
            ->setPost($entity_manager->getRepository(Post::class)->findOneBy(['id' => $data['postId']]))
            ->setUser($entity_manager->getRepository(User::class)->findOneBy(['id' => $data['userId']]));

        $entity_manager->persist($like);

        $entity_manager->flush();

        $post_likes = count($like_repository->findBy([
            'post' => $data['postId']
        ]));

        $post_dislikes = count($entity_manager->getRepository(Dislike::class)->findBy([
            'post' => $data['postId']
        ]));

        return new JsonResponse([
            'like' => $post_likes,
            'dislike' => $post_dislikes, 
        ]);
    }
}
