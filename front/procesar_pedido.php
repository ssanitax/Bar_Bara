<?php
session_start();
require_once '../back/inc/conexion_bd.php';
require_once '../back/controladores/PedidoControlador.php';

// Si no hay sesión, mandamos al usuario a registrarse/loguearse
if (!isset($_SESSION['user_id'])) {
    header("Location: registro.php");
    exit;
}

if (isset($_POST['confirmar_pedido']) && !empty($_SESSION['carrito'])) {
    $pedidoCtrl = new PedidoControlador($pdo);

    $datosPedido = [
        'usuario_id'  => $_SESSION['user_id'],
        'numero_mesa' => $_POST['numero_mesa'],
        'total'       => $_POST['total_pagar'],
        'productos'   => []
    ];

    foreach ($_SESSION['carrito'] as $item) {
        $datosPedido['productos'][] = [
            'producto_id' => $item['id'],
            'cantidad'    => $item['cantidad'],
            'subtotal'    => $item['precio'] * $item['cantidad']
        ];
    }

    try {
        $idPedido = $pedidoCtrl->crearNuevoPedido($datosPedido);
        unset($_SESSION['carrito']); // Vaciamos carrito tras éxito
        header("Location: finalizacion.php?finalizado=" . $idPedido);
        exit;
    } catch (Exception $e) {
        die("Error al guardar el pedido: " . $e->getMessage());
    }
} else {
    header("Location: catalogo.php");
    exit;
}
