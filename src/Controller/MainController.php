<?php

namespace App\Controller;

use App\Form\NewPostType;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use App\Repository\DislikeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PostRepository $post_repository, LikeRepository $like_repository, DislikeRepository $dislike_repository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);

        $data = $post_repository->getPostPaginated($page, null);;

        $newpostform = $this->createForm(NewPostType::class);

        $user = $this->getUser();

        $likes = [];
        $dislikes = [];

        if ($user != null && isset($data['posts'])){
            foreach ($data['posts'] as $post) {
                $likes[$post->getId()] = count($post_repository->getLikesbyId($post->getId(), $user->getId(), $like_repository));
                $dislikes[$post->getId()] = $post_repository->getDislikesbyId($post->getId(), $user->getId(), $dislike_repository);
            }    
        }

        return $this->render('main/index.html.twig', [
            'allposts' => isset($data['posts']) ? $data['posts'] : [],
            'newpostform' => $newpostform,
            'likes' => $likes,
            'dislikes' => $dislikes,
            'pages' => isset($data['pages']) ? $data['pages'] : 0,
            'currentpage' => $page,
        ]);        
    }
}
