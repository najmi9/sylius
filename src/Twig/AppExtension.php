<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('button', [$this, 'button'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function button(string $content, string $color = 'primary', string $icon = null, string $type = 'button'): string
    {
        $btn = "<button class='btn btn-{$color}' type='{$type}'>";

        if ($icon) {
            $btn .= "<i class='fas fa-{$icon}'></i>";
        }

        $btn .= "$content</button>";

        return $btn;
    }
}