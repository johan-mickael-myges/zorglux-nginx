<?php

namespace App\Service\Blog;

use App\Entity\Blog;
use App\Entity\Comment;
use App\Service\User\UserService;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

readonly class CommentService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserService            $userService,
    )
    {
    }

    public function comment(Blog $blog, string $content): void
    {
        $user = $this->userService->getCurrentUser();

        if (empty($user)) {
            throw new \Exception('You must be logged in to comment');
        }

        $comment = new Comment();

        $comment->setContent($content);
        $comment->setBlog($blog);
        $comment->setAuthor($user);
        $comment->setCreatedAt(new DateTimeImmutable());

        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }
}
