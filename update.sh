#!/bin/bash
cd ../

# Realiza o stash de quaisquer mudanças locais
git stash

# Atualiza o repositório com as alterações remotas
git pull

# Atualiza as dependências do Composer
composer update -o

# Executa as migrações do banco de dados
php artisan migrate --force

# Otimiza a aplicação Laravel
php artisan optimize
