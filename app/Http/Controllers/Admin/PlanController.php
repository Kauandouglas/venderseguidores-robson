<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $query = Plan::latest()->paginate(20);

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:plans'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'period' => ['required', 'in:monthly,quarterly,annual'],
            'features' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ]);

        Plan::create($validated);

        return redirect()
            ->route('admin.plans.index')
            ->with('success', 'Plano criado com sucesso!');
    }

    public function show(Plan $plan)
    {
        $plan->load('purchases.user');
        return view('admin.plans.show', compact('plan'));
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:plans,name,' . $plan->id],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'period' => ['required', 'in:monthly,quarterly,annual'],
            'features' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ]);

        $plan->update($validated);

        return redirect()
            ->route('admin.plans.show', $plan)
            ->with('success', 'Plano atualizado com sucesso!');
    }

    public function destroy(Plan $plan)
    {
        if ($plan->purchases()->count() > 0) {
            return redirect()
                ->route('admin.plans.index')
                ->with('error', 'Não é possível deletar um plano com compras!');
        }

        $plan->delete();

        return redirect()
            ->route('admin.plans.index')
            ->with('success', 'Plano removido com sucesso!');
    }
}
