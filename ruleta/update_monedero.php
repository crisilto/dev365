<?php
session_start();
require '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id']; 
    $monedero = $_POST['monedero'];

    $query = "UPDATE usuarios SET monedero = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
    $stmt->bind_param("di", $monedero, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo actualizar el monedero']);
    }
}
?>

