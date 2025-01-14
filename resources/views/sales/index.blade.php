<x-app-layout>
    <div class="container">
        <h1>Ventas</h1>
        <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Crear Venta</a>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Fecha de Venta</th>
                    <th>Total</th>
                    <th>Facturado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->client->name }}</td>
                        <td>{{ $sale->user->name }}</td>
                        <td>{{ $sale->sale_date }}</td>
                        <td>{{ $sale->total }}</td>
                        <td>{{ $sale->facturado ? 'Sí' : 'No' }}</td>
                        <td>
                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Estás seguro de eliminar esta venta?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
