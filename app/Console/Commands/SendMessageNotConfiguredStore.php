<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SendMessageNotConfiguredStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendMessagee:notConfiguredStore';

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
        $uniqueToken = 'not_configured_store';
        $users = User::users()->latest('id')->whereDoesntHave('userNotifies', function ($query) use ($uniqueToken) {
            $query->where('unique_token', $uniqueToken);
        })->whereDoesntHave('planPurchase', function ($query) {
            $query->where('status', 'Approved');
        })->whereDoesntHave('apiProviders', function ($query) {
            $query->whereNotNull('key');
        })->where('id', '>', 2195)->where('created_at', '<=', now()->addDays(-2))->get();

        foreach ($users as $user) {
            $user->userNotifies()->create([
                'type' => 'all',
                'unique_token' => $uniqueToken,
                'subject' => 'Sua loja não foi configurada',
                'message' => "Olá, *$user->name*, tudo bem?

Notamos que sua Loja do Insta ainda não foi configurada.

Se precisar de ajuda, nosso WhatsApp é +55 17 98145-2466

Grupo de Lojistas 👇
https://chat.whatsapp.com/Bg4HtMNFPefB1Z1fuA8oHs

Att,
lojadoinsta.com.br
                "
            ]);
        }
    }
}
