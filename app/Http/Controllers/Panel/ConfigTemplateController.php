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
        // 1. Pegamos todos os dados de texto
        $data = $request->except(['_token', '_method']);

        // 2. Processamos os arquivos (imagens)
        // O método allFiles() pega todos os uploads, mesmo os aninhados em arrays
        $files = $request->allFiles();

        foreach ($files as $key => $file) {
            if (is_array($file)) {
                foreach ($file as $index => $subFile) {
                    if (is_array($subFile)) {
                        // Para estruturas como services[0][image]
                        foreach ($subFile as $subKey => $actualFile) {
                            if ($actualFile->isValid()) {
                                $data[$key][$index][$subKey] = $actualFile->store('templates', 'public');
                            }
                        }
                    } else {
                        // Para estruturas como header[image]
                        if ($subFile->isValid()) {
                            $data[$key][$index] = $subFile->store('templates', 'public');
                        }
                    }
                }
            } else {
                // Para arquivos simples na raiz
                if ($file->isValid()) {
                    $data[$key] = $file->store('templates', 'public');
                }
            }
        }

        // 3. Recuperamos os dados atuais para não perder o que não foi enviado agora
        $config = Auth::user()->configTemplate;
        $oldContent = $config ? $config->content : [];

        // 4. Mesclamos os dados novos com os antigos (preserva caminhos de imagens não alteradas)
        $finalData = array_replace_recursive($oldContent, $data);

        // 5. Salvamos
        Auth::user()->configTemplate()->updateOrCreate(
            [],
            [
                'content' => $finalData
            ]
        );

        return redirect()->back()->with('success', 'Configurações atualizadas!');
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
