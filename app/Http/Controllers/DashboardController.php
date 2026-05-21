<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\ProductRequest;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts        = Product::count();
        $totalEntries         = InventoryMovement::where('type', 'entrada')->count();
        $totalOutputs         = InventoryMovement::where('type', 'salida')->count();
        $pendingRequestsCount = ProductRequest::where('status', 'pendiente')->count();
        $lowStockCount        = Product::where('stock', '<', 5)->count();
        $todayMovements       = InventoryMovement::whereDate('created_at', today())->count();

        $recentMovements = InventoryMovement::with('product')->latest()->take(5)->get();

        // Últimos 7 días para mini-gráfico
        $weeklyData = InventoryMovement::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw("SUM(CASE WHEN type='entrada' THEN quantity ELSE 0 END) as entradas"),
                DB::raw("SUM(CASE WHEN type='salida'  THEN quantity ELSE 0 END) as salidas")
            )
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalEntries',
            'totalOutputs',
            'pendingRequestsCount',
            'recentMovements',
            'lowStockCount',
            'todayMovements',
            'weeklyData'
        ));
    }
}
