
<div class="container">
    <h1>Detalles de la Venta</h1>
    <p><strong>Cliente:</strong> {{ $sale->client->name }}</p>
    <p><strong>Usuario:</strong> {{ $sale->user->name }}</p>
    <p><strong>Fecha:</strong> {{ $sale->sale_date }}</p>
    <p><strong>Total:</strong> S/ {{ number_format($sale->total, 2) }}</p>
    <p><strong>Facturado:</strong> {{ $sale->facturado ? 'Sí' : 'No' }}</p>

    <h3>Productos Vendidos</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->saleDetails as $detail)
            <tr>
                <td>{{ $detail->product->name }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>S/ {{ number_format($detail->price, 2) }}</td>
                <td>S/ {{ number_format($detail->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Volver</a>
</div>
