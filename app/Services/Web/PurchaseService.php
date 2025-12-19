<?php

namespace App\Services\Web;

use App\Models\Purchase;
use App\Support\Smm;

class PurchaseService
{
    public function sendOrder(Purchase $purchase)
    {
        $service = $purchase->service()->first();
        $apiProvider = $service->apiProvider()->first();

        if ($purchase->status == 'pending' || $purchase->status == 'canceled') {
            $purchase->status = 'approved';
            $purchase->update();

            $link = ($service->type == 2 || $service->type == 4 ? 'https://instagram.com/p/' . $purchase->instagram : $purchase->instagram);

            $smm = new Smm($apiProvider->url, $apiProvider->key);
            $smm->addOrder($service->api_service, $link, $service->quantity, $purchase->comment);
            $smmCallback = $smm->callback();

            if (isset($smmCallback->order)) {
                $purchase->order_id = $smmCallback->order;
            } else {
                $purchase->error = $smmCallback;
                $purchase->status = 'canceled';
            }
            $purchase->update();
        }
    }
}
