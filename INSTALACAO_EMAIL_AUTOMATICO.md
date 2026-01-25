# 🚀 Guia de Instalação Rápida - Sistema de Email Automático

## Passos para Colocar em Produção

### 1️⃣ **Executar Migrações**
```bash
php artisan migrate --force
```

Isso irá:
- ✅ Criar tabela `email_templates`
- ✅ Adicionar colunas em `purchases` (reminder_sent, payment_status)

### 2️⃣ **Executar Seeder (Opcional)**
```bash
php artisan db:seed --class=EmailTemplateSeeder
```

Isso irá:
- ✅ Criar 4 templates padrão para cada usuário existente
- ✅ Pré-popular com conteúdo em português

**Nota:** Se não executar o seeder, os templates serão criados automaticamente na primeira visualização do painel.

### 3️⃣ **Acessar o Painel**
1. Acesse: `https://seu-dominio.com/painel`
2. Vá para: **Configurações > Email Automático**
3. Clique em **Editar** para cada tipo de email
4. Customize o assunto e corpo conforme desejado

### 4️⃣ **Ativar Lembrete de Pagamento (Opcional)**

Se você deseja que lembretes de pagamento sejam enviados automaticamente:

Edite o arquivo: `app/Console/Kernel.php`

Adicione dentro do método `schedule()`:
```php
$schedule->command('send:payment-reminder')->everyFifteenMinutes();
```

Exemplo completo:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('send:payment-reminder')->everyFifteenMinutes();
    // ... outros comandos
}
```

### 5️⃣ **Configurar Envio de Emails**

Certifique-se que o `.env` tem as configurações corretas:
```env
MAIL_MAILER=smtp
MAIL_HOST=seu-servidor-smtp.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@dominio.com
MAIL_PASSWORD=sua-senha
MAIL_FROM_ADDRESS=seu-email@dominio.com
MAIL_FROM_NAME="Sua Loja"
MAIL_ENCRYPTION=tls
```

---

## 📧 Tipos de Emails Implementados

| Tipo | Quando é Enviado | Acionador |
|------|-----------------|-----------|
| 📦 **Compra** | Quando pagamento é aprovado | Webhook de pagamento |
| 💳 **PIX** | Quando PIX é gerado | API PurchaseController |
| ⏰ **Lembrete** | 1 hora após pedido (se pendente) | Comando agendado |
| ✅ **Concluído** | Quando pedido é processado | PurchaseService |

---

## 🎨 Personalizando Emails

### Variáveis Disponíveis

Cada tipo de email tem variáveis específicas. Use a sintaxe `{{variavel}}`:

**Todos os tipos:**
- `{{cliente_nome}}` - Nome do cliente
- `{{cliente_email}}` - Email do cliente
- `{{servico_nome}}` - Nome do serviço

**Email de Compra:**
- `{{valor_total}}` - Valor total formatado
- `{{data_compra}}` - Data e hora da compra
- `{{link_pedido}}` - Link para acompanhar pedido

**Email de PIX:**
- `{{valor_pix}}` - Valor do PIX
- `{{pix_codigo}}` - Código PIX copia e cola
- `{{data_expiracao}}` - Quando PIX expira

**Email de Lembrete:**
- `{{valor_pendente}}` - Valor a pagar
- `{{numero_pedido}}` - ID do pedido
- `{{link_pagamento}}` - Link para pagar

**Email de Concluído:**
- `{{numero_pedido}}` - ID do pedido
- `{{data_conclusao}}` - Quando foi concluído

---

## ⚙️ Configurações Avançadas

### Desabilitar Email Específico

Se você deseja desabilitar um tipo de email:
1. Vá para: **Painel > Configurações > Email Automático**
2. Clique no toggle para desativar

### Usar Template HTML

Se deseja usar HTML no corpo do email, você pode:
```html
<p>Olá <strong>{{cliente_nome}}</strong>,</p>

<p>Seu pedido foi recebido!</p>

<p>
    <a href="{{link_pedido}}" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none;">
        Acompanhar Pedido
    </a>
</p>

<p>Obrigado!</p>
```

---

## 🔍 Testando

### Teste 1: Validar Tabelas
```sql
-- No seu banco de dados MySQL
SELECT * FROM email_templates;
SELECT reminder_sent, payment_status FROM purchases LIMIT 1;
```

### Teste 2: Enviar Email Manual
```php
// No tinker
php artisan tinker
>>> $user = App\Models\User::first();
>>> App\Services\AutomaticEmailService::sendPurchaseEmail($user, ['customer_name' => 'João', 'customer_email' => 'joao@email.com', 'service_name' => 'Serviço Teste', 'quantity' => 1, 'total_value' => 100, 'order_link' => 'http://seu-site.com']);
```

### Teste 3: Verificar Log
```bash
tail -f storage/logs/laravel.log
```

---

## 🐛 Troubleshooting

### Erro: "Table not found"
```bash
php artisan migrate --force
```

### Emails não são enviados
1. Verifique `.env` - SMTP configurado?
2. Verifique `storage/logs/laravel.log`
3. Confirme `is_active = 1` no painel

### Variáveis não substituídas
1. Use exatamente: `{{variavel_nome}}`
2. Verifique nomes corretos na barra lateral do editor
3. Salve e teste novamente

### Lembrete não é enviado
1. Comando agendado? Adicione ao `Kernel.php`
2. Cron está rodando? `crontab -l`
3. Verifique: `ps aux | grep cron`

---

## 📞 Suporte

Para dúvidas:
1. Verifique `EMAIL_AUTOMATICO_DOCUMENTACAO.md`
2. Analise logs: `storage/logs/laravel.log`
3. Teste no tinker: `php artisan tinker`

---

## ✅ Checklist de Instalação

- [ ] Rodou migração: `php artisan migrate --force`
- [ ] Rodou seeder: `php artisan db:seed --class=EmailTemplateSeeder`
- [ ] Acesso painel: `Configurações > Email Automático`
- [ ] Customizou emails no painel
- [ ] Testou envio de email manual
- [ ] Configurou SMTP no `.env`
- [ ] (Opcional) Adicionou comando agendado em `Kernel.php`
- [ ] Verificou `storage/logs/laravel.log` para erros

**Pronto para produção! 🎉**
