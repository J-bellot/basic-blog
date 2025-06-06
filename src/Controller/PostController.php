<?php

namespace App\Controller;

use App\Entity\Post;
use DateTimeImmutable;
use App\Form\NewPostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PostController extends AbstractController
{
    #[Route('/new-post', name: 'new_post')]
    public function newPost(EntityManagerInterface $entity_manager_interface, Request $request): RedirectResponse
    {
        $user = $this->getUser();

        if ($user == null){
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(NewPostType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            
            $post = new Post();
            $post
                ->setContent($form['content']->getData())
                ->setCreatedAt(new DateTimeImmutable())
                ->setUser($user)
                ->setRelatedpost($form['relatedpost']->getData());
            

            $entity_manager_interface->persist($post);
            $entity_manager_interface->flush();
        }

        if ($form['relatedpost']->getData() != null){
            return $this->redirectToRoute('post_detail', ['id' => $form['relatedpost']->getData()]);
        }

        return $this->redirectToRoute('home');
    }

    #[Route('/post/{id}', name: 'post_detail')]
    public function postDetail(string $id, PostRepository $repository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);

        $post = $repository->findOneBy(['id' => $id]);
        $allcomments = $repository->getPostPaginated($page, $id);
        $comment = new Post();
        $comment->setRelatedpost($id);

        $commentform = $this->createForm(NewPostType::class, $comment);

        return $this->render('post/detail.html.twig',[
            'commentform' => $commentform,
            'post' => $post,
            'allcomments' => isset($allcomments['posts']) ? $allcomments['posts'] : [],
            'currentpage' => $page,
            'pages' => isset($allcomments['pages']) ? $allcomments['pages'] : 0
        ]);
    }
}
