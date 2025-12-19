<?php

namespace App\Observers;

use App\Models\Template;
use Illuminate\Support\Facades\Cache;

class TemplateObserver
{
    /**
     * Handle the Template "created" event.
     *
     * @param  \App\Models\Template  $template
     * @return void
     */
    public function created(Template $template)
    {
        Cache::forget('systemSettingTemplate.' . $template->id);
    }

    /**
     * Handle the Template "updated" event.
     *
     * @param  \App\Models\Template  $template
     * @return void
     */
    public function updated(Template $template)
    {
        Cache::forget('systemSettingTemplate.' . $template->id);
    }

    /**
     * Handle the Template "deleted" event.
     *
     * @param  \App\Models\Template  $template
     * @return void
     */
    public function deleted(Template $template)
    {
        Cache::forget('systemSettingTemplate.' . $template->id);
    }
}
