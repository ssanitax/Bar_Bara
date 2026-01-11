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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bar Bara</title>
    <style>
        body { margin: 0; font-family: sans-serif; background-color: #f4f4f4; }
        
        .header-azul {
            background-color: #2c3e50;
            height: 90px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            position: relative;
            z-index: 1000;
        }

        .logo-contenedor {
            position: relative;
            width: 250px;
            height: 90px;
        }

        /* LOGO ADAPTABLE Y MUY GRANDE */
        .logo-contenedor img {
            position: absolute;
            top: -20px;
            left: 0;
            height: 270px; /* Tamaño máximo en escritorio */
            width: auto;
            z-index: 2000;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.5));
        }

        .menu-lista {
            display: flex;
            list-style: none;
            gap: 20px;
            align-items: center;
        }

        .menu-lista a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-pedido {
            background-color: #e67e22;
            padding: 10px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none;
        }

        .badge {
            background: white;
            color: #e67e22;
            padding: 2px 8px;
            border-radius: 50%;
        }

        /* Ajustes para tablets */
        @media (max-width: 992px) {
            .logo-contenedor img { height: 180px; }
            .logo-contenedor { width: 180px; }
        }

        /* Ajustes para móviles */
        @media (max-width: 600px) {
            .header-azul { height: 70px; }
            .logo-contenedor { width: 100px; height: 70px; }
            .logo-contenedor img { height: 120px; top: -10px; }
            .menu-lista { gap: 10px; }
            .menu-lista a { font-size: 0.8rem; }
        }
    </style>
</head>
<body>

<header class="header-azul">
    <div class="logo-contenedor">
        <a href="index.php">
            <img src="img/ChatGPT_Image_11_ene_2026__17_05_50-removebg-preview.png" alt="Logo Bar Bara">
        </a>
    </div>

    <ul class="menu-lista">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="catalogo.php">Carta</a></li>
        <li>
            <a href="carrito.php" class="btn-pedido">
                🛒 <span class="badge"><?php echo $cantidad_total; ?></span>
            </a>
        </li>
    </ul>
</header>

<div style="margin-top: 50px; padding: 20px;">
