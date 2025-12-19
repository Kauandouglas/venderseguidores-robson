<?php

namespace App\Console\Commands;

use App\Models\ApiProvider;
use App\Support\Smm;
use Illuminate\Console\Command;

class ActiveStoreUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'active:store';

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
        $apiProviders = ApiProvider::with('user')->whereHas('user', function ($query) {
            $query->where('active_store', false);
        })->where('status', 1)->latest()->where('id', '>', 1502)->get();

        foreach ($apiProviders as $apiProvider) {
            $smm = new Smm($apiProvider->url, $apiProvider->key);
            $smm->balance();
            $smmCallback = $smm->callback();

            if (isset($smmCallback->error) && $smmCallback->error == "Invalid API key") {
                $apiProvider->status = 0;
                $apiProvider->update();

                echo "API Provider is inactive";
                continue;
            }

            if (isset($smmCallback->balance)) {
                if ($smmCallback->balance >= ($apiProvider->balance + 45)) {
                    $user = $apiProvider->user;
                    $user->active_store = true;
                    $user->update();

                }
            }
        }

        return Command::SUCCESS;
    }
}
