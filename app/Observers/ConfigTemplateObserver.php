<?php

namespace App\Observers;

use App\Models\ConfigTemplate;
use Illuminate\Support\Facades\Cache;

class ConfigTemplateObserver
{
    /**
     * Handle the ConfigTemplate "created" event.
     *
     * @param  \App\Models\ConfigTemplate  $configTemplate
     * @return void
     */
    public function created(ConfigTemplate $configTemplate)
    {
        Cache::forget('configTemplate.' . $configTemplate->user_id);
    }

    /**
     * Handle the ConfigTemplate "updated" event.
     *
     * @param  \App\Models\ConfigTemplate  $configTemplate
     * @return void
     */
    public function updated(ConfigTemplate $configTemplate)
    {
        Cache::forget('configTemplate.' . $configTemplate->user_id);
    }

    /**
     * Handle the ConfigTemplate "deleted" event.
     *
     * @param  \App\Models\ConfigTemplate  $configTemplate
     * @return void
     */
    public function deleted(ConfigTemplate $configTemplate)
    {
        Cache::forget('configTemplate.' . $configTemplate->user_id);
    }
}
