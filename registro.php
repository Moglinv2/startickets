<?php
// Incluir archivo de configuración
include 'config.php';

// Inicializar variables
$registration_success = false;
$registration_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Consulta SQL
    $sql = "INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)";

    // Preparar la consulta
    if ($stmt = $conn->prepare($sql)) {
        // Vincular parámetros
        $stmt->bind_param("sss", $username, $email, $password);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $registration_success = true;
        } else {
            $registration_error = 'Error al ejecutar consulta: ' . $stmt->error;
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        $registration_error = 'Error al preparar consulta: ' . $conn->error;
    }

    // Cerrar conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://assets.nflxext.com/ffe/siteui/vlv3/655a9668-b002-4262-8afb-cf71e45d1956/a681d319-3640-4aa4-827a-41bc6473ea25/DO-es-20240715-POP_SIGNUP_TWO_WEEKS-perspective_WEB_8cf609ae-ff01-4360-9070-eef5545e4b1a_small.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #fff;
            height: 100vh;
            margin: 0;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8));
            z-index: 1;
        }
        .form-container {
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            position: relative;
            z-index: 2;
            padding: 2rem;
        }
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.9);
            color: #fff;
            padding: 2rem;
            border-radius: 10px;
            z-index: 3;
        }
        .modal.active {
            display: block;
        }
        .modal button {
            background-color: #e50914;
            border: none;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
        }
        .modal button:hover {
            background-color: #f40612;
        }
    </style>
</head>
<body class="flex items-center justify-center">
    <div class="overlay"></div>
    <form action="registro.php" method="POST" class="form-container shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center">Registro</h2>
        <label for="username" class="block mb-2">Nombre de Usuario</label>
        <input type="text" id="username" name="username" class="w-full p-2 mb-4 rounded bg-gray-800 border border-gray-700 focus:border-red-500 focus:ring-2 focus:ring-red-500" required>
        <label for="email" class="block mb-2">Email</label>
        <input type="email" id="email" name="email" class="w-full p-2 mb-4 rounded bg-gray-800 border border-gray-700 focus:border-red-500 focus:ring-2 focus:ring-red-500" required>
        <label for="password" class="block mb-2">Contraseña</label>
        <input type="password" id="password" name="password" class="w-full p-2 mb-4 rounded bg-gray-800 border border-gray-700 focus:border-red-500 focus:ring-2 focus:ring-red-500" required>
        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 p-2 rounded text-white">Registrarse</button>
        <p class="mt-4 text-center">¿Ya tienes una cuenta? <a href="login.php" class="text-red-400 hover:underline">Inicia sesión</a></p>
    </form>

    <!-- Modal -->
    <?php if ($registration_success): ?>
    <div class="modal active" id="successModal">
        <h3 class="text-xl font-bold mb-4">Registro Exitoso!</h3>
        <p>Tu registro ha sido exitoso. Ahora puedes iniciar sesión.</p>
        <button onclick="window.location.href='login.php'">Aceptar</button>
    </div>
    <?php elseif ($registration_error): ?>
    <div class="modal active" id="errorModal">
        <h3 class="text-xl font-bold mb-4">Error!</h3>
        <p><?php echo htmlspecialchars($registration_error); ?></p>
        <button onclick="window.location.href='registro.php'">Aceptar</button>
    </div>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Redirigir automáticamente después de cerrar el modal de éxito
            if (document.getElementById('successModal')) {
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 3000); // Redirige después de 3 segundos
            }
        });
    </script>
</body>
</html>
