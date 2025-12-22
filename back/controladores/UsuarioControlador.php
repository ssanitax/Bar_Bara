<?php
// controladores/UsuarioControlador.php

class UsuarioControlador {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function registrar($datos) {
        // Encriptamos la contraseña para seguridad
        $passwordSegura = password_hash($datos['contrasea'], PASSWORD_BCRYPT);
        
        $sql = "INSERT INTO usuario (nombre_usuario, apellidos, correo, contrasea) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['nombre_usuario'], 
            $datos['apellidos'], 
            $datos['correo'], 
            $passwordSegura
        ]);
    }

    public function login($correo, $password) {
        $sql = "SELECT * FROM usuario WHERE correo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['contrasea'])) {
            return $usuario; // Login exitoso
        }
        return false;
    }
}
