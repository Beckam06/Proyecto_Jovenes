<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class InventoryMovementController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryMovement::with('product')->latest();

        if ($request->filled('type'))       $query->where('type', $request->type);
        if ($request->filled('start_date')) $query->whereDate('created_at', '>=', $request->start_date);
        if ($request->filled('end_date'))   $query->whereDate('created_at', '<=', $request->end_date);
        if ($request->filled('receptor'))   $query->where('receptor', 'like', '%'.$request->receptor.'%');

        $movements = $query->paginate(15)->appends($request->query());

        return view('movements.index', compact('movements'));
    }

    public function create(Request $request)
    {
        $product = null;
        $type = $request->get('type', 'entrada');

        if ($request->filled('product')) {
            $product = Product::find($request->product);
            $type = 'entrada';
        }

        $products = Product::orderBy('name')->get();
        return view('movements.create', compact('products', 'product', 'type'));
    }

    public function store(Request $request)
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'type'       => 'required|in:entrada,salida',
            'notes'      => 'nullable',
        ];

        if ($request->type === 'salida') {
            $rules['receptor'] = 'required';
            $product = Product::find($request->product_id);
            if ($product) $rules['quantity'] .= '|max:'.$product->stock;
        }

        $request->validate($rules);

        $product = Product::findOrFail($request->product_id);

        if ($request->type === 'salida' && $request->quantity > $product->stock) {
            return back()->withErrors(['quantity' => "Stock insuficiente. Solo hay {$product->stock} unidades."])->withInput();
        }

        InventoryMovement::create($request->only(['product_id','quantity','type','notes','receptor']));

        $product->stock += $request->type === 'entrada' ? $request->quantity : -$request->quantity;
        $product->save();

        return redirect()->route('movements.index')->with('success', 'Movimiento registrado correctamente.');
    }

    public function destroy(InventoryMovement $movement)
    {
        // Revertir el stock al eliminar
        $product = $movement->product;
        if ($product) {
            $product->stock += $movement->type === 'entrada' ? -$movement->quantity : $movement->quantity;
            $product->save();
        }

        $movement->delete();

        return redirect()->route('movements.index')->with('success', 'Movimiento eliminado y stock revertido.');
    }

    public function generatePDF(Request $request)
    {
        $query = InventoryMovement::with('product')->latest();
        if ($request->filled('type'))       $query->where('type', $request->type);
        if ($request->filled('receptor'))   $query->where('receptor', 'like', '%'.$request->receptor.'%');
        if ($request->filled('start_date')) $query->whereDate('created_at', '>=', $request->start_date);
        if ($request->filled('end_date'))   $query->whereDate('created_at', '<=', $request->end_date);
        $movements = $query->get();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $html = view('movements.pdf', compact('movements'))->render();
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return $dompdf->stream('reporte-movimientos-'.date('Y-m-d').'.pdf');
    }
}
