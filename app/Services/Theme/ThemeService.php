<?php

namespace App\Services\Theme;

use App\Contracts\ThemeInterface;
use App\Models\User;

class ThemeService
{
    public function __construct(
        protected ThemeRegistry $registry
    ) {}

    /**
     * Retorna o tema ativo do usuário
     */
    public function getActiveTheme(?User $user = null): ThemeInterface
    {
        if (!$user) {
            return $this->getDefaultTheme();
        }

        $themeIdentifier = $user->systemSetting?->template?->slug ?? 'zinc';

        if (!$this->registry->has($themeIdentifier)) {
            return $this->getDefaultTheme();
        }

        return $this->registry->get($themeIdentifier);
    }

    /**
     * Retorna o tema padrão
     */
    public function getDefaultTheme(): ThemeInterface
    {
        return $this->registry->get('zinc');
    }

    /**
     * Retorna todos os temas disponíveis
     */
    public function getAvailableThemes(): array
    {
        return $this->registry->toArray();
    }

    /**
     * Verifica se um tema existe
     */
    public function themeExists(string $identifier): bool
    {
        return $this->registry->has($identifier);
    }

    /**
     * Define o tema de um usuário
     */
    public function setUserTheme(User $user, string $themeIdentifier): bool
    {
        if (!$this->themeExists($themeIdentifier)) {
            return false;
        }

        $template = \App\Models\Template::firstOrCreate(
            ['slug' => $themeIdentifier],
            ['name' => $this->registry->get($themeIdentifier)->getName()]
        );

        $systemSetting = $user->systemSetting()->firstOrCreate([]);
        $systemSetting->template_id = $template->id;
        $systemSetting->save();

        return true;
    }

    /**
     * Retorna as configurações do tema ativo
     */
    public function getActiveThemeConfig(?User $user = null): array
    {
        return $this->getActiveTheme($user)->getConfig();
    }

    /**
     * Retorna uma view do tema ativo
     */
    public function view(string $view, array $data = [], ?User $user = null): string
    {
        $theme = $this->getActiveTheme($user);
        $viewPath = $theme->getIdentifier() . '::' . $view;

        if (!view()->exists($viewPath)) {
            // Fallback para o tema padrão
            $viewPath = 'zinc::' . $view;
        }

        return view($viewPath, $data)->render();
    }
}
