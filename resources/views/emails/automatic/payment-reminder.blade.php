@component('mail::message')
# Opa, {{ $cliente_nome }}! Esqueceu de algo? 🤔

Notamos que você tem um pagamento pendente há **{{ $dias_pendente }} dia(s)**.

---

## 📋 Resumo do Pedido

| Item | Valor |
|:-----|------:|
| {{ $servico_nome }} | {{ $valor_pendente }} |

---

Não perca seu pedido! Complete o pagamento agora e garanta seu serviço.

@component('mail::button', ['url' => $link_pagamento, 'color' => 'success'])
💳 Pagar Agora
@endcomponent

---

**Precisa de ajuda?** Responda este email que teremos prazer em ajudar.

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
