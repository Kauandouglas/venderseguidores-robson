<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderRepositoryInterface $orderRepository
    ) {}

    public function index(Request $request)
    {
        $query = Purchase::with(['user', 'service']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhere('link', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);

        $stats = [
            'total' => Purchase::count(),
            'pending' => Purchase::where('status', OrderStatus::PENDING->value)->count(),
            'processing' => Purchase::where('status', OrderStatus::PROCESSING->value)->count(),
            'completed' => Purchase::where('status', OrderStatus::COMPLETED->value)->count(),
            'failed' => Purchase::where('status', OrderStatus::FAILED->value)->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Purchase $order)
    {
        $order->load(['user', 'service', 'payment']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Purchase $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'string'],
        ]);

        $order->status = $validated['status'];
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Status atualizado com sucesso!',
        ]);
    }

    public function reprocess(Purchase $order)
    {
        $this->authorize('reprocess', $order);

        // Lógica para reprocessar o pedido
        // Pode usar um Job para isso
        
        return response()->json([
            'success' => true,
            'message' => 'Pedido enviado para reprocessamento!',
        ]);
    }

    public function export(Request $request)
    {
        // Implementar exportação de pedidos para Excel/CSV
        
        return response()->json([
            'success' => true,
            'message' => 'Exportação em andamento...',
        ]);
    }
}
