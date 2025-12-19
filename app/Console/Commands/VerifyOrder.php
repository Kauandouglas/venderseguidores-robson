<?php

namespace App\Console\Commands;

use App\Models\Purchase;
use App\Support\Smm;
use Illuminate\Console\Command;

class VerifyOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:order';

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
        $purchases = Purchase::with('service.apiProvider')
            ->whereNotNull('order_id')
            ->whereNull('status_provider')->orWhere
            ->whereIn('status_provider', ['pending', 'in progress', 'processing'])->get();

        foreach ($purchases as $purchase) {
            if(isset($purchase->service->apiProvider)){
                $smm = new Smm($purchase->service->apiProvider->url, $purchase->service->apiProvider->key);
                $smm->status($purchase->order_id);
                $smmCallback = $smm->callback();

                if (isset($smmCallback->charge)) {
                    $purchase->charge = $smmCallback->charge;
                    $purchase->status_provider = strtolower($smmCallback->status);
                    $purchase->update();
                }
            }
        }
    }
}

