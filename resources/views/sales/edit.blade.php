
<div class="container">
    <h1>Editar Venta</h1>
    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="client_id" class="form-label">Cliente</label>
            <select name="client_id" id="client_id" class="form-control" required>
                @foreach ($clients as $client)
                <option value="{{ $client->id }}" {{ $client->id == $sale->client_id ? 'selected' : '' }}>
                    {{ $client->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="sale_date" class="form-label">Fecha de Venta</label>
            <input type="date" name="sale_date" id="sale_date" class="form-control" value="{{ $sale->sale_date }}" required>
        </div>
        <div class="mb-3">
            <label for="products" class="form-label">Productos</label>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>
                            <input type="checkbox" name="products[{{ $product->id }}][id]" value="{{ $product->id }}"
                                {{ $sale->saleDetails->contains('product_id', $product->id) ? 'checked' : '' }}>
                            {{ $product->name }}
                        </td>
                        <td>
                            <input type="number" name="products[{{ $product->id }}][quantity]" class="form-control"
                                value="{{ $sale->saleDetails->where('product_id', $product->id)->first()->quantity ?? '' }}"
                                min="1" {{ $sale->saleDetails->contains('product_id', $product->id) ? '' : 'disabled' }}>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
    </form>
</div>

<script>
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const quantityInput = this.closest('tr').querySelector('input[type="number"]');
            quantityInput.disabled = !this.checked;
        });
    });
</script>
