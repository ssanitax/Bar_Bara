<?php
// controladores/PedidoControlador.php

class PedidoControlador {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function crearNuevoPedido($datos) {
        // El pedido nace con pedir_cuenta = 'NO' (Pendiente de servir)
        $sqlPedido = "INSERT INTO pedido (usuario_id, numero_mesa, fecha, hora, total, pedir_cuenta) 
                      VALUES (?, ?, CURDATE(), CURTIME(), ?, 'NO')";
        $stmt = $this->db->prepare($sqlPedido);
        $stmt->execute([
            $datos['usuario_id'], 
            $datos['numero_mesa'], 
            $datos['total']
        ]);
        $idPedido = $this->db->lastInsertId();

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

    public function marcarComoEntregado($idPedido) {
        // Cambiamos el estado a ENTREGADO para que desaparezca de la lista de cocina
        $sql = "UPDATE pedido SET pedir_cuenta = 'ENTREGADO' WHERE id = ?";
        return $this->db->prepare($sql)->execute([$idPedido]);
    }

    public function solicitarCuenta($idPedido) {
        $sql = "UPDATE pedido SET pedir_cuenta = 'SI' WHERE id = ?";
        return $this->db->prepare($sql)->execute([$idPedido]);
    }

    // NUEVA FUNCIÓN: Marca como PAGADO para limpiar el historial del cliente
    public function marcarComoPagado($idPedido) {
        $sql = "UPDATE pedido SET pedir_cuenta = 'PAGADO' WHERE id = ?";
        return $this->db->prepare($sql)->execute([$idPedido]);
    }
}
