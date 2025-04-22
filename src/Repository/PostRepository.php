<?php

namespace App\Repository;

use App\Entity\Like;
use App\Entity\Post;
use App\Repository\LikeRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function getLikesbyId(Int $post_id, Int $user_id, LikeRepository $like_repository): array
    {
        $likes = $like_repository->findBy([
            'post' => $post_id,
            'user' => $user_id
            ]);

        return $likes;
    }

    public function getDislikesbyId(Int $post_id, Int $user_id, DislikeRepository $dislike_repository): array
    {
        $dislikes = $dislike_repository->findBy([
            'post' => $post_id,
            'user' => $user_id
            ]);

        return $dislikes;
    }
}
