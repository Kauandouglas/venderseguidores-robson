<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\ConversionTagRequest;
use App\Models\ConversionTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversionTagController extends Controller
{
    public function edit()
    {
        $conversionTag = Auth::user()->conversionTag()->first();

        return view('panel.conversionTags.edit', [
            'conversionTag' => $conversionTag
        ]);
    }

    public function update(ConversionTagRequest $request)
    {
        $conversionTag = Auth::user()->conversionTag()->updateOrCreate([
            'user_id' => Auth::id()
        ], $request->all());

        return redirect()->back()->withSuccess('Tags atualizadas com sucesso!');
    }
}
