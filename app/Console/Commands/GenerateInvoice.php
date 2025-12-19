<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\PlanPurchase;
use Illuminate\Console\Command;

class GenerateInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate invoice for the user';

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
        $planPurchases = PlanPurchase::where('next_generate_invoice_at', '<=', now())->whereDoesntHave('invoices', function ($query){
            $query->where('status', 'Pending');
        })->active()->get();
        foreach ($planPurchases as $planPurchase){
            $invoice = new Invoice();
            $invoice->user_id = $planPurchase->user_id;
            $invoice->plan_purchase_id = $planPurchase->id;
            $invoice->save();
        }
    }
}
