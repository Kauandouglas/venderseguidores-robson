<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\ServiceDescountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceDescountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceDescounts = Auth::user()->serviceDescounts()->latest()->paginate(30);

        return view('panel.serviceDescounts.index', [
            'serviceDescounts' => $serviceDescounts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.serviceDescounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ServiceDescountRequest $request)
    {
        Auth::user()->serviceDescounts()->create($request->all());

        return response()->json('Desconto cadastrado com sucesso!', 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ServiceDescount $serviceDescount
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $serviceDescount = Auth::user()->serviceDescounts()->findOrFail($request->serviceDescount);

        return view('panel.serviceDescounts.edit', [
            'serviceDescount' => $serviceDescount
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ServiceDescount $serviceDescount
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceDescountRequest $request)
    {
        $serviceDescount = Auth::user()->serviceDescounts()->findOrFail($request->serviceDescount);
        $serviceDescount->fill($request->all());
        $serviceDescount->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ServiceDescount $serviceDescount
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $serviceDescount = Auth::user()->serviceDescounts()->findOrFail($request->serviceDescount);

        $serviceDescount->delete();

        return redirect()->route('panel.serviceDescounts.index')->with('success', 'Desconto excluído com sucesso!');
    }
}
