<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dev365";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$contraseña = $_POST['contraseña'];
$monedero = 1000.00;

$hashed_password = password_hash($contraseña, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, contraseña, monedero) VALUES ('$nombre', '$hashed_password', $monedero)";

if ($conn->query($sql) === TRUE) {
    echo "Registro exitoso. <a href='login.html'>Inicia sesión aquí</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
