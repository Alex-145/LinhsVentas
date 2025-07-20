<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cotización</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #555;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            height: 80px;
        }

        h2 {
            margin: 0;
            font-size: 20px;
        }

        h3 {
            margin-top: 20px;
            margin-bottom: 5px;
        }

        p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        tfoot td {
            font-weight: bold;
            background-color: #fafafa;
        }

        .info-box {
            margin-top: 20px;
            font-size: 12px;
            background-color: #fffbe6;
            border-left: 4px solid #ffcc00;
            padding: 10px;
        }

        .empresa-info {
            margin-top: 40px;
            font-size: 11px;
            color: #333;
            border-top: 1px solid #aaa;
            padding-top: 15px;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <!-- Encabezado con datos de empresa -->
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo de la empresa" class="logo">
        <div class="text-right">
            <h2>Cotización</h2>
            <p><strong>Fecha de emisión:</strong> {{ $fecha->format('d/m/Y') }}</p>
            <p><strong>Válido hasta:</strong> {{ $fecha_vencimiento->format('d/m/Y') }}</p>
            <p><strong>Asesor:</strong> Lino Huamanvilca Saico</p>
            <p><strong>RUC:</strong> 10248853781</p>
        </div>
    </div>

    <!-- Datos de contacto de la empresa -->
    <div>
        <p><strong>Dirección:</strong> Wichaypampa s/n</p>
        <p><strong>Celular:</strong> 974369546</p>
        <p><strong>Email:</strong> linhs.saico@gmail.com</p>
    </div>

    <!-- Información del Cliente -->
    <h3>Datos del Cliente</h3>
    <p><strong>DNI:</strong> {{ $cliente['dni'] }}</p>
    <p><strong>Nombre:</strong> {{ $cliente['name'] }}</p>
    <p><strong>Email:</strong> {{ $cliente['email'] }}</p>
    <p><strong>Teléfono:</strong> {{ $cliente['phone_number'] }}</p>
    @isset($cliente['ruc'], $cliente['business_name'])
        <p><strong>RUC:</strong> {{ $cliente['ruc'] }}</p>
        <p><strong>Razón Social:</strong> {{ $cliente['business_name'] }}</p>
    @endisset

    <!-- Tabla de productos -->
    <!-- Tabla de productos -->
    <h3>Resumen de Cotización</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Código</th>
                <th style="width: 40%;">Producto</th>
                <th style="width: 10%;">Cantidad</th>
                <th style="width: 20%;">Precio Unitario</th>
                <th style="width: 20%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $item)
                <tr>
                    <td>{{ $item['id'] }}</td> {{-- ID como código --}}
                    <td class="text-left">{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>S/. {{ number_format($item['price'], 2) }}</td>
                    <td>S/. {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                </tr>
            @endforeach

            {{-- Filas vacías para completar espacio visual --}}
            @for ($i = 0; $i < max(5 - count($cart), 0); $i++)
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
            @endfor
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right">Subtotal</td>
                <td>S/. {{ number_format($subtotal, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right">IGV (18%)</td>
                <td>S/. {{ number_format($igv, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right">Total</td>
                <td>S/. {{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>


    <!-- Cuentas bancarias -->
    <div class="empresa-info">
        <p><strong>N° de cuenta BBVA:</strong> 0011-0976-0200050980</p>
        <p><strong>CCI BBVA:</strong> 011-976-000200050980-88</p>
        <p><strong>N° de cuenta BCP:</strong> 28590601698031</p>
    </div>

    <!-- Mensaje de cierre -->
    <p style="margin-top: 30px; font-size: 11px; text-align: center;">
        Gracias por confiar en nosotros. Para más información contáctenos por WhatsApp o visítenos en tienda.
    </p>
</body>

</html>
