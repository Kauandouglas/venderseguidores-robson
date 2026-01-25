@component('mail::message')
# Pedido Concluído! 🎉

Olá **{{ $cliente_nome }}**,

Temos o prazer de informar que seu pedido foi **concluído com sucesso**!

---

## ✅ Detalhes da Entrega

| Descrição | Informação |
|:----------|:-----------|
| **Serviço** | {{ $servico_nome }} |
| **Quantidade** | {{ $servico_quantidade }} |
| **Valor Total** | {{ $valor_total }} |
| **Data de Conclusão** | {{ $data_conclusao }} |

---

@component('mail::button', ['url' => $link_pedido, 'color' => 'success'])
Ver Detalhes do Pedido
@endcomponent

---

Esperamos que tenha gostado do nosso serviço! 

⭐ **Sua opinião é muito importante para nós!**

Obrigado pela confiança! Volte sempre! 💚

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
