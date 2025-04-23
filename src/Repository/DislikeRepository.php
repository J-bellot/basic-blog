<?php

namespace App\Repository;

use App\Entity\Dislike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dislike>
 */
class DislikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dislike::class);
    }

    public function checkDislikeExists(Int $post_id, Int $user_id): ?Dislike
    {        
        $entity = $this->findOneBy([
            'post' => $post_id,
            'user' => $user_id,
        ]);
        
        return $entity;
    }
}
