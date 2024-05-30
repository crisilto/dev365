<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['nombre'];
    $password = $_POST['contraseña'];

    $query = "SELECT id, nombre, contraseña FROM usuarios WHERE nombre = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['contraseña'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['monedero'] = $user['monedero'];
        header('Location: home.php'); 
        exit();
    } else {
        $error = "Nombre de usuario o contraseña incorrectos";
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="login.php" method="POST">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Iniciar sesión</button>
    </form>
</body>

</html>