<?php

namespace App\Console\Commands;

use App\Models\Purchase;
use App\Support\Smm;
use Illuminate\Console\Command;

class RefillAuto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refill:auto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Refill auto users';

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
        $purchases = Purchase::success()->with('service.apiProvider')->whereHas('user', function ($query) {
            $query->where('refill_auto', 1);
        })->whereNotNull('order_id')
            ->where('created_at', '>', date('Y-m-d H:i:s', strtotime('-30 days')))
            ->where('next_refill', '<', now())
            ->limit(100)->get();

        foreach ($purchases as $purchase) {
            $smm = new Smm($purchase->service->apiProvider->url, $purchase->service->apiProvider->key);
            $smm->refill($purchase->order_id);
            $smmCallback = $smm->callback();

            $purchase->next_refill = date('Y-m-d H:i:s', strtotime("+25 hours"));
            $purchase->update();
        }
    }
}
