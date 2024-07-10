<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Typography
{
    public function __construct(
        public string $text = '',
        public string $variant = 'default',
        public string $tag = 'span',
        public string $align = 'left',
        public string $fstyle = 'normal'
    ) {
    }

    public function getSizeClass(): string
    {
        return match ($this->variant) {
            'default' => 'text-base',
            'body1' => 'text-4xl',
            'body2' => 'text-3xl',
            'body3' => 'text-2xl',
            'body4' => 'text-xl',
            'body5' => 'text-lg',
            'body6' => 'text-base',
            'subtitle1' => 'text-lg',
            'subtitle2' => 'text-base',
            'small' => 'text-sm',
            'caption' => 'text-xs',
            'overline' => 'text-xs',
            default => 'text-base',
        };
    }

    public function getAlignClass(): string
    {
        return match ($this->align) {
            'left' => 'text-left',
            'center' => 'text-center',
            'right' => 'text-right',
            default => 'text-left',
        };
    }

    public function getFontStyleClass(): string
    {
        return match ($this->fstyle) {
            'extrabold' => 'font-extrabold',
            'bold' => 'font-bold',
            'semibold' => 'font-semibold',
            'italic' => 'font-italic',
            default => '',
        };
    }

    public function getClass(): string
    {
        return implode(' ', $this->getClassArray());
    }

    private function getClassArray(): array
    {
        return [
            $this->getSizeClass(),
            $this->getAlignClass(),
            $this->getFontStyleClass(),
        ];
    }
}
