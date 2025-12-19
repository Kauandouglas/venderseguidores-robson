<?php

namespace App\Services\Theme;

use App\Contracts\ThemeInterface;
use App\Exceptions\Theme\ThemeNotFoundException;

class ThemeRegistry
{
    /**
     * @var array<string, ThemeInterface>
     */
    protected array $themes = [];

    /**
     * Registra um tema
     */
    public function register(ThemeInterface $theme): void
    {
        $this->themes[$theme->getIdentifier()] = $theme;
        $theme->register();
    }

    /**
     * Retorna um tema pelo identificador
     */
    public function get(string $identifier): ThemeInterface
    {
        if (!isset($this->themes[$identifier])) {
            throw new ThemeNotFoundException("Theme '{$identifier}' not found.");
        }

        return $this->themes[$identifier];
    }

    /**
     * Verifica se um tema existe
     */
    public function has(string $identifier): bool
    {
        return isset($this->themes[$identifier]);
    }

    /**
     * Retorna todos os temas registrados
     */
    public function all(): array
    {
        return $this->themes;
    }

    /**
     * Retorna os identificadores de todos os temas
     */
    public function identifiers(): array
    {
        return array_keys($this->themes);
    }

    /**
     * Retorna informações de todos os temas
     */
    public function toArray(): array
    {
        return array_map(function (ThemeInterface $theme) {
            return [
                'identifier' => $theme->getIdentifier(),
                'name' => $theme->getName(),
                'version' => $theme->getVersion(),
                'author' => $theme->getAuthor(),
                'description' => $theme->getDescription(),
                'thumbnail' => $theme->getThumbnail(),
                'features' => $theme->getFeatures(),
            ];
        }, $this->themes);
    }
}
