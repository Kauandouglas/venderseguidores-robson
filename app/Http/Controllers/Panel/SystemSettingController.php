<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\SystemSettingRequest;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;

class SystemSettingController extends Controller
{
    public function edit()
    {
        $templates = Template::whereNull('user_id')->orWhere('user_id', Auth::id())->get();
        $systemSetting = Auth::user()->systemSettings()->first();

        return view('panel.systemSettings.edit', [
            'systemSetting' => $systemSetting,
            'templates' => $templates
        ]);
    }

    public function update(SystemSettingRequest $request)
    {
        $systemSetting = Auth::user()->systemSettings()->updateOrCreate(
            ['user_id' => Auth::id()],
            $request->all()
        );

        ($request->color_default ? $systemSetting->color_default = 1 : $systemSetting->color_default = 0);

        $systemSetting->setLogo($request->file('logo'));
        $systemSetting->setFavicon($request->file('favicon'));
        $systemSetting->notify_popup_status = boolval($request->notify_popup_status);
        $systemSetting->update();

        return response()->json('Salvo com sucesso!');
    }
}
