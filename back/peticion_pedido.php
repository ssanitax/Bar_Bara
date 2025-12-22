<?php
require_once 'inc/conexion_bd.php';
require_once 'controladores/PedidoControlador.php';
header("Content-Type: application/json");
$datos = json_decode(file_get_contents("php://input"), true);
$controlador = new PedidoControlador($pdo);
$accion = $_GET['accion'] ?? '';

if ($accion === 'crear') {
    $id = $controlador->crearNuevoPedido($datos);
    echo json_encode(["status" => "creado", "pedido_id" => $id]);
} elseif ($accion === 'cuenta') {
    $controlador->solicitarCuenta($datos['pedido_id']);
    echo json_encode(["status" => "cuenta_solicitada"]);
}
