<?php

namespace App\Console\Commands;

use App\Models\PlanPurchase;
use Illuminate\Console\Command;

class CancelPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $planPurchases = PlanPurchase::with('user')->where('next_cancel_at', '<', now())
            ->where('status', 'Approved')->get();
        foreach ($planPurchases as $planPurchase){
            $planPurchase->status = 'Canceled';
            $planPurchase->update();

            $whatsapp = new \App\Support\Whatsapp();
            $whatsapp->sendMessage($planPurchase->user->phone, "Olá, {$planPurchase->user->name}.

Informamos que o seu plano foi cancelado devido à falta de pagamento. Caso tenha alguma dúvida, por favor, entre em contato conosco.

*Caso queira reativar o serviço acesse o link a seguir: https://lojadoinsta.com.br/painel/planos*

Obrigado!");

        }
    }
}
