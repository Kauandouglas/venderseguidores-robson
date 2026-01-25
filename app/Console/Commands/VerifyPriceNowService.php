<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Support\Smm;
use Illuminate\Console\Command;

class VerifyPriceNowService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verifyPriceNow:service';

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
        $services = Service::with('apiProvider')
            ->whereHas('apiProvider', function ($query) {
                $query->where('status', 1);
            })->whereHas('category', function ($query) {
                $query->where('status', 1);
            })->latest('id')->get();

        foreach ($services as $service) {
            if (!empty($service->apiProvider->key)) {
                $smm = new Smm($service->apiProvider->url, $service->apiProvider->key);
                $smm->serviceList();
                $smmCallback = $smm->callback();

                if (isset($smmCallback->error) && $smmCallback->error == 'Invalid API key') {
                    $apiProvider = $service->apiProvider()->first();
                    $apiProvider->status = 0;
                    $apiProvider->update();
                    continue;
                }

                foreach ($smmCallback as $smmCallbackService) {
                    if ($smmCallbackService->service == $service->api_service) {
                        $service->api_rate = $smmCallbackService->rate;
                        $service->update();
                        $service->recalcPriceFromProvider();
                    }
                }
            }
        }
    }
}
