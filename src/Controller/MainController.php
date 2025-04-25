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
        $data = $post_repository->getPostPaginated(1, null);;

        $newpostform = $this->createForm(NewPostType::class);

        $user = $this->getUser();

        $likes = [];
        $dislikes = [];

        if ($user != null){
            foreach ($data['posts'] as $post) {
                $likes[$post->getId()] = count($post_repository->getLikesbyId($post->getId(), $user->getId(), $like_repository));
                $dislikes[$post->getId()] = $post_repository->getDislikesbyId($post->getId(), $user->getId(), $dislike_repository);
            }    
        }

        return $this->render('main/index.html.twig', [
            'allposts' => $data['posts'],
            'newpostform' => $newpostform,
            'likes' => $likes,
            'dislikes' => $dislikes,
            'pages' => $data['pages'],
            'current_page' => $data['page'],
        ]);        
    }
}
