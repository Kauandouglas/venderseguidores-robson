<?php

namespace App\Providers;

use App\Services\Theme\ThemeRegistry;
use App\Services\Theme\ThemeService;
use App\Themes\Modern\ModernTheme;
use App\Themes\Turbina\TurbinaTheme;
use App\Themes\Zinc\ZincTheme;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Registra os serviços
     */
    public function register(): void
    {
        $this->app->singleton(ThemeRegistry::class);
        $this->app->singleton(ThemeService::class);
    }

    /**
     * Bootstrap dos serviços
     */
    public function boot(): void
    {
        $registry = $this->app->make(ThemeRegistry::class);

        // Registrar temas disponíveis
        $registry->register(new ZincTheme());
        $registry->register(new TurbinaTheme());
        $registry->register(new ModernTheme());

        // Inicializar os temas
        foreach ($registry->all() as $theme) {
            $theme->boot();
        }
    }
}
