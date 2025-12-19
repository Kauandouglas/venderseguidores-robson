<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Theme\ThemeService;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function __construct(
        protected ThemeService $themeService
    ) {}

    public function index()
    {
        $themes = $this->themeService->getAvailableThemes();

        return view('admin.themes.index', compact('themes'));
    }

    public function show(string $identifier)
    {
        if (!$this->themeService->themeExists($identifier)) {
            abort(404, 'Tema não encontrado');
        }

        $theme = $this->themeService->getActiveTheme();
        $config = $theme->getConfig();

        return view('admin.themes.show', compact('theme', 'config'));
    }

    public function preview(string $identifier)
    {
        if (!$this->themeService->themeExists($identifier)) {
            abort(404, 'Tema não encontrado');
        }

        // Retorna uma preview do tema
        return view('admin.themes.preview', compact('identifier'));
    }
}
