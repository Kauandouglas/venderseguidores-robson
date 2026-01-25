@component('mail::message')
# Compra Confirmada! ✅

Olá **{{ $cliente_nome }}**,

Ótima notícia! Seu pagamento foi confirmado e seu pedido já está sendo processado.

---

## 📦 Detalhes do Pedido

| Descrição | Informação |
|:----------|:-----------|
| **Serviço** | {{ $servico_nome }} |
| **Quantidade** | {{ $servico_quantidade }} |
| **Valor Total** | {{ $valor_total }} |
| **Data da Compra** | {{ $data_compra }} |

---

@component('mail::button', ['url' => $link_pedido, 'color' => 'primary'])
Acompanhar Pedido
@endcomponent

Caso tenha dúvidas, entre em contato conosco.

Obrigado por comprar conosco! 🚀

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
