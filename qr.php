<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Mazyar">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Factura de Cine</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>

<body class="bg-gray-900 text-gray-200 flex justify-center items-center h-screen">

    <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
        <!-- Código QR -->
        <div class="flex justify-center mb-6">
            <div id="qrcode" class="w-32 h-32 bg-gray-800 p-2 rounded"></div>
        </div>

        <!-- Cabecera -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold">Factura de Cine</h1>
            <p class="text-gray-300">Compra realizada el <span id="date">01/01/2024</span></p>
        </div>

        <!-- Cuerpo de la Factura -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4 border-b border-gray-600 pb-2">Resumen de la Compra</h2>
            <p class="mb-2"><strong>Película:</strong> <span id="movie-title">Nombre de la película</span></p>
            <p class="mb-2"><strong>Cantidad de Boletos:</strong> <span id="ticket-quantity">3</span></p>
            <p class="mb-4"><strong>Precio por Boleto:</strong> <span id="ticket-price">$8.00</span></p>
            
            <hr class="border-gray-600 my-4">

            <p class="mb-2"><strong>Subtotal:</strong> <span id="subtotal">$24.00</span></p>
            <p class="mb-2"><strong>ITBIS (18%):</strong> <span id="tax">$4.32</span></p>
            <p class="text-lg font-semibold"><strong>Total:</strong> <span id="total">$28.32</span></p>
        </div>

        <!-- Pie de Página -->
        <div class="text-center">
            <p>Gracias por su compra. ¡Disfrute de la película!</p>
        </div>
    </div>

    <!-- Generar Código QR -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const qrCodeContainer = document.getElementById('qrcode');
            new QRCode(qrCodeContainer, {
                text: "https://example.com/your-unique-link", // URL o texto que quieras codificar
                width: 100,
                height: 100,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        });
    </script>
</body>

</html>
