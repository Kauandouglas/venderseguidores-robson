<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class VerifyOrdersFail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:ordersFail';

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
        $users = User::withCount(['purchases' => function ($query) {
            $query->where('status', 'canceled')->whereNotNull('error');
        }])->whereNull('block_order_fail')->get();

        foreach ($users as $user) {
            if ($user->purchases_count >= 3) {
                $user->block_order_fail = date('Y-m-d H:i:s', strtotime('+2 day'));
                $user->save();

                $message = "Você tem *$user->purchases_count->* ordens na falha, caso não faça o envio em até 48h sua
                conta será desativada";

                $whatsapp = new \App\Support\Whatsapp();
                $whatsapp->sendMessage(clearString('55' . $user->phone), $message);
            }
        }
    }
}
