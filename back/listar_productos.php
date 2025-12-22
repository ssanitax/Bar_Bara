<?php
require_once 'inc/conexion_bd.php';
require_once 'controladores/ProductoControlador.php';
header("Content-Type: application/json");
$controlador = new ProductoControlador($pdo);
echo json_encode($controlador->listarTodo());
