<?php

namespace App\Console\Commands;

use App\Models\UserNotify;
use Illuminate\Console\Command;

class SendUserNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:userNotify';

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
        $userNotifies = UserNotify::whereNull('send_at')->with('user')->get();
        foreach ($userNotifies as $userNotify) {
            if ($userNotify->type == 'email' || $userNotify->type == 'all') {

            }

            if ($userNotify->type == 'whatsapp' || $userNotify->type == 'all') {
                $whatsapp = new \App\Support\Whatsapp();
                $whatsapp->sendMessage(clearString('55' . $userNotify->user->phone), $userNotify->message);
            }

            $userNotify->send_at = now();
            $userNotify->save();
        }
    }
}
