<?php

namespace App\Twig\Components;

use App\Entity\Blog;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class CommentButton
{
    use DefaultActionTrait;

    #[LiveProp]
    public ?int $comments = 0;

    #[LiveProp]
    public ?bool $commented = false;

    #[LiveProp]
    public ?bool $showComments = false;

    #[LiveProp]
    public ?bool $withCommentsContainer = true;

    #[LiveProp]
    public ?Blog $blog = null;

    public function __construct(

    ) {

    }

    public function getIconType(): string
    {
        return $this->commented ? 'fa-solid' : 'fa-regular';
    }

    #[LiveListener('commentAdded')]
    public function incrementCommentCount()
    {
        $this->comments++;
    }

}
