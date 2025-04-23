<?php

namespace App\Controller;

use App\Form\NewPostType;
use App\Repository\DislikeRepository;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PostRepository $post_repository, LikeRepository $like_repository, DislikeRepository $dislike_repository): Response
    {
        $allposts = $post_repository->findBy(['relatedpost' => null], ['created_at' => 'DESC']);

        $newpostform = $this->createForm(NewPostType::class);

        $user = $this->getUser();

        $likes = [];
        $dislikes = [];

        if ($user != null){
            foreach ($allposts as $post) {
                $likes[$post->getId()] = count($post_repository->getLikesbyId($post->getId(), $user->getId(), $like_repository));
                $dislikes[$post->getId()] = $post_repository->getDislikesbyId($post->getId(), $user->getId(), $dislike_repository);
            }    
        }

        // TODO infinite scroll

        return $this->render('main/index.html.twig', [
            'allposts' => $allposts,
            'newpostform' => $newpostform,
            'likes' => $likes,
            'dislikes' => $dislikes,
        ]);        
    }
}
