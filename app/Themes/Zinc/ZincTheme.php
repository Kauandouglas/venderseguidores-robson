<?php

namespace App\Themes\Zinc;

use App\Themes\AbstractTheme;

class ZincTheme extends AbstractTheme
{
    public function getName(): string
    {
        return 'Zinc Theme';
    }

    public function getIdentifier(): string
    {
        return 'zinc';
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
        return 'Tema Zinc original do sistema - Design clean e profissional';
    }

    public function getThumbnail(): string
    {
        return asset('template_assets/zinc/images/thumbnail.jpg');
    }

    public function getBasePath(): string
    {
        return resource_path('views/templates/zinc');
    }
}
