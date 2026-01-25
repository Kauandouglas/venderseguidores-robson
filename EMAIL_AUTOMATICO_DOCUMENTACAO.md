# Sistema de Email Automático - Documentação Implementada

## 📧 Visão Geral

Foi implementado um **sistema completo de emails automáticos** que permite aos administradores da loja configurar e personalizar 4 tipos de emails disparados automaticamente:

1. **📦 Email de Compra Realizada** - Enviado quando cliente realiza uma compra
2. **💳 Email de PIX Gerado** - Enviado quando PIX é gerado para pagamento
3. **⏰ Email de Lembrete de Pagamento** - Enviado para pedidos pendentes após 1 hora
4. **✅ Email de Pedido Concluído** - Enviado quando o pedido é processado com sucesso

---

## 🔧 Estrutura Técnica Implementada

### 1. **Banco de Dados**

#### Migration: `create_email_templates_table`
```php
Colunas:
- id (Primary Key)
- user_id (Foreign Key → users)
- type (Enum: purchase, pix_generated, payment_reminder, order_completed)
- subject (String - Assunto do email)
- body (Text - Corpo do email)
- is_active (Boolean - Ativo/Inativo)
- available_variables (JSON - Variáveis disponíveis para este tipo)
- timestamps
```

#### Migration: `add_reminder_sent_and_payment_status_to_purchases_table`
```php
Novas colunas em 'purchases':
- reminder_sent (Boolean) - Rastreia se lembrete foi enviado
- payment_status (String) - Status do pagamento (pending, approved, failed)
```

---

### 2. **Modelos (Models)**

#### `app/Models/EmailTemplate.php`
- **Constantes de Tipo**: TYPE_PURCHASE, TYPE_PIX_GENERATED, TYPE_PAYMENT_REMINDER, TYPE_ORDER_COMPLETED
- **Método**: `getAvailableVariables($type)` - Retorna variáveis disponíveis para cada tipo
- **Método**: `replaceVariables($variables)` - Substitui {{variável}} no subject e body
- **Relacionamento**: `belongsTo(User::class)` - Um template por usuário

#### `app/Models/User.php` (Modificado)
- **Novo Relacionamento**: `emailTemplates()` - hasMany(EmailTemplate::class)

---

### 3. **Serviço de Email**

#### `app/Services/AutomaticEmailService.php`

**Métodos Públicos (Estáticos):**
1. `sendPurchaseEmail(User $user, array $data)`
2. `sendPixGeneratedEmail(User $user, array $data)`
3. `sendPaymentReminderEmail(User $user, array $data)`
4. `sendOrderCompletedEmail(User $user, array $data)`

**Método Privado:**
- `sendEmail(User $user, string $type, array $variables)` - Lógica centralizada

**Variáveis Disponíveis por Tipo:**
```
PURCHASE:
- {{cliente_nome}}, {{cliente_email}}, {{servico_nome}}
- {{servico_quantidade}}, {{valor_total}}, {{data_compra}}
- {{link_pedido}}

PIX_GENERATED:
- {{cliente_nome}}, {{cliente_email}}, {{servico_nome}}
- {{valor_pix}}, {{pix_qr_code}}, {{pix_codigo}}
- {{data_expiracao}}

PAYMENT_REMINDER:
- {{cliente_nome}}, {{cliente_email}}, {{servico_nome}}
- {{valor_pendente}}, {{numero_pedido}}, {{link_pagamento}}
- {{tempo_expiracao}}

ORDER_COMPLETED:
- {{cliente_nome}}, {{cliente_email}}, {{servico_nome}}
- {{numero_pedido}}, {{valor_total}}, {{data_conclusao}}
```

---

### 4. **Controller de Painel**

#### `app/Http/Controllers/Panel/EmailTemplateController.php`

**Endpoints:**
- `GET /painel/email-templates` → `index()` - Lista templates
- `GET /painel/email-templates/{id}/editar` → `edit()` - Formulário de edição
- `PUT /painel/email-templates/{id}` → `update()` - Salva alterações
- `POST /painel/email-templates/{id}/toggle-active` → `toggleActive()` - AJAX para ativar/desativar

**Funcionalidades:**
- Criação automática de templates padrão na primeira visualização
- Validação de subject e body
- Resposta JSON para toggle AJAX

---

### 5. **Views do Painel**

#### `resources/views/panel/emailTemplates/index.blade.php`
- Tabela listando 4 tipos de email
- Ícones emoji para cada tipo
- Toggle switch para ativar/desativar
- Link "Editar" para cada template
- Cores visuais diferentes por tipo

#### `resources/views/panel/emailTemplates/edit.blade.php`
- Input para subject (com dica de variáveis)
- Textarea para body com altura de 65px
- Checkbox para ativar/desativar
- **Barra lateral com variáveis clicáveis** - Copy-paste automático
- Validação em tempo real
- Breadcrumb de navegação

---

### 6. **Seeders**

#### `database/seeders/EmailTemplateSeeder.php`
- Cria 4 templates padrão para cada usuário
- Conteúdo em português com variáveis pré-preenchidas
- `is_active = true` por padrão
- Armazena `available_variables` em JSON

---

### 7. **Comando Agendado (Scheduler)**

#### `app/Console/Commands/SendPaymentReminder.php`

**Comando:** `php artisan send:payment-reminder`

**Funcionalidade:**
- Procura pedidos pendentes há mais de 1 hora
- Envia email de lembrete de pagamento
- Marca `reminder_sent = true` para não reenviar

**Agendamento (adicionar em `app/Console/Kernel.php`):**
```php
$schedule->command('send:payment-reminder')
    ->everyFifteenMinutes()
    ->onSuccess(...)
    ->onFailure(...);
```

---

## 📍 Integrações Implementadas

### 1. **PurchaseController (API) - Email de Compra + PIX**

**Locais de Integração:**

#### A. Quando PIX é gerado (pix_direct)
```php
// Linha ~95
AutomaticEmailService::sendPixGeneratedEmail($user, [...]);
```

#### B. Quando PIX é gerado (carrinho)
```php
// Linha ~257
AutomaticEmailService::sendPixGeneratedEmail($user, [...]);
```

#### C. Quando pagamento é aprovado (MercadoPago)
```php
// Linha ~330
AutomaticEmailService::sendPurchaseEmail($user, [...]);
```

#### D. Quando pagamento é aprovado (PushinPay)
```php
// Linha ~378
AutomaticEmailService::sendPurchaseEmail($user, [...]);
```

---

### 2. **PurchaseService - Email de Pedido Concluído**

**Local de Integração:**

```php
// Método sendOrder() - Linha ~23
AutomaticEmailService::sendOrderCompletedEmail($user, [...]);
```

**Quando:** Após pedido ser confirmado na SMM (quando `order_id` é recebido)

---

### 3. **Menu do Painel**

**Arquivo:** `resources/views/panel/includes/header.blade.php`

**Localização:** Configurações > Email Automático

```html
<li>
    <a href="{{ route('panel.emailTemplates.index') }}">Email Automático</a>
</li>
```

---

## 🚀 Como Usar

### 1. **Executar Migrações**
```bash
php artisan migrate --force
```

### 2. **Executar Seeder**
```bash
php artisan db:seed --class=EmailTemplateSeeder
```

### 3. **Acessar Painel**
- Ir para: **Painel > Configurações > Email Automático**
- Clicar em "Editar" para cada tipo de email

### 4. **Personalizar Emails**
- Modificar o **Assunto** (subject)
- Modificar o **Corpo** (body)
- Clicar em variáveis na barra lateral para auto-completar
- Salvar alterações

### 5. **Ativar/Desativar Emails**
- Usar o toggle switch na lista para ativar/desativar cada tipo
- Alterações aplicadas imediatamente

### 6. **Agendar Lembrete de Pagamento (Opcional)**
- Adicionar em `app/Console/Kernel.php`:
```php
$schedule->command('send:payment-reminder')->everyFifteenMinutes();
```

---

## 📊 Fluxo de Dados

```
1. COMPRA REALIZADA
   ├─ PurchaseController::store() cria Purchase
   └─ PIX Gerado
      └─ sendPixGeneratedEmail() [Email 1]

2. PAGAMENTO APROVADO
   ├─ notificationTemplate() recebe webhook
   ├─ sendPurchaseEmail() [Email 2]
   └─ PurchaseService::sendOrder()
      └─ sendOrderCompletedEmail() [Email 4]

3. LEMBRETE DE PAGAMENTO (Agendado)
   └─ SendPaymentReminder::handle()
      └─ sendPaymentReminderEmail() [Email 3]
```

---

## 🔐 Segurança

- ✅ Proteção CSRF em formulários
- ✅ Validação de entrada em campos
- ✅ Middleware `role:2` para admin apenas
- ✅ Verificação de propriedade do template (user_id)
- ✅ Logging de erros de email

---

## 📝 Variáveis Dinâmicas

Dentro de qualquer email, use a sintaxe:
```
Olá {{cliente_nome}},

Seu pedido do serviço {{servico_nome}} foi concluído!
Valor total: {{valor_total}}

Acompanhe em: {{link_pedido}}
```

As variáveis serão substituídas automaticamente antes do envio.

---

## 🔗 Arquivos Modificados/Criados

### Criados:
- ✅ `app/Models/EmailTemplate.php`
- ✅ `app/Http/Controllers/Panel/EmailTemplateController.php`
- ✅ `app/Services/AutomaticEmailService.php`
- ✅ `app/Console/Commands/SendPaymentReminder.php`
- ✅ `database/migrations/2026_01_25_120000_create_email_templates_table.php`
- ✅ `database/migrations/2026_01_25_130000_add_reminder_sent_and_payment_status_to_purchases_table.php`
- ✅ `database/seeders/EmailTemplateSeeder.php`
- ✅ `resources/views/panel/emailTemplates/index.blade.php`
- ✅ `resources/views/panel/emailTemplates/edit.blade.php`

### Modificados:
- ✅ `routes/web.php` - 4 novas rotas
- ✅ `app/Models/User.php` - Relacionamento emailTemplates()
- ✅ `app/Http/Controllers/Api/PurchaseController.php` - 4 chamadas de email
- ✅ `app/Services/Web/PurchaseService.php` - 1 chamada de email
- ✅ `resources/views/panel/includes/header.blade.php` - Menu link

---

## ✨ Features

- [x] Customização completa de 4 tipos de emails
- [x] Ativar/desativar emails individualmente
- [x] Variáveis dinâmicas em subject e body
- [x] Interface intuitiva no painel
- [x] Auto-substituição de variáveis
- [x] Email de compra na aprovação do pagamento
- [x] Email de PIX quando código é gerado
- [x] Email de pedido concluído após processamento
- [x] Comando para lembrete de pagamento
- [x] Suporte a MercadoPago e PushinPay
- [x] Logging de erros
- [x] Validação de dados

---

## 🐛 Próximas Melhorias (Opcional)

- [ ] Histórico de emails enviados
- [ ] Preview de email antes de salvar
- [ ] Testes A/B de assunto
- [ ] Rastreamento de abertura
- [ ] Template HTML avançado
- [ ] Agendamento de envio
- [ ] Suporte a anexos
