# Como Adicionar um Novo Tema

Este guia mostra como adicionar um novo tema ao sistema de forma simples e rápida.

## Passo 1: Criar a Classe do Tema

Crie uma nova classe em `app/Themes/SeuTema/SeuTema.php`:

```php
<?php

namespace App\Themes\SeuTema;

use App\Themes\AbstractTheme;

class SeuTema extends AbstractTheme
{
    public function getName(): string
    {
        return 'Seu Tema';
    }

    public function getIdentifier(): string
    {
        return 'seutema'; // identificador único (slug)
    }

    public function getVersion(): string
    {
        return '1.0.0';
    }

    public function getAuthor(): string
    {
        return 'Seu Nome';
    }

    public function getDescription(): string
    {
        return 'Descrição do seu tema';
    }

    public function getThumbnail(): string
    {
        return asset('template_assets/seutema/images/thumbnail.jpg');
    }

    public function getBasePath(): string
    {
        return resource_path('views/templates/seutema');
    }
}
```

## Passo 2: Criar o Arquivo de Configuração

Crie `app/Themes/SeuTema/config.php`:

```php
<?php

return [
    'name' => 'Seu Tema',
    'version' => '1.0.0',
    'author' => 'Seu Nome',
    'description' => 'Descrição do seu tema',

    'colors' => [
        'primary' => '#3b82f6',
        'secondary' => '#8b5cf6',
        'accent' => '#06b6d4',
        'success' => '#10b981',
        'danger' => '#ef4444',
        'warning' => '#f59e0b',
        'info' => '#3b82f6',
    ],

    'features' => [
        'dark_mode' => true,
        'rtl_support' => false,
        'animations' => true,
        'responsive' => true,
        'custom_colors' => true,
    ],

    'layouts' => [
        'home' => 'seutema::layouts.home',
        'product' => 'seutema::layouts.product',
        'cart' => 'seutema::layouts.cart',
        'checkout' => 'seutema::layouts.checkout',
    ],

    'components' => [
        'header' => 'seutema::components.header',
        'footer' => 'seutema::components.footer',
        'product-card' => 'seutema::components.product-card',
        'cart-item' => 'seutema::components.cart-item',
    ],

    'settings' => [
        'show_logo' => true,
        'show_search' => true,
        'show_categories' => true,
        'products_per_page' => 12,
    ],
];
```

## Passo 3: Criar as Views

Crie a estrutura de views em `resources/views/templates/seutema/`:

```
resources/views/templates/seutema/
├── layouts/
│   ├── home.blade.php
│   ├── product.blade.php
│   ├── cart.blade.php
│   └── checkout.blade.php
├── components/
│   ├── header.blade.php
│   ├── footer.blade.php
│   ├── product-card.blade.php
│   └── cart-item.blade.php
└── partials/
    ├── navbar.blade.php
    └── sidebar.blade.php
```

## Passo 4: Criar os Assets

Crie os assets em `public/template_assets/seutema/`:

```
public/template_assets/seutema/
├── css/
│   └── style.css
├── js/
│   └── script.js
└── images/
    └── thumbnail.jpg
```

## Passo 5: Registrar o Tema

Abra `app/Providers/ThemeServiceProvider.php` e adicione seu tema:

```php
public function boot(): void
{
    $registry = $this->app->make(ThemeRegistry::class);

    // Registrar temas disponíveis
    $registry->register(new ZincTheme());
    $registry->register(new TurbinaTheme());
    $registry->register(new ModernTheme());
    $registry->register(new SeuTema()); // ← Adicione aqui

    // Inicializar os temas
    foreach ($registry->all() as $theme) {
        $theme->boot();
    }
}
```

Não esqueça de adicionar o `use` no topo do arquivo:

```php
use App\Themes\SeuTema\SeuTema;
```

## Passo 6: Testar o Tema

1. Acesse o painel admin em `/admin/themes`
2. Você verá seu novo tema listado
3. Configure o tema para um usuário no painel
4. Acesse a loja do usuário para ver o tema em ação

## Exemplo de Layout Home

```blade
{{-- resources/views/templates/seutema/layouts/home.blade.php --}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $systemSetting->title ?? 'Loja' }}</title>
    <link href="{{ asset('template_assets/seutema/css/style.css') }}" rel="stylesheet">
</head>
<body>
    @include('seutema::components.header')

    <main>
        @yield('content')
    </main>

    @include('seutema::components.footer')

    <script src="{{ asset('template_assets/seutema/js/script.js') }}"></script>
</body>
</html>
```

## Dicas

1. **Use Tailwind CSS**: Para facilitar o desenvolvimento, use Tailwind CSS
2. **Seja Responsivo**: Garanta que o tema funcione em mobile, tablet e desktop
3. **Siga os Padrões**: Use os mesmos nomes de variáveis que os outros temas
4. **Teste Bem**: Teste todas as páginas (home, produto, carrinho, checkout)
5. **Documentação**: Documente as features especiais do seu tema

## Estrutura Recomendada de Views

### layouts/home.blade.php
- Layout principal da página inicial
- Deve incluir header, content e footer

### layouts/product.blade.php
- Layout da página de produto/serviço
- Deve mostrar detalhes do serviço e formulário de compra

### layouts/cart.blade.php
- Layout do carrinho de compras
- Deve listar produtos e permitir edição

### layouts/checkout.blade.php
- Layout da finalização de compra
- Deve ter formulário de pagamento

### components/header.blade.php
- Cabeçalho com logo, menu e busca

### components/footer.blade.php
- Rodapé com links e informações

### components/product-card.blade.php
- Card de produto para listagem
- Deve ser reutilizável

### components/cart-item.blade.php
- Item do carrinho
- Deve permitir edição de quantidade

## Variáveis Disponíveis

Nas views, você terá acesso a:

- `$systemSetting`: Configurações da loja do usuário
- `$categories`: Categorias de serviços
- `$services`: Serviços disponíveis
- `$user`: Usuário dono da loja
- `$theme`: Configurações do tema ativo

## Suporte

Se tiver dúvidas, consulte os temas existentes (Zinc, Turbina, Modern) como referência.
