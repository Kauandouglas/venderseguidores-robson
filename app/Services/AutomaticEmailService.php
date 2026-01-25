<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AutomaticEmailService
{
    /**
     * Enviar email quando cliente comprou
     */
    public static function sendPurchaseEmail(User $user, $purchaseData)
    {
        Log::info('[EMAIL-AUTO] Iniciando envio de email COMPRA', [
            'user_id' => $user->id,
            'cliente_email' => $purchaseData['customer_email'] ?? 'N/A',
            'servico' => $purchaseData['service_name'] ?? 'N/A'
        ]);

        return self::sendEmail($user, EmailTemplate::TYPE_PURCHASE, [
            'cliente_nome' => $purchaseData['customer_name'] ?? 'Cliente',
            'cliente_email' => $purchaseData['customer_email'] ?? '',
            'servico_nome' => $purchaseData['service_name'] ?? '',
            'servico_quantidade' => $purchaseData['quantity'] ?? 0,
            'valor_total' => 'R$ ' . number_format($purchaseData['total_value'] ?? 0, 2, ',', '.'),
            'data_compra' => date('d/m/Y H:i'),
            'link_pedido' => $purchaseData['order_link'] ?? '#'
        ]);
    }

    /**
     * Enviar email quando PIX foi gerado
     */
    public static function sendPixGeneratedEmail(User $user, $pixData)
    {
        Log::info('[EMAIL-AUTO] Iniciando envio de email PIX GERADO', [
            'user_id' => $user->id,
            'cliente_email' => $pixData['customer_email'] ?? 'N/A',
            'valor' => $pixData['value'] ?? 0
        ]);

        return self::sendEmail($user, EmailTemplate::TYPE_PIX_GENERATED, [
            'cliente_nome' => $pixData['customer_name'] ?? 'Cliente',
            'cliente_email' => $pixData['customer_email'] ?? '',
            'servico_nome' => $pixData['service_name'] ?? '',
            'valor_pix' => 'R$ ' . number_format($pixData['value'] ?? 0, 2, ',', '.'),
            'pix_qr_code' => $pixData['qr_code_base64'] ?? '',
            'pix_codigo' => $pixData['qr_code'] ?? '',
            'data_expiracao' => $pixData['expiration_date'] ?? ''
        ]);
    }

    /**
     * Enviar email de lembrete de pagamento
     */
    public static function sendPaymentReminderEmail(User $user, $reminderData)
    {
        Log::info('[EMAIL-AUTO] Iniciando envio de email LEMBRETE', [
            'user_id' => $user->id,
            'cliente_email' => $reminderData['customer_email'] ?? 'N/A',
            'dias_pendente' => $reminderData['days_pending'] ?? 0
        ]);

        return self::sendEmail($user, EmailTemplate::TYPE_PAYMENT_REMINDER, [
            'cliente_nome' => $reminderData['customer_name'] ?? 'Cliente',
            'cliente_email' => $reminderData['customer_email'] ?? '',
            'servico_nome' => $reminderData['service_name'] ?? '',
            'valor_pendente' => 'R$ ' . number_format($reminderData['pending_value'] ?? 0, 2, ',', '.'),
            'dias_pendente' => $reminderData['days_pending'] ?? 0,
            'link_pagamento' => $reminderData['payment_link'] ?? '#'
        ]);
    }

    /**
     * Enviar email quando pedido foi concluído
     */
    public static function sendOrderCompletedEmail(User $user, $completionData)
    {
        Log::info('[EMAIL-AUTO] Iniciando envio de email PEDIDO CONCLUIDO', [
            'user_id' => $user->id,
            'cliente_email' => $completionData['customer_email'] ?? 'N/A',
            'servico' => $completionData['service_name'] ?? 'N/A'
        ]);

        return self::sendEmail($user, EmailTemplate::TYPE_ORDER_COMPLETED, [
            'cliente_nome' => $completionData['customer_name'] ?? 'Cliente',
            'cliente_email' => $completionData['customer_email'] ?? '',
            'servico_nome' => $completionData['service_name'] ?? '',
            'servico_quantidade' => $completionData['quantity'] ?? 0,
            'valor_total' => 'R$ ' . number_format($completionData['total_value'] ?? 0, 2, ',', '.'),
            'data_conclusao' => date('d/m/Y H:i'),
            'link_pedido' => $completionData['order_link'] ?? '#'
        ]);
    }

    /**
     * Mapeamento de tipo para view de email
     */
    private static $emailViews = [
        EmailTemplate::TYPE_PURCHASE => 'emails.automatic.purchase',
        EmailTemplate::TYPE_PIX_GENERATED => 'emails.automatic.pix-generated',
        EmailTemplate::TYPE_PAYMENT_REMINDER => 'emails.automatic.payment-reminder',
        EmailTemplate::TYPE_ORDER_COMPLETED => 'emails.automatic.order-completed',
    ];

    /**
     * Método genérico para enviar email
     */
    private static function sendEmail(User $user, $templateType, $variables)
    {
        try {
            // Obter o template do usuário
            $template = $user->emailTemplates()
                ->where('type', $templateType)
                ->where('is_active', true)
                ->first();

            // Se não existir template ou estiver inativo, pular
            if (!$template) {
                Log::warning('[EMAIL-AUTO] Template não encontrado ou inativo', [
                    'user_id' => $user->id,
                    'template_type' => $templateType
                ]);
                return false;
            }

            // Verificar email do cliente
            if (empty($variables['cliente_email'])) {
                Log::warning('[EMAIL-AUTO] Email do cliente vazio - cancelando envio', [
                    'user_id' => $user->id,
                    'template_type' => $templateType
                ]);
                return false;
            }

            // Substituir variáveis no assunto
            $subject = $template->subject;
            foreach ($variables as $key => $value) {
                $subject = str_replace('{{ ' . $key . ' }}', $value, $subject);
            }

            Log::info('[EMAIL-AUTO] Enviando email...', [
                'user_id' => $user->id,
                'template_type' => $templateType,
                'para' => $variables['cliente_email'],
                'assunto' => $subject
            ]);

            // Obter a view correspondente
            $viewName = self::$emailViews[$templateType] ?? null;

            if ($viewName) {
                // Enviar usando template Markdown bonito
                Mail::send($viewName, $variables, function ($mail) use ($variables, $subject) {
                    $mail->from(config('mail.from.address'), config('mail.from.name'))
                        ->to($variables['cliente_email'])
                        ->subject($subject);
                });
            } else {
                // Fallback: usar corpo do template customizado
                $content = $template->replaceVariables($variables);
                Mail::send([], [], function ($mail) use ($variables, $content) {
                    $mail->from(config('mail.from.address'), config('mail.from.name'))
                        ->to($variables['cliente_email'])
                        ->subject($content['subject'])
                        ->setBody($content['body'], 'text/html');
                });
            }

            Log::info('[EMAIL-AUTO] ✅ EMAIL ENVIADO COM SUCESSO!', [
                'user_id' => $user->id,
                'template_type' => $templateType,
                'para' => $variables['cliente_email']
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('[EMAIL-AUTO] ❌ ERRO AO ENVIAR EMAIL', [
                'user_id' => $user->id,
                'template_type' => $templateType ?? 'N/A',
                'para' => $variables['cliente_email'] ?? 'N/A',
                'erro' => $e->getMessage(),
                'arquivo' => $e->getFile(),
                'linha' => $e->getLine()
            ]);
            return false;
        }
    }
}
