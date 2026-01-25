<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AutomaticEmailService
{
    /**
     * Enviar email quando cliente comprou
     */
    public static function sendPurchaseEmail(User $user, $purchaseData)
    {
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
                return false;
            }

            // Substituir variáveis
            $content = $template->replaceVariables($variables);

            // Enviar email
            Mail::send([], [], function ($mail) use ($variables, $content) {
                $mail->from(config('mail.from.address'), config('mail.from.name'))
                    ->to($variables['cliente_email'])
                    ->subject($content['subject'])
                    ->setBody($content['body'], 'text/html');
            });

            return true;
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email automático: ' . $e->getMessage());
            return false;
        }
    }
}
