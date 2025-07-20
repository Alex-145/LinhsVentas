<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reporte Detallado de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 12px;
        }

        .period {
            font-size: 11px;
            color: #555;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .sale-header {
            background-color: #e6f2ff;
            font-weight: bold;
        }

        .detail-row {
            background-color: #f9f9f9;
        }

        .totals {
            margin-top: 15px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 5px;
        }

        .footer {
            margin-top: 15px;
            font-size: 9px;
            text-align: center;
            color: #777;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Reporte Detallado de Ventas</div>
        <div class="subtitle">Filtro aplicado: {{ $filterStatus }}</div>
        @if ($startDate && $endDate)
            <div class="period">
                Periodo: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} al
                {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
            </div>
        @else
            <div class="period">Fecha del reporte: {{ now()->format('d/m/Y H:i') }}</div>
        @endif
    </div>

    @foreach ($sales as $sale)
        <table>
            <!-- Encabezado de la venta -->
            <tr class="sale-header">
                <td colspan="6">
                    <strong>Venta #{{ $loop->iteration }}</strong> |
                    Fecha: {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y H:i') }} |
                    Cliente: {{ $sale->client->name }} |
                    Vendedor: {{ $sale->user->name }} |
                    Total: S/. {{ number_format($sale->total, 2) }} |
                    Utilidad: S/. {{ number_format($sale->utilidad_sale, 2) }} |
                    Estado: {{ ucfirst(str_replace('_', ' ', $sale->status_fac)) }}
                </td>
            </tr>

            <!-- Detalles de la venta -->
            <tr>
                <th width="5%">#</th>
                <th width="45%">Producto/Servicio</th>
                <th width="10%">Cantidad</th>
                <th width="15%">Precio Unit.</th>
                <th width="15%">Subtotal</th>
                <th width="10%">Utilidad</th>
            </tr>

            @foreach ($sale->saleDetails as $detail)
                <tr class="detail-row">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($detail->salable)
                            {{ $detail->salable->name }}
                            @if ($detail->salable instanceof App\Models\Product)
                                (Producto)
                            @else
                                (Servicio)
                            @endif
                        @else
                            Producto eliminado
                        @endif
                    </td>
                    <td>{{ $detail->quantity }}</td>
                    <td>S/. {{ number_format($detail->price, 2) }}</td>
                    <td>S/. {{ number_format($detail->subtotal, 2) }}</td>
                    <td>S/. {{ number_format($detail->utilidad_saledetail, 2) }}</td>
                </tr>
            @endforeach
        </table>

        @if (!$loop->last)
            <div style="height: 15px;"></div>
        @endif
    @endforeach

    <div class="totals">
        <p>Total General de Ventas: S/. {{ number_format($totalSales, 2) }}</p>
        <p>Total General de Utilidades: S/. {{ number_format($totalGains, 2) }}</p>
        <p>Cantidad de Ventas: {{ count($sales) }}</p>
    </div>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} | Sistema de Ventas
    </div>
</body>

</html>
