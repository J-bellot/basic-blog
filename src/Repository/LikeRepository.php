<?php

namespace App\Repository;

use App\Entity\Like;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Like>
 */
class LikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Like::class);
    }

    public function checkLikeExists(Int $post_id, Int $user_id): ?Like
    {
        $entity = $this->findOneBy([
            'post' => $post_id,
            'user' => $user_id,
        ]);
        
        return $entity;
    }
}
