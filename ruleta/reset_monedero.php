<?php
session_start();
header('Content-Type: application/json');

$_SESSION['monedero'] = 1000;

$response = array('monedero' => $_SESSION['monedero']);
echo json_encode($response);
?>
