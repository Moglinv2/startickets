<?php
session_start();

// Incluir archivo de configuración
include 'config.php';

// Procesar el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para obtener los detalles del usuario
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verificar las credenciales
    if ($user && password_verify($password, $user['password'])) {
        // Guardar datos del usuario en la sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        // Redirigir a la página de bienvenida
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Email o contraseña incorrectos.";
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://c1.wallpaperflare.com/preview/570/413/91/interior-theatre-theater-empty-theater.jpg');
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
        }
    </style>
</head>
<body class="flex items-center justify-center">
    <div class="overlay"></div>
    <form action="login.php" method="POST" class="form-container p-8 shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center">Iniciar Sesión</h2>
        <?php if (isset($error_message)): ?>
            <div class="bg-red-600 p-2 rounded mb-4 text-center"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <label for="email" class="block mb-2">Email</label>
        <input type="email" id="email" name="email" class="w-full p-2 mb-4 rounded bg-gray-800 border border-gray-700 focus:border-red-500 focus:ring-2 focus:ring-red-500" required>
        <label for="password" class="block mb-2">Contraseña</label>
        <input type="password" id="password" name="password" class="w-full p-2 mb-4 rounded bg-gray-800 border border-gray-700 focus:border-red-500 focus:ring-2 focus:ring-red-500" required>
        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 p-2 rounded text-white">Iniciar Sesión</button>
        <p class="mt-4 text-center">¿No tienes una cuenta? <a href="registro.php" class="text-red-400 hover:underline">Regístrate</a></p>
    </form>
</body>
</html>
