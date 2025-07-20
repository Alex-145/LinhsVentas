<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Pago Aprobado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
        }

        .code {
            font-size: 24px;
            font-weight: bold;
            color: #3490dc;
            text-align: center;
            margin: 20px 0;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>¡Gracias por tu compra en Linhs Llantas!</h2>
    </div>

    <div class="content">
        <p>Tu pago ha sido <strong>aprobado</strong> para la proforma:</p>
        <div class="code">{{ $proforma->codigo }}</div>

        <p>Detalles del pago:</p>
        <ul>
            <li><strong>Fecha de pago:</strong> {{ $proforma->fecha_pago->format('d/m/Y H:i') }}</li>
            <li><strong>Método de pago:</strong> {{ $proforma->metodo_pago }}</li>
            <li><strong>Total pagado:</strong> S/ {{ number_format($proforma->total, 2) }}</li>
        </ul>

        <p>Ya puedes acercarte a recoger tu pedido en nuestra tienda.</p>
        <p><strong>Horario de atención:</strong> Lunes a Sábado de 9:00 am a 7:00 pm</p>
        <p><strong>Dirección:</strong> [Dirección de tu tienda]</p>

        <p>Recuerda traer tu documento de identidad o mostrar este correo para una atención rápida.</p>
    </div>

    <div class="footer">
        <p>Atentamente,<br><strong>Equipo Linhs Llantas</strong></p>
        <p>Si tienes alguna duda, contáctanos al: [Teléfono de contacto]</p>
    </div>
</body>

</html>
