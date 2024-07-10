<?php

namespace App\Twig\Components;

use App\Entity\Blog;
use App\Form\BlogCommentType;
use App\Repository\BlogRepository;
use App\Service\Blog\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsLiveComponent]
class Comments extends AbstractController
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp]
    public ?int $commentCount = 0;

    #[LiveProp]
    public ?bool $show = false;

    #[LiveProp(writable: true)]
    public ?string $currentComment = null;

    #[LiveProp]
    public ?Blog $blog = null;

    #[LiveProp]
    public ?string $variant = null;

    public function __construct(
        private readonly CommentService $commentService,
        private readonly BlogRepository $blogRepository,
        private readonly Security $security,
    ) {
    }

    #[LiveAction]
    public function addComment()
    {
        if (empty($this->security->getUser())) {
            return $this->redirectToRoute('app_login');
        }

        if (empty($this->blog)) {
            return;
        }

        if (empty($this->currentComment)) {
            return;
        }

        $this->commentService->comment($this->blog, $this->currentComment);
        $this->currentComment = null;
        $this->commentCount++;
        $this->emit('commentAdded');
    }

    #[PreMount]
    public function preMount(array $data): void
    {
        $blog = $data['blog'] ?? null;

        if (empty($blog)) {
            return;
        }

        $this->commentCount = $blog->getComments()->count();
    }
}
