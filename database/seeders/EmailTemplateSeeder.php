<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criar templates para todos os usuários existentes
        $users = User::all();

        foreach ($users as $user) {
            // Verificar se já tem templates
            if ($user->emailTemplates()->count() === 0) {
                $this->createDefaultTemplates($user);
            }
        }
    }

    private function createDefaultTemplates(User $user)
    {
        $templates = [
            [
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
            [
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
            [
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
            [
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

        foreach ($templates as $template) {
            $template['user_id'] = $user->id;
            $template['available_variables'] = json_encode(
                EmailTemplate::getAvailableVariables($template['type'])
            );

            EmailTemplate::create($template);
        }
    }
}
