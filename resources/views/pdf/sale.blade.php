<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Venta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #000;
            padding: 10px 0;
        }
        .header img {
            width: 120px; /* Ajusta el tamaño del logo */
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 0;
            font-size: 12px;
        }
        .details {
            margin-top: 20px;
        }
        .details td {
            padding: 5px 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .total {
            margin-top: 20px;
            text-align: right;
        }
        .total p {
            margin: 5px 0;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <img src="/storage/app/public/pageweb/logonuevo.png" alt="Logo">
            <div>
                <h1>Boleta de Venta</h1>
                <p>Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>

                <p>Cliente: {{ $sale->client->name }}</p>
                <p>DNI/RUC: {{ $sale->client->dni_ruc }}</p>
            </div>
        </div>

        <div class="details">
            <table class="table">
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
                            <td>{{ $detail->salable->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->price, 2) }}</td>
                            <td>{{ number_format($detail->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                <p><strong>Total:</strong> {{ number_format($sale->total, 2) }} </p>
            </div>
        </div>
    </div>

</body>
</html>
