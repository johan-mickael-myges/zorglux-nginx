<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Container
{
    public array $wrapperClasses = [
        'flex',
        'flex-row',
        'justify-center',
    ];
    private array $defaultClasses = [
        'px-5',
        'md:px-10',
        'w-full',
        'md:w-2/3',
        'xl:w-1/2',
        '2xl:w-1/3',
    ];

    public array $classes = [];
    public bool $useDefaultClasses = true;

    public function getHtmlClass(): string
    {
        if ($this->useDefaultClasses) {
            $this->classes = array_merge($this->classes, $this->defaultClasses);
        }

        return implode(' ', $this->classes);
    }

    public function getWrapperClasses(): string
    {
        return implode(' ', $this->wrapperClasses);
    }
}
