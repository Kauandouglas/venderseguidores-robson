<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'subject',
        'body',
        'is_active',
        'available_variables'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'available_variables' => 'json'
    ];

    // Tipos disponíveis
    const TYPE_PURCHASE = 'purchase';
    const TYPE_PIX_GENERATED = 'pix_generated';
    const TYPE_PAYMENT_REMINDER = 'payment_reminder';
    const TYPE_ORDER_COMPLETED = 'order_completed';

    // Variáveis disponíveis para cada tipo de email
    public static function getAvailableVariables($type = null)
    {
        $allVariables = [
            'purchase' => [
                'cliente_nome' => 'Nome do cliente',
                'cliente_email' => 'Email do cliente',
                'servico_nome' => 'Nome do serviço',
                'servico_quantidade' => 'Quantidade',
                'valor_total' => 'Valor total',
                'data_compra' => 'Data da compra',
                'link_pedido' => 'Link do pedido'
            ],
            'pix_generated' => [
                'cliente_nome' => 'Nome do cliente',
                'cliente_email' => 'Email do cliente',
                'servico_nome' => 'Nome do serviço',
                'valor_pix' => 'Valor do PIX',
                'pix_qr_code' => 'QR Code do PIX',
                'pix_codigo' => 'Código PIX (Copia e Cola)',
                'data_expiracao' => 'Data de expiração do PIX'
            ],
            'payment_reminder' => [
                'cliente_nome' => 'Nome do cliente',
                'cliente_email' => 'Email do cliente',
                'servico_nome' => 'Nome do serviço',
                'valor_pendente' => 'Valor pendente',
                'dias_pendente' => 'Dias desde a compra',
                'link_pagamento' => 'Link para completar pagamento'
            ],
            'order_completed' => [
                'cliente_nome' => 'Nome do cliente',
                'cliente_email' => 'Email do cliente',
                'servico_nome' => 'Nome do serviço',
                'servico_quantidade' => 'Quantidade entregue',
                'valor_total' => 'Valor total',
                'data_conclusao' => 'Data de conclusão',
                'link_pedido' => 'Link do pedido'
            ]
        ];

        if ($type) {
            return $allVariables[$type] ?? [];
        }

        return $allVariables;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Substituir variáveis no corpo do email
    public function replaceVariables($variables = [])
    {
        $body = $this->body;
        $subject = $this->subject;

        foreach ($variables as $key => $value) {
            $body = str_replace('{{' . $key . '}}', $value, $body);
            $subject = str_replace('{{' . $key . '}}', $value, $subject);
        }

        return [
            'subject' => $subject,
            'body' => $body
        ];
    }
}
