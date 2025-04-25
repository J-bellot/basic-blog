<?php

namespace App\Repository;

use App\Entity\Post;
use App\Repository\LikeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\Limit;
use Doctrine\ORM\Tools\Pagination\Paginator;

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

    public function getPostPaginated(Int $page, ?int $related_post, int $limit = 10): array
    {
        $limit = abs($limit);

        $result = [];

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('App\Entity\Post', 'p')
            ->where($related_post != null ? "p.relatedpost = '$related_post'" : 'p.relatedpost is null')
            ->orderBy('p.created_at', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit);

        $paginator = new Paginator($query);

        $data = $paginator->getQuery()->getResult();

        if(empty($data)){
            return $result;
        }

        $pages = ceil($paginator->count() / $limit);

        $result['posts'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;

        return $result;
    }
}
