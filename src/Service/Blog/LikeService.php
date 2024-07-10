<?php

namespace App\Service\Blog;

use App\Entity\Blog;
use App\Entity\Like;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class LikeService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function like(User $user, Blog $post): void
    {
        $like = new Like();

        $like->setLiker($user);
        $like->setPost($post);

        $this->entityManager->persist($like);
        $this->entityManager->flush();
    }

    public function unlike(User $user, Blog $post): void
    {
        $like = $this->entityManager->getRepository(Like::class)
            ->findOneBy([
                'liker' => $user,
                'post' => $post
            ]);

        if ($like) {
            $this->entityManager->remove($like);
            $this->entityManager->flush();
        }
    }

    public function isLiked(User $user, Blog $post): bool
    {
        return $this->entityManager->getRepository(Like::class)
            ->findOneBy([
                'liker' => $user,
                'post' => $post
            ]) !== null;
    }
}
