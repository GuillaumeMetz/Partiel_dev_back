<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Like;
use App\Entity\Dislike;
use App\Entity\Post;
use App\Form\CommentaireType;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AffichagepostController extends AbstractController
{
    #[Route('/{id}', name: 'app_view_post', methods: ['GET'])]
    public function post(PostRepository $postRepository, Request $request,EntityManagerInterface $entityManager):Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentaireType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser())->setPost($postRepository);
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('app_view_post',['id' =>$postRepository->getId()]);
        }
    }

    #[Route('/likes/{id}', name: 'app_view_comment_like', methods: ['GET'])]
    public function like(Comment $comment,EntityManagerInterface $entityManager):Response
    {
        $like = new Like();
        $like->setUser($this->getUser())->setComment($comment);
        $entityManager->persist($like);
        $entityManager->flush();
        return $this->redirectToRoute('app_view_post',['id' =>$comment->getPost()->getId(), 'slug'=>$comment->getPost()->getSlug()]);

    }
    #[Route('/dislike/{id}', name: 'app_view_comment_dislike', methods: ['GET'])]
    public function dislike(Comment $comment,EntityManagerInterface $entityManager):Response
    {
        $dislike = new Dislike();
        $dislike->setUser($this->getUser())->setComment($comment);
        $entityManager->persist($dislike);
        $entityManager->flush();
        return $this->redirectToRoute('app_view_post',['id' =>$comment->getPost()->getId(), 'slug'=>$comment->getPost()->getSlug()]);

    }
}
