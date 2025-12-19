<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function index(Request $request)
    {
        $query = User::where('role', UserRole::USER->value);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('domain', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->with(['planPurchase', 'systemSetting'])
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->load([
            'systemSetting',
            'planPurchase',
            'purchases' => fn($q) => $q->latest()->take(20),
            'services',
            'categories',
        ]);

        $stats = [
            'total_orders' => $user->purchases()->count(),
            'completed_orders' => $user->purchases()->where('status', 'completed')->count(),
            'total_revenue' => $user->purchases()->where('status', 'completed')->sum('price'),
            'total_services' => $user->services()->count(),
            'active_services' => $user->services()->where('status', 1)->count(),
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'domain' => ['required', 'string', 'unique:users,domain'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string'],
            'role' => ['required', Rule::in([UserRole::USER->value, UserRole::ADMIN->value])],
            'status' => ['required', 'boolean'],
        ]);

        $user = User::create($validated);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'domain' => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string'],
            'role' => ['required', Rule::in([UserRole::USER->value, UserRole::ADMIN->value])],
            'status' => ['required', 'boolean'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuário removido com sucesso!');
    }

    public function toggleStatus(User $user)
    {
        $this->authorize('changeStatus', $user);

        $user->status = !$user->status;
        $user->save();

        return response()->json([
            'success' => true,
            'status' => $user->status,
            'message' => 'Status alterado com sucesso!',
        ]);
    }
}
