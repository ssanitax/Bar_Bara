<?php 
// 1. Datos de conexión
$servidor = "localhost"; // En lugar de "localhost"
$base_datos = "Bar_Bara";
$usuario = "admin_bara";    
$password = "BarBara_2025$"; 

try {
    $dsn = "mysql:host=$servidor;dbname=$base_datos;charset=utf8mb4";
    $pdo = new PDO($dsn, $usuario, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Error crítico: " . $e->getMessage());
}

// 2. Cargamos la cabecera que acabamos de crear
include 'cabecera.php'; 
?>
