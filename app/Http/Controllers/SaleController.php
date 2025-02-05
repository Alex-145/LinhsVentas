<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('client', 'user', 'saleDetails.product')->get();
        return view('sales.index', compact('sales'));
    }


    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        return view('sales.create', compact('clients', 'products'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'sale_date' => 'required|date',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Crear la venta
        $sale = Sale::create([
            'client_id' => $request->client_id,
            'user_id' => Auth::id(), // ID del usuario autenticado
            'sale_date' => $request->sale_date,
            'total' => 0, // Inicialmente en 0, se calcula más adelante
            'facturado' => $request->facturado ?? false, // Campo facturado (boolean)
        ]);

        $total = 0;

        // Crear los detalles de la venta
        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['id']);
            $subtotal = $product->price * $productData['quantity'];
            $total += $subtotal;

            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $productData['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
            ]);
        }

        // Actualizar el total de la venta
        $sale->update(['total' => $total]);

        return redirect()->route('sales.index')->with('success', 'Venta creada correctamente.');
    }
    function show($id)
    {
        $sale = Sale::with('client', 'user', 'saleDetails.product')->findOrFail($id);
        return view('sales.show', compact('sale'));
    }
    public function edit($id)
    {
        $sale = Sale::with('saleDetails')->findOrFail($id);
        $clients = Client::all();
        $products = Product::all();
        return view('sales.edit', compact('sale', 'clients', 'products'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'sale_date' => 'required|date',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $sale = Sale::findOrFail($id);
        $sale->update([
            'client_id' => $request->client_id,
            'sale_date' => $request->sale_date,
            'facturado' => $request->facturado ?? false,
        ]);

        // Actualizar los detalles de la venta
        $total = 0;
        $sale->saleDetails()->delete(); // Eliminar detalles antiguos

        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['id']);
            $subtotal = $product->price * $productData['quantity'];
            $total += $subtotal;

            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $productData['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
            ]);
        }

        // Actualizar el total de la venta
        $sale->update(['total' => $total]);

        return redirect()->route('sales.index')->with('success', 'Venta actualizada correctamente.');
    }
    public function searchProducts(Request $request)
    {
        $query = $request->get('query', '');
        $products = Product::where('name', 'like', "%$query%")
            ->orWhere('id', 'like', "%$query%")
            ->limit(10)
            ->get();

        return response()->json($products);
    }
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venta eliminada correctamente.');
    }
}
