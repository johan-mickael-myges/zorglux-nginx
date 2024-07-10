<?php

namespace App\Twig\Components;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use App\Repository\UserRepository;
use App\Service\Blog\LikeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsLiveComponent]
class LikeButton extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?bool $liked = false;
    #[LiveProp(writable: true)]
    public ?int $likes = 0;

    #[LiveProp]
    public ?Blog $blog = null;

    #[LiveProp]
    public ?string $classes = '';

    public function __construct(
        private readonly Security $security,
        private readonly LikeService $likeService,
        private readonly BlogRepository $blogRepository,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function getIconType(): string
    {
        return $this->liked ? 'fa-solid text-red-500' : 'fa-regular';
    }

    #[LiveAction]
    public function toggleLike()
    {
        if (!$this->security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_login');
        }

        $userInterface = $this->security->getUser();
        $user = $this->userRepository->find($userInterface->getId());
        $isLiked = $this->likeService->isLiked($user, $this->blog);

        if ($isLiked) {
            $this->likeService->unlike($user, $this->blog);
        } else {
            $this->likeService->like($user, $this->blog);
        }

        // Rerender the component
        $this->liked = !$this->liked;
        $this->likes = $this->blog->getLikes()->count();
    }

    #[PreMount]
    public function preMount(array $data)
    {
        $this->blog = $data['blog'];
        $this->likes = $this->blog->getLikes()->count();

        $userInterface = $this->security->getUser();
        if ($userInterface !== null) {
            $user = $this->userRepository->find($userInterface->getId());
            $this->liked = $this->likeService->isLiked($user, $this->blog);
        }
    }
}
