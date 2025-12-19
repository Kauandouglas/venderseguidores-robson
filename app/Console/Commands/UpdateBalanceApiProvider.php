<?php

namespace App\Console\Commands;

use App\Models\ApiProvider;
use App\Support\Smm;
use Illuminate\Console\Command;

class UpdateBalanceApiProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:apiProvider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update balance API provider.';

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
        $apiProviders = ApiProvider::with('user')->where('status', 1)->latest()->get();

        foreach ($apiProviders as $apiProvider) {
            $smm = new Smm($apiProvider->url, $apiProvider->key);
            $smm->balance();
            $smmCallback = $smm->callback();

            if(isset($smmCallback->error) && $smmCallback->error == "Invalid API key") {
                $apiProvider->status = 0;
                $apiProvider->update();

                echo "API Provider is inactive";
                continue;
            }

            if (isset($smmCallback->balance)) {
                $apiProvider->balance = $smmCallback->balance;
                $apiProvider->update();
            }
        }

        return Command::SUCCESS;
    }
}
