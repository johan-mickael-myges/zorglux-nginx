<?php

namespace App\Twig\Components;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class CommentItem extends AbstractController
{
    public Comment $comment;
}
