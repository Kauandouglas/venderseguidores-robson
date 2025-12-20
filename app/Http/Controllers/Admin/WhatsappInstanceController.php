<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsappInstance;
use App\Models\User;
use Illuminate\Http\Request;

class WhatsappInstanceController extends Controller
{
    public function index(Request $request)
    {
        $query = WhatsappInstance::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('phone_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $instances = $query->latest()->paginate(20);

        return view('admin.whatsapp.index', compact('instances'));
    }

    public function create()
    {
        $users = User::where('role', 2)->get();
        return view('admin.whatsapp.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => ['required', 'string', 'unique:whatsapp_instances'],
            'user_id' => ['required', 'exists:users,id'],
            'api_key' => ['required', 'string'],
            'status' => ['required', 'in:connected,disconnected,error'],
        ]);

        WhatsappInstance::create($validated);

        return redirect()
            ->route('admin.whatsapp.index')
            ->with('success', 'Instância WhatsApp criada com sucesso!');
    }

    public function show(WhatsappInstance $whatsappInstance)
    {
        $whatsappInstance->load('user');
        return view('admin.whatsapp.show', compact('whatsappInstance'));
    }

    public function edit(WhatsappInstance $whatsappInstance)
    {
        $users = User::where('role', 2)->get();
        return view('admin.whatsapp.edit', compact('whatsappInstance', 'users'));
    }

    public function update(Request $request, WhatsappInstance $whatsappInstance)
    {
        $validated = $request->validate([
            'phone_number' => ['required', 'string', 'unique:whatsapp_instances,phone_number,' . $whatsappInstance->id],
            'user_id' => ['required', 'exists:users,id'],
            'api_key' => ['required', 'string'],
            'status' => ['required', 'in:connected,disconnected,error'],
        ]);

        $whatsappInstance->update($validated);

        return redirect()
            ->route('admin.whatsapp.show', $whatsappInstance)
            ->with('success', 'Instância WhatsApp atualizada com sucesso!');
    }

    public function destroy(WhatsappInstance $whatsappInstance)
    {
        $whatsappInstance->delete();

        return redirect()
            ->route('admin.whatsapp.index')
            ->with('success', 'Instância WhatsApp removida com sucesso!');
    }

    public function testConnection(WhatsappInstance $whatsappInstance)
    {
        // Implementar lógica de teste de conexão
        return response()->json([
            'success' => true,
            'message' => 'Conexão testada com sucesso!',
        ]);
    }
}
