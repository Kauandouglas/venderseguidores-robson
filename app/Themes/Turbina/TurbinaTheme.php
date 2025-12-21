<?php

namespace App\Themes\Turbina;

use App\Themes\AbstractTheme;

class TurbinaTheme extends AbstractTheme
{
    public function getName(): string
    {
        return 'Turbina Theme';
    }

    public function getIdentifier(): string
    {
        return 'turbina';
    }

    public function getVersion(): string
    {
        return '1.0.0';
    }

    public function getAuthor(): string
    {
        return 'Original Author';
    }

    public function getDescription(): string
    {
        return 'Tema Turbina - Design moderno e dinâmico';
    }

    public function getThumbnail(): string
    {
        return asset('template_assets/turbina/images/thumbnail.jpg');
    }

    public function getBasePath(): string
    {
        return resource_path('views/templates/turbina');
    }
}
