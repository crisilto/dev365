<?php
session_start();
header('Content-Type: application/json');

require '../db_connection.php';

$user_id = $_SESSION['id']; 

$query = "SELECT monedero FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    echo json_encode(['error' => 'Error en la preparación de la consulta: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row === null) {
    echo json_encode(['error' => 'Usuario no encontrado']);
    exit;
}

echo json_encode(['monedero' => $row['monedero']]);
?>
