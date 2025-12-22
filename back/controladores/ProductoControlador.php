<?php
// controladores/ProductoControlador.php

class ProductoControlador {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function listarTodo() {
        // Obtenemos todos los campos: nombre, precio, descripción, categoria e imagen
        $sql = "SELECT * FROM producto";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM producto WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
