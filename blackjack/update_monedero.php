<?php
require '../db_connection.php';
session_start();

if (!isset($_SESSION['id'])) {
    die(json_encode(['success' => false, 'message' => 'Usuario no autenticado']));
}

$user_id = $_SESSION['id'];
$new_monedero = $_POST['monedero'];

$query = "UPDATE usuarios SET monedero = ? WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die(json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error]));
}

$stmt->bind_param("di", $new_monedero, $user_id);
$success = $stmt->execute();

if ($success) {
    $_SESSION['monedero'] = $new_monedero;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error en la actualización del monedero']);
}
?>
