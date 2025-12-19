<?php

namespace App\Observers;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Cache;

class SystemSettingObserver
{
    /**
     * Handle the SystemSetting "created" event.
     *
     * @param \App\Models\SystemSetting $systemSetting
     * @return void
     */
    public function created(SystemSetting $systemSetting)
    {
        Cache::forget('systemSetting.' . $systemSetting->user_id);
    }

    /**
     * Handle the SystemSetting "updated" event.
     *
     * @param \App\Models\SystemSetting $systemSetting
     * @return void
     */
    public function updated(SystemSetting $systemSetting)
    {
        Cache::forget('systemSetting.' . $systemSetting->user_id);
    }

    /**
     * Handle the SystemSetting "deleted" event.
     *
     * @param \App\Models\SystemSetting $systemSetting
     * @return void
     */
    public function deleted(SystemSetting $systemSetting)
    {
        Cache::forget('systemSetting.' . $systemSetting->user_id);
    }
}
