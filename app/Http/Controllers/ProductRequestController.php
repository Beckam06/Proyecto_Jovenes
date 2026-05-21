<?php

namespace App\Http\Controllers;

use App\Models\ProductRequest;
use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = ProductRequest::with('product')->latest()->paginate(10)->appends($request->query());
        return view('admin.requests.index', compact('requests'));
    }

    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $productRequest    = ProductRequest::findOrFail($id);
            $quantityRequested = $productRequest->quantity_requested;

            // Bloquear si es producto nuevo sin crear aún
            if ($productRequest->is_new_product && !$productRequest->product_id) {
                return redirect()->back()->with('error', 'Primero crea el producto en el inventario.');
            }

            $product = $productRequest->product;

            // Sin stock alguno → bloquear completamente
            if (!$product || $product->stock === 0) {
                DB::rollBack();
                return redirect()->back()->with('error',
                    "No hay stock disponible de \"{$product->name}\". Registra una entrada de inventario primero."
                );
            }

            $stock = $product->stock;

            // ── CASO 1: Stock suficiente → salida completa ──
            if ($stock >= $quantityRequested) {
                InventoryMovement::create([
                    'product_id' => $product->id,
                    'quantity'   => $quantityRequested,
                    'type'       => 'salida',
                    'notes'      => 'Solicitud aprobada: ' . $productRequest->purpose,
                    'receptor'   => $productRequest->receptor,
                ]);
                $product->stock -= $quantityRequested;
                $product->save();

                $productRequest->update([
                    'quantity_approved' => $quantityRequested,
                    'quantity_pending'  => 0,
                    'status'            => 'aprobado',
                    'processed_by'      => Auth::id(),
                    'processed_at'      => now(),
                    'notes'             => "Aprobado completamente. Salida de {$quantityRequested} unidades.",
                ]);

                DB::commit();
                return redirect()->back()->with('success',
                    "Aprobado. Salida de {$quantityRequested} unidades de \"{$product->name}\" registrada."
                );
            }

            // ── CASO 2: Stock parcial → entregar lo que hay, dejar resto pendiente ──
            $entregado = $stock;
            $pendiente = $quantityRequested - $stock;

            InventoryMovement::create([
                'product_id' => $product->id,
                'quantity'   => $entregado,
                'type'       => 'salida',
                'notes'      => "Aprobación parcial ({$entregado}/{$quantityRequested}): " . $productRequest->purpose,
                'receptor'   => $productRequest->receptor,
            ]);

            $product->stock = 0;
            $product->save();

            $productRequest->update([
                'quantity_approved' => $entregado,
                'quantity_pending'  => $pendiente,
                'status'            => 'parcialmente_aprobado',
                'processed_by'      => Auth::id(),
                'processed_at'      => now(),
                'notes'             => "Parcial: entregado {$entregado}, pendiente {$pendiente}.",
            ]);

            DB::commit();
            return redirect()->back()->with('warning',
                "Aprobación parcial: se entregaron {$entregado} unidades. Quedan {$pendiente} pendientes para cuando haya más stock."
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function completePending($id)
    {
        DB::beginTransaction();
        try {
            $productRequest  = ProductRequest::findOrFail($id);
            $pendingQuantity = $productRequest->quantity_pending;
            $product         = $productRequest->product;

            if (!$product || $product->stock === 0) {
                DB::rollBack();
                return redirect()->back()->with('error',
                    "Sin stock disponible. Agrega inventario primero."
                );
            }

            $stock     = $product->stock;
            $entregar  = min($stock, $pendingQuantity);
            $restante  = $pendingQuantity - $entregar;

            InventoryMovement::create([
                'product_id' => $product->id,
                'quantity'   => $entregar,
                'type'       => 'salida',
                'notes'      => "Completación solicitud #{$productRequest->id}",
                'receptor'   => $productRequest->receptor,
            ]);

            $product->stock -= $entregar;
            $product->save();

            $totalAprobado = $productRequest->quantity_approved + $entregar;

            $productRequest->update([
                'quantity_approved' => $totalAprobado,
                'quantity_pending'  => $restante,
                'status'            => $restante === 0 ? 'completado' : 'parcialmente_aprobado',
                'notes'             => $restante === 0
                    ? "Completado. Total entregado: {$totalAprobado}."
                    : "Entregado {$entregar} más. Aún pendiente: {$restante}.",
            ]);

            DB::commit();

            return $restante === 0
                ? redirect()->back()->with('success', "Solicitud completada. {$entregar} unidades entregadas.")
                : redirect()->back()->with('warning', "Entregadas {$entregar} unidades. Aún quedan {$restante} pendientes.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        ProductRequest::findOrFail($id)->update([
            'status'       => 'rechazado',
            'processed_by' => Auth::id(),
            'processed_at' => now(),
            'notes'        => 'Rechazada por el administrador.',
        ]);
        return redirect()->back()->with('success', 'Solicitud rechazada.');
    }

    public function createProductFromRequest($id)
    {
        $req = ProductRequest::findOrFail($id);

        if (!$req->is_new_product)  return redirect()->back()->with('error', 'No es una solicitud de producto nuevo.');
        if ($req->product_id)       return redirect()->back()->with('error', 'Esta solicitud ya tiene un producto vinculado.');

        $product = Product::firstOrCreate(
            ['name' => $req->new_product_name],
            [
                'description' => $req->new_product_description ?? '',
                'price'       => 0,
                'stock'       => 0,
                'sku'         => 'NP-' . strtoupper(substr(md5(time()), 0, 6)),
            ]
        );

        $req->update(['product_id' => $product->id, 'status' => 'producto_creado']);

        return redirect()->back()->with('success',
            "Producto \"{$product->name}\" creado con stock 0. Agrega las unidades con un movimiento de ENTRADA y luego aprueba."
        );
    }

    public function markAsReview($id)
    {
        ProductRequest::findOrFail($id)->update(['status' => 'en_revision']);
        return redirect()->back()->with('success', 'Solicitud en revisión.');
    }
}
