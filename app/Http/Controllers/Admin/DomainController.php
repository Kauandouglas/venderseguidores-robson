<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index(Request $request)
    {
        $query = Domain::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('domain', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $domains = $query->latest()->paginate(20);

        return view('admin.domains.index', compact('domains'));
    }

    public function create()
    {
        $users = User::where('role', 2)->get();
        return view('admin.domains.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'domain' => ['required', 'string', 'unique:domains'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        Domain::create($validated);

        return redirect()
            ->route('admin.domains.index')
            ->with('success', 'Domínio criado com sucesso!');
    }

    public function show(Domain $domain)
    {
        $domain->load('user');
        return view('admin.domains.show', compact('domain'));
    }

    public function edit(Domain $domain)
    {
        $users = User::where('role', 2)->get();
        return view('admin.domains.edit', compact('domain', 'users'));
    }

    public function update(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'domain' => ['required', 'string', 'unique:domains,domain,' . $domain->id],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $domain->update($validated);

        return redirect()
            ->route('admin.domains.show', $domain)
            ->with('success', 'Domínio atualizado com sucesso!');
    }

    public function destroy(Domain $domain)
    {
        $domain->delete();

        return redirect()
            ->route('admin.domains.index')
            ->with('success', 'Domínio removido com sucesso!');
    }
}
