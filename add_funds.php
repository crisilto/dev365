<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['id'])) {
    header('Location: login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount']);
    $user_id = $_SESSION['id'];

    if ($amount > 0) {
        $query = "UPDATE usuarios SET monedero = monedero + ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $conn->error);
        }
        $stmt->bind_param("di", $amount, $user_id);
        $stmt->execute();
        $_SESSION['monedero'] += $amount;
        header('Location: home.php');
        exit();
    } else {
        $error = "Por favor, ingresa una cantidad válida.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Fondos - dev365</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="nav-superior">
            <ul class="ul-izquierda">
                <li>Deportes</li>
                <li>Casino</li>
                <li>Casino en Directo</li>
                <li>Tragaperras</li>
                <li>Póquer</li>
                <li>Extra</li>
            </ul>
            <ul class="ul-derecha">
                <li>Juego más seguro</li>
                <li>Ayuda</li>
            </ul>
        </nav>
        <nav class="nav-inferior">
            <div class="site-logo">
                <a href="home.php"><img src="imgs/logo.PNG" alt="logo" id="logo"></a>
            </div>
            <ul>
                <li>Deportes</li>
                <li>Directo</li>
            </ul>
            <ul>
                <div class="search-container">
                    <input type="text" placeholder="Buscar...">
                </div>

                <div class="login-container">
                    <?php if (isset($_SESSION['id'])) : ?>
                        <button onclick="window.location.href='logout.php'">Cerrar sesión</button>
                    <?php else : ?>
                        <button onclick="window.location.href='register.html'">Registrarse</button>
                        <button onclick="window.location.href='login.html'">Iniciar sesión</button>
                    <?php endif; ?>
                </div>
            </ul>
        </nav>
    </header>

    <main>
        <div class="welcome-container">
            <h1>Añadir Fondos</h1>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="post" action="add_funds.php">
                <label for="amount">Cantidad:</label>
                <input type="number" id="amount" name="amount" min="0" step="0.01" required>
                <button type="submit">Añadir</button>
            </form>
        </div>
    </main>
</body>
</html>
