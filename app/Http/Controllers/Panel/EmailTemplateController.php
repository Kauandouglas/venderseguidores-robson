<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = Auth::user()->emailTemplates()->get();
        
        // Criar templates padrão se não existirem
        $types = [
            'purchase',
            'pix_generated',
            'payment_reminder',
            'order_completed'
        ];

        foreach ($types as $type) {
            if (!Auth::user()->emailTemplates()->where('type', $type)->exists()) {
                $defaultTemplates = self::getDefaultTemplates();
                Auth::user()->emailTemplates()->create($defaultTemplates[$type]);
            }
        }

        $templates = Auth::user()->emailTemplates()->orderBy('type')->get();

        return view('panel.emailTemplates.index', [
            'templates' => $templates
        ]);
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        // Verificar se pertence ao usuário autenticado
        if ($emailTemplate->user_id !== Auth::id()) {
            abort(403);
        }

        $availableVariables = EmailTemplate::getAvailableVariables($emailTemplate->type);

        return view('panel.emailTemplates.edit', [
            'template' => $emailTemplate,
            'availableVariables' => $availableVariables,
            'typeLabel' => $this->getTypeLabel($emailTemplate->type)
        ]);
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        // Verificar se pertence ao usuário autenticado
        if ($emailTemplate->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'subject' => 'required|max:255',
            'body' => 'required',
            'is_active' => 'boolean'
        ]);

        $emailTemplate->update([
            'subject' => $request->subject,
            'body' => $request->body,
            'is_active' => $request->boolean('is_active'),
            'available_variables' => json_encode(
                EmailTemplate::getAvailableVariables($emailTemplate->type)
            )
        ]);

        return response()->json('Email template atualizado com sucesso!');
    }

    public function toggleActive(EmailTemplate $emailTemplate)
    {
        // Verificar se pertence ao usuário autenticado
        if ($emailTemplate->user_id !== Auth::id()) {
            abort(403);
        }

        $emailTemplate->update([
            'is_active' => !$emailTemplate->is_active
        ]);

        return response()->json([
            'is_active' => $emailTemplate->is_active,
            'message' => 'Status alterado com sucesso!'
        ]);
    }

    private function getTypeLabel($type)
    {
        $labels = [
            'purchase' => '📦 Cliente Comprou',
            'pix_generated' => '💳 PIX Gerado',
            'payment_reminder' => '⏰ Lembrete de Pagamento',
            'order_completed' => '✅ Pedido Concluído'
        ];

        return $labels[$type] ?? $type;
    }

    private static function getDefaultTemplates()
    {
        return [
            'purchase' => [
                'type' => 'purchase',
                'subject' => 'Obrigado pela sua compra!',
                'body' => <<<'EOF'
Olá {{cliente_nome}},

Obrigado por comprar em nossa plataforma! 🎉

Você comprou:
- Serviço: {{servico_nome}}
- Quantidade: {{servico_quantidade}}
- Valor Total: {{valor_total}}

Sua compra foi registrada em: {{data_compra}}

Próximo passo: Aguarde o email com instruções de pagamento.

Qualquer dúvida, estamos à sua disposição!

Atenciosamente,
Nossa Equipe
EOF,
                'is_active' => true
            ],
            'pix_generated' => [
                'type' => 'pix_generated',
                'subject' => 'Seu PIX está pronto!',
                'body' => <<<'EOF'
Olá {{cliente_nome}},

Seu PIX foi gerado com sucesso! 💳

Serviço: {{servico_nome}}
Valor: {{valor_pix}}

Escaneie o QR Code abaixo ou copie e cole o código PIX:
{{pix_codigo}}

Expira em: {{data_expiracao}}

Após o pagamento, seus serviços serão processados automaticamente.

Dúvidas? Entre em contato conosco!

Atenciosamente,
Nossa Equipe
EOF,
                'is_active' => true
            ],
            'payment_reminder' => [
                'type' => 'payment_reminder',
                'subject' => 'Sua compra está aguardando pagamento',
                'body' => <<<'EOF'
Olá {{cliente_nome}},

Notamos que sua compra ainda não foi paga. ⏰

Serviço: {{servico_nome}}
Valor Pendente: {{valor_pendente}}
Dias desde a compra: {{dias_pendente}}

Clique no link abaixo para completar o pagamento:
{{link_pagamento}}

Se você já pagou, ignore este email. O processamento pode levar alguns minutos.

Obrigado!

Atenciosamente,
Nossa Equipe
EOF,
                'is_active' => true
            ],
            'order_completed' => [
                'type' => 'order_completed',
                'subject' => 'Seu pedido foi concluído! ✅',
                'body' => <<<'EOF'
Olá {{cliente_nome}},

Excelente notícia! Seu pedido foi concluído com sucesso! 🎉

Detalhes do Pedido:
- Serviço: {{servico_nome}}
- Quantidade Entregue: {{servico_quantidade}}
- Valor Total: {{valor_total}}
- Data de Conclusão: {{data_conclusao}}

Você pode acompanhar seu pedido aqui: {{link_pedido}}

Obrigado por escolher nossos serviços! 

Atenciosamente,
Nossa Equipe
EOF,
                'is_active' => true
            ]
        ];
    }
}
