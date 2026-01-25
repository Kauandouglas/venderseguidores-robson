@component('mail::message')
# {{ $cliente_nome }}, seu PIX está pronto! 🎉

Recebemos seu pedido e o código PIX já está disponível para pagamento.

**Detalhes do Pedido:**

| Item | Valor |
|:-----|------:|
| {{ $servico_nome }} | {{ $valor_pix }} |

---

## 📱 Código PIX (Copia e Cola)

```
{{ $pix_codigo }}
```

@component('mail::button', ['url' => '#', 'color' => 'success'])
Copiar Código PIX
@endcomponent

---

⏰ **Atenção:** Este código expira em **{{ $data_expiracao }}**

Após o pagamento, seu pedido será processado automaticamente.

Obrigado pela preferência! 💚

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
