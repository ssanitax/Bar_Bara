<?php
require_once 'inc/conexion_bd.php';
require_once 'controladores/UsuarioControlador.php';
header("Content-Type: application/json");
$datos = json_decode(file_get_contents("php://input"), true);
$controlador = new UsuarioControlador($pdo);
$usuario = $controlador->login($datos['correo'], $datos['pass']);
echo json_encode($usuario ? ["exito" => true, "id" => $usuario['id']] : ["exito" => false]);
