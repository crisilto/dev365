<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackjack - dev365</title>
    <link rel="stylesheet" href="blackjack.css">
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
                <a href="../home.php"> <img src="../imgs/logo.PNG" alt="logo" id="logo"></a>
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
                    <button onclick="window.location.href='../register.html'">Registrarse</button>
                    <button onclick="window.location.href='../login.html'">Iniciar sesión</button>
                </div>
            </ul>
        </nav>
    </header>

    <main>
        <div class="welcome-container">
            <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?></h2>
            <p>Saldo de tu monedero: <span id="monedero"><?php echo $_SESSION['monedero']; ?></span> monedas</p>
            <button onclick="window.location.href='../add_funds.php'" id="add-funds-btn">Añadir Fondos</button>
        </div>
        <div id="game-container">
            <h3>Blackjack</h3>
            <div class="columns">
                <div class="column">
                    <h4>BANCA</h4>
                    <p id="dealer-cards-el">Cartas:</p>
                    <p id="sum-dealer-el">Suma:</p>
                </div>
                <div class="column">
                    <h4>TÚ</h4>
                    <p id="cards-el">Cartas:</p>
                    <p id="sum-el">Suma:</p>
                </div>
            </div>
            <div class="button-container">
                <button id="bet-btn">Fijar Apuesta</button>
                <button id="start-btn">Jugar Ronda</button>
                <button id="card-btn">Nueva Carta</button>
                <button id="stand-btn">Plantarse</button>
                <button id="restart-btn" class="full-width-button">Reiniciar</button>
                <input id="bet-amount" type="text" placeholder="Introduzca su apuesta">
            </div>
            <div id="message-el">¿Quieres jugar una ronda?</div>
        </div>
    </main>
    <script>
        let userMonedero = <?php echo json_encode(floatval($_SESSION['monedero'])); ?>;
        const userId = <?php echo json_encode($_SESSION['id']); ?>;
    </script>
    <script src="script.js"></script>

</body>

</html>
