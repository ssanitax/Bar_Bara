<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restaurante Digital</title>
    <style>
        nav { background: #333; padding: 10px; color: white; }
        nav a { color: white; margin-right: 15px; text-decoration: none; }
        .container { padding: 20px; font-family: sans-serif; }
    </style>
</head>
<body>
<nav>
    <a href="index.php">Inicio</a>
    <a href="catalogo.php">Carta/Menú</a>
    <a href="carrito.php">Carrito (<?php echo isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>)</a>
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="logout.php">Cerrar Sesión</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="signup.php">Registro</a>
    <?php endif; ?>
</nav>
<div class="container">