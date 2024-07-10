<?php

namespace App\Twig\Components;

use Symfony\Component\Asset\Packages;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Avatar
{
    public function __construct(
        public ?string $img = '',
        public string $name = '',
        public int $size = 25,
        public string $classes = '',
        public string $imageClasses = '',
        public string $usernameClasses = '',
        public bool $rounded = true,
    ) {
    }

    public function getImg(): string {
        return empty($this->img)
            ? 'https://zorglux-bucket.s3.eu-north-1.amazonaws.com/default/avatar.jpg'
            : $this->img;
    }

    public function getImageClasses(): string {
        return $this->imageClasses . ($this->rounded ? ' rounded-full' : '');
    }
}
