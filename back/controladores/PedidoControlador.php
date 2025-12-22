<?php
// controladores/PedidoControlador.php

class PedidoControlador {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function crearNuevoPedido($datos) {
        // 1. Insertamos en la tabla pedido
        // Usamos fecha y hora del servidor y el campo pedir_cuenta en 'NO' por defecto
        $sqlPedido = "INSERT INTO pedido (usuario_id, numero_mesa, fecha, hora, total, pedir_cuenta) 
                      VALUES (?, ?, CURDATE(), CURTIME(), ?, 'NO')";
        
        $stmt = $this->db->prepare($sqlPedido);
        $stmt->execute([
            $datos['usuario_id'], 
            $datos['numero_mesa'], 
            $datos['total']
        ]);
        
        $idPedido = $this->db->lastInsertId();

        // 2. Insertamos cada producto en la tabla contenido_pedido
        foreach ($datos['productos'] as $item) {
            $sqlContenido = "INSERT INTO contenido_pedido (pedido_id, producto_id, cantidad, subtotal) 
                             VALUES (?, ?, ?, ?)";
            $stmtDetalle = $this->db->prepare($sqlContenido);
            $stmtDetalle->execute([
                $idPedido, 
                $item['producto_id'], 
                $item['cantidad'], 
                $item['subtotal']
            ]);
        }

        return $idPedido;
    }

    public function solicitarCuenta($idPedido) {
        // Actualizamos el campo pedir_cuenta a 'SI' para avisar al camarero
        $sql = "UPDATE pedido SET pedir_cuenta = 'SI' WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idPedido]);
    }
}
