<?php

namespace App\Twig\Components;

use Symfony\Component\Form\FormView;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class InputFile
{
    public string $classes;

    public FormView $form;

    public function getClasses(): string
    {
        return implode(' ', [
            'text-sm',
            'text-gray-500',
            'file:mr-5',
            'file:py-2',
            'file:px-6',
            'file:rounded-full',
            'file:border-0',
            'file:text-sm',
            'file:bg-gray-100',
            'hover:cursor-pointer',
            'hover:file:cursor-pointer',
            'hover:file:bg-gray-200',
            'w-full',
        ]) . ' ' . $this->classes;
    }
}
