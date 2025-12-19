<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\ConfigTemplateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ConfigTemplateController extends Controller
{
    public function edit()
    {
        $configTemplate = Auth::user()->configTemplate()->first();

        return view('panel.configTemplates.edit', [
            'configTemplate' => $configTemplate
        ]);
    }

    public function update(ConfigTemplateRequest $request)
    {
        $systemSetting = Auth::user()->configTemplate()->updateOrCreate(
            ['user_id' => Auth::id()],
            $request->all()
        );

        $systemSetting->setHeaderImage($request->file('header_image'));
        $systemSetting->setServiceImage1($request->file('service_image_1'));
        $systemSetting->setServiceImage2($request->file('service_image_2'));
        $systemSetting->setServiceImage3($request->file('service_image_3'));
        $systemSetting->setAboutImage($request->file('about_image'));
        $systemSetting->update();

        return response()->json('Salvo com sucesso!');
    }

    public function removeImage(Request $request)
    {
        $systemSetting = Auth::user()->configTemplate()->firstOrFail();
        switch ($request->type) {
            case "header_image":
                Storage::delete($systemSetting->header_image);
                $systemSetting->header_image = null;
                break;
            case "service_image_1":
                Storage::delete($systemSetting->service_image_1);
                $systemSetting->service_image_1 = null;
                break;
            case "service_image_2":
                Storage::delete($systemSetting->service_image_1);
                $systemSetting->service_image_2 = null;
                break;
            case "service_image_3":
                Storage::delete($systemSetting->service_image_3);
                $systemSetting->service_image_3 = null;
                break;
            case "about_image":
                Storage::delete($systemSetting->about_image);
                $systemSetting->about_image = null;
                break;
        }

        $systemSetting->update();

        return redirect()->back();
    }
}
