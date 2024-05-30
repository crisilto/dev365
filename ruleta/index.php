<?php
session_start();

if (!isset($_SESSION['id'])) {
    die('Usuario no autenticado');
}

require '../db_connection.php'; 

$user_id = $_SESSION['id']; 

$query = "SELECT monedero FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('Error en la preparación de la consulta: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row === null) {
    die('Usuario no encontrado');
}

$_SESSION['monedero'] = $row['monedero'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruleta - dev365</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
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
        <div id="game-container"></div>
    </main>
    <script src="script.js"></script>
</body>

</html>