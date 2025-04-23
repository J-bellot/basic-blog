<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Dislike;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
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

        if ($this->checkLikeDislikeExist($entity_manager, $data['action'], $data['postId'], $data['userId'])){
            return new JsonResponse(['message' => 'déjà liké ou disliké']);
        }

        $like_dislike = ($data['action'] == 'like' ? new Like() :  new Dislike());

        $like_dislike
            ->setPost($entity_manager->getRepository(Post::class)->findOneBy(['id' => $data['postId']]))
            ->setUser($entity_manager->getRepository(User::class)->findOneBy(['id' => $data['userId']]));

        $entity_manager->persist($like_dislike);

        $entity_manager->flush();

        // TODO refresh le nombre de like et de dislike ce serait cool
        // TODO cancel like if liked et cancel like if dislike et inversement
        
        return new JsonResponse(['message' => 'Action enregistrée !']);
    }

    public function checkLikeDislikeExist(EntityManagerInterface $entity_manager, String $type, Int $post_id, Int $user_id): bool
    {
        if ($type == 'like'){
            $repository = $entity_manager->getRepository(Like::class);
        }

        if ($type == 'dislike'){
            $repository = $entity_manager->getRepository(Dislike::class);
        }

        if (isset($repository)){
            $entity = $repository->findOneBy([
                'post' => $post_id,
                'user' => $user_id,
            ]);
            
            if ($entity != null){
                return true;
            }
        }
        
        return false;
    }
}
