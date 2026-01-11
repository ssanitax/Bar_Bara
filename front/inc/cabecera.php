<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cantidad_total = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $producto) {
        $cantidad_total = $cantidad_total + $producto['cantidad'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bar Bara</title>
    <style>
        /* CSS puro, sin etiquetas PHP dentro para evitar el Parse Error */
        body { 
            margin: 0; 
            font-family: sans-serif; 
            background-color: #f4f4f4; 
        }
        
        .barra-azul {
            background-color: #2c3e50;
            height: 80px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 50px;
            position: relative;
            z-index: 10;
        }

        .contenedor-logo {
            position: relative;
            width: 180px;
            height: 80px;
        }

        .contenedor-logo img {
            position: absolute;
            top: -20px;
            left: 0;
            height: 180px; /* Logo grande */
            width: auto;
            z-index: 100;
        }

        .menu-navegacion {
            display: flex;
            list-style: none;
            gap: 20px;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        .menu-navegacion a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .boton-pedido {
            background-color: #e67e22;
            padding: 10px 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none;
        }

        .circulo-cantidad {
            background: white;
            color: #e67e22;
            padding: 2px 8px;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<header class="barra-azul">
    <div class="contenedor-logo">
        <a href="index.php">
            <img src="img/ChatGPT_Image_11_ene_2026__17_05_50-removebg-preview.png" alt="Logo">
        </a>
    </div>

    <ul class="menu-navegacion">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="catalogo.php">Carta</a></li>
        <li><a href="contacto.php">Contacto</a></li>
        <li>
            <a href="carrito.php" class="boton-pedido">
                🛒 Mi Pedido 
                <span class="circulo-cantidad"><?php echo $cantidad_total; ?></span>
            </a>
        </li>
    </ul>
</header>

<div style="margin-top: 40px; padding: 20px;">
