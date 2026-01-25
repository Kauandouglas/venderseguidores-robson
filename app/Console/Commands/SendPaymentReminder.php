<?php

namespace App\Console\Commands;

use App\Models\Purchase;
use App\Services\AutomaticEmailService;
use Illuminate\Console\Command;

class SendPaymentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:payment-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar lembretes de pagamento para pedidos pendentes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Procura por pedidos pendentes criados há mais de 1 hora
        $purchases = Purchase::where('payment_status', 'pending')
            ->where('created_at', '<', now()->subHours(1))
            ->where('reminder_sent', false)
            ->with('user', 'service')
            ->get();

        foreach ($purchases as $purchase) {
            try {
                // Envia email de lembrete de pagamento
                AutomaticEmailService::sendPaymentReminderEmail($purchase->user, [
                    'cliente_nome' => $purchase->name,
                    'cliente_email' => $purchase->email,
                    'servico_nome' => $purchase->service->name,
                    'valor_pendente' => 'R$ ' . number_format($purchase->price, 2, ',', '.'),
                    'numero_pedido' => $purchase->id,
                    'link_pagamento' => route('web.systemSettings.template', ['domain' => $purchase->user->domain]),
                    'tempo_expiracao' => '24 horas'
                ]);

                // Marca como lembrete enviado
                $purchase->reminder_sent = true;
                $purchase->save();

                $this->info("Lembrete de pagamento enviado para pedido #{$purchase->id} (Cliente: {$purchase->name})");
            } catch (\Exception $e) {
                $this->error("Erro ao enviar lembrete para pedido #{$purchase->id}: {$e->getMessage()}");
            }
        }

        $this->info('Comando concluído com sucesso!');
        return 0;
    }
}
