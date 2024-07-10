<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class SocialShare
{
    public string $service = 'twitter';
    public string $url = '';
    public string $icon = '';
    public string $text = '';
    public string $title = '';

    public function getUrl(): string {
        return match ($this->service) {
            'twitter' => 'https://twitter.com/intent/tweet?url=' . $this->url . '&text=' . $this->text,
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . $this->url,
            'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $this->url,
            'reddit' => 'https://www.reddit.com/submit?url=' . $this->url,
            default => '#'
        };
    }

    public function getIcon(): string {
        return match ($this->service) {
            'twitter' => 'fab fa-twitter',
            'facebook' => 'fab fa-facebook',
            'linkedin' => 'fab fa-linkedin',
            'reddit' => 'fab fa-reddit',
            default => ''
        };
    }
}
