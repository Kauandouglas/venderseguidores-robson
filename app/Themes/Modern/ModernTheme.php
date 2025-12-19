<?php

namespace App\Themes\Modern;

use App\Themes\AbstractTheme;

class ModernTheme extends AbstractTheme
{
    public function getName(): string
    {
        return 'Modern Theme';
    }

    public function getIdentifier(): string
    {
        return 'modern';
    }

    public function getVersion(): string
    {
        return '1.0.0';
    }

    public function getAuthor(): string
    {
        return 'Painel SMM Team';
    }

    public function getDescription(): string
    {
        return 'Tema moderno com Tailwind CSS - Design responsivo e elegante';
    }

    public function getThumbnail(): string
    {
        return asset('template_assets/modern/images/thumbnail.jpg');
    }

    public function getBasePath(): string
    {
        return resource_path('views/templates/modern');
    }
}
