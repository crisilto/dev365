<?php
session_start();
require 'db_connection.php';

$nombre_usuario = "Invitado";
$monedero = 0; 

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $nombre_usuario = $_SESSION['nombre'];

    $query = "SELECT monedero FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row !== null) {
        $_SESSION['monedero'] = $row['monedero'];
        $monedero = $row['monedero'];
    } else {
        session_destroy();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - dev365</title>
    <link rel="stylesheet" href="home.css">
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
    <aside>
        <h2>Populares</h2>
        <ul>
            <li>1ª División</li>
            <li>2ª División</li>
            <li>ACB</li>
        </ul>
        <h2>Visitado con Frecuencia</h2>
        <ul>
            <li>Fútbol</li>
            <li>Tenis</li>
            <li>Baloncesto</li>
            <li>eSports</li>
            <li>Fútbol americano</li>
        </ul>
        <h2>Lista Completa</h2>
        <ul>
            <li>Baloncesto</li>
            <li>Balonmano</li>
            <li>Béisbol</li>
            <li>Boxeo</li>
            <li>Carreras de caballos</li>
            <li>Carreras de galgos</li>
            <li>Casino</li>
            <li>Ciclismo</li>
            <li>Dardos</li>
            <li>Deportes de invierno</li>
            <li>Esquí alpino</li>
            <li>Esquí de fondo</li>
            <li>Saltos de esquí</li>
            <li>Especiales</li>
        </ul>
    </aside>
    <main>
        <div id="welcome-container">
            <h1>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></h1>
            <p>Saldo de tu monedero: <?php echo number_format($monedero, 2); ?> monedas</p>
            <?php if (isset($_SESSION['id'])) : ?>
                <button onclick="window.location.href='add_funds.php'" id="add-funds-btn">Añadir Fondos</button>
            <?php else : ?>
                <button onclick="window.location.href='login.html'" id="add-funds-btn">Iniciar sesión para añadir fondos</button>
            <?php endif; ?>
        </div>
        <div class="games">
            <div class="game" onclick="window.location.href='blackjack/index.php'">
                <img src="imgs/blackjack.png" alt="Blackjack">
                <p>Blackjack</p>
            </div>
            <div class="game" onclick="window.location.href='ruleta/index.php'">
                <img src="imgs/ruleta.png" alt="Ruleta">
                <p>Ruleta</p>
            </div>
        </div>
    </main>
</body>

</html>
