<?php

namespace App\Contracts;

interface ThemeInterface
{
    /**
     * Retorna o nome do tema
     */
    public function getName(): string;

    /**
     * Retorna o identificador único do tema
     */
    public function getIdentifier(): string;

    /**
     * Retorna a versão do tema
     */
    public function getVersion(): string;

    /**
     * Retorna o autor do tema
     */
    public function getAuthor(): string;

    /**
     * Retorna a descrição do tema
     */
    public function getDescription(): string;

    /**
     * Retorna a URL da thumbnail do tema
     */
    public function getThumbnail(): string;

    /**
     * Retorna o caminho base do tema
     */
    public function getBasePath(): string;

    /**
     * Retorna o caminho das views
     */
    public function getViewsPath(): string;

    /**
     * Retorna o caminho dos assets
     */
    public function getAssetsPath(): string;

    /**
     * Retorna as configurações do tema
     */
    public function getConfig(): array;

    /**
     * Retorna os layouts disponíveis
     */
    public function getLayouts(): array;

    /**
     * Retorna os componentes disponíveis
     */
    public function getComponents(): array;

    /**
     * Retorna as features suportadas
     */
    public function getFeatures(): array;

    /**
     * Registra o tema no sistema
     */
    public function register(): void;

    /**
     * Inicializa o tema
     */
    public function boot(): void;

    /**
     * Verifica se o tema suporta uma feature
     */
    public function supports(string $feature): bool;
}
