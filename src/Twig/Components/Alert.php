<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Alert
{
     public string $text = '';

     public string $color = 'primary';

     public string $icon = '';

     public string $variant = 'normal';

     public string $classes = '';
}
