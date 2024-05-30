<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'No se ha iniciado sesión']);
    exit;
}

header('Content-Type: application/json');

$usuario_id = $_SESSION['usuario_id'];
$action = $_POST['action'];

switch ($action) {
    case 'placeBet':
        $betAmount = floatval($_POST['betAmount']);
        $currentBalance = obtenerSaldo($conn, $usuario_id);

        if ($currentBalance >= $betAmount) {
            $newBalance = $currentBalance - $betAmount;
            actualizarMonedero($conn, $usuario_id, $newBalance);
            $_SESSION['monedero'] = $newBalance;
            echo json_encode(['success' => true, 'newBalance' => $newBalance]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Fondos insuficientes']);
        }
        break;

    case 'spinWheel':
        $result = rand(0, 36);
        echo json_encode(['success' => true, 'result' => $result]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Acción no reconocida']);
        break;
}

function obtenerSaldo($conn, $usuario_id) {
    $stmt = $conn->prepare("SELECT monedero FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['monedero'];
    }
    return false;
}

function actualizarMonedero($conn, $usuario_id, $nuevoSaldo) {
    $stmt = $conn->prepare("UPDATE usuarios SET monedero = ? WHERE id = ?");
    $stmt->bind_param("di", $nuevoSaldo, $usuario_id);
    $stmt->execute();
}
?>
