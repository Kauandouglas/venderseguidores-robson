<?php

namespace App\Themes;

use App\Contracts\ThemeInterface;

abstract class AbstractTheme implements ThemeInterface
{
    protected array $config = [];

    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * Carrega as configurações do tema
     */
    protected function loadConfig(): void
    {
        $configPath = $this->getBasePath() . '/config.php';
        
        if (file_exists($configPath)) {
            $this->config = require $configPath;
        }
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getLayouts(): array
    {
        return $this->config['layouts'] ?? [];
    }

    public function getComponents(): array
    {
        return $this->config['components'] ?? [];
    }

    public function getFeatures(): array
    {
        return $this->config['features'] ?? [];
    }

    public function supports(string $feature): bool
    {
        return ($this->config['features'][$feature] ?? false) === true;
    }

    public function getViewsPath(): string
    {
        return $this->getBasePath() . '/views';
    }

    public function getAssetsPath(): string
    {
        return $this->getBasePath() . '/assets';
    }

    public function register(): void
    {
        // Registra o namespace das views do tema
        view()->addNamespace($this->getIdentifier(), $this->getViewsPath());
    }

    public function boot(): void
    {
        // Pode ser sobrescrito pelas classes filhas
    }

    /**
     * Retorna o caminho base do tema
     */
    abstract public function getBasePath(): string;
}
