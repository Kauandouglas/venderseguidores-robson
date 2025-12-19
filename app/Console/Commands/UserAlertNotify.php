<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UserAlertNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'userAlert:notify';

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
        $users = User::users()->where('active_store', 1)->whereDoesntHave('purchases', function ($query) {
            $query->where('created_at', '>', date('Y-m-d H:i:s', strtotime('-5 days')))->success();
        })->with('userAlertNotify')->whereHas('userAlertNotify', function ($query) {
            $query->where('next_message_verify_at', '<', date('Y-m-d H:i:s'));
        })->get();

        foreach ($users as $user) {
            if (empty($user->userAlertNotify)) {
                $userAlertNotify = new \App\Models\UserAlertNotify();
                $userAlertNotify->user_id = $user->id;
                $userAlertNotify->level_message = 1;
                $userAlertNotify->next_message_verify_at = date('Y-m-d H:i:s', strtotime('+2 day'));
                $userAlertNotify->save();
            } elseif ($user->userAlertNotify->level_message == 1) {
                $userAlertNotify = $user->userAlertNotify;
                $userAlertNotify->level_message = $userAlertNotify->level_message + 1;
                $userAlertNotify->next_message_verify_at = date('Y-m-d H:i:s', strtotime('+3 day'));
                $userAlertNotify->save();
            } elseif ($user->userAlertNotify->level_message == 2) {
                $userAlertNotify = $user->userAlertNotify;
                $userAlertNotify->level_message = $userAlertNotify->level_message + 1;
                $userAlertNotify->next_message_verify_at = date('Y-m-d H:i:s', strtotime('+5 day'));
                $userAlertNotify->save();
            } elseif ($user->userAlertNotify->level_message == 3) {
                $userAlertNotify = $user->userAlertNotify;
                $userAlertNotify->level_message = $userAlertNotify->level_message + 1;
                $userAlertNotify->next_message_verify_at = date('Y-m-d H:i:s', strtotime('+7 day'));
                $userAlertNotify->save();
            } elseif ($user->userAlertNotify->level_message == 4) {
                $userAlertNotify = $user->userAlertNotify;
                $userAlertNotify->level_message = $userAlertNotify->level_message + 1;
                $userAlertNotify->next_message_verify_at = date('Y-m-d H:i:s', strtotime('+7 day'));
                $userAlertNotify->save();
            } elseif ($user->userAlertNotify->level_message == 5) {
                $userAlertNotify = $user->userAlertNotify;
                $userAlertNotify->level_message = $userAlertNotify->level_message + 1;
                $userAlertNotify->next_message_verify_at = date('Y-m-d H:i:s', strtotime('+30 day'));
                $userAlertNotify->save();
            }
        }
    }
}
