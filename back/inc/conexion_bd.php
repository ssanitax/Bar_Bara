<?php
$host = 'localhost';
$db   = 'Bar_Bara';
$user = 'admin_bara';
$pass = 'BarBara_2025$';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
     $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (\PDOException $e) {
     die("Error de conexión: " . $e->getMessage());
}
session_start();
?>