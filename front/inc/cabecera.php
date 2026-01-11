<?php
<<<<<<< HEAD
// Si la sesión no está iniciada, la iniciamos
=======
>>>>>>> 996cf9f6a9387727732e77f926ecafa7d50e84e0
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

<<<<<<< HEAD
// Lógica del carrito
=======
>>>>>>> 996cf9f6a9387727732e77f926ecafa7d50e84e0
$cantidad_total = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $producto) {
        $cantidad_total = $cantidad_total + $producto['cantidad'];
    }
}

// Detectamos si hay usuario
$usuario_conectado = isset($_SESSION['user_id']);
$nombre_usuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Cliente';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Bar Bara - Carácter & Sabor</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        /* Estilos inline críticos para la estructura del menú */
        body { margin: 0; padding-top: 80px; /* Espacio para el header fijo */ }
        
        header {
            position: fixed; top: 0; left: 0; width: 100%; z-index: 1000;
            background-color: var(--color-navy, #153e5c); /* Fallback */
            border-bottom: 4px solid var(--color-mustard, #eaa833);
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        
        .nav-container {
            max-width: 1200px; margin: 0 auto; padding: 0 20px;
            display: flex; justify-content: space-between; align-items: center;
            height: 70px;
        }
        
        .logo { 
            font-size: 1.5rem; font-weight: 900; color: var(--color-mustard, #eaa833); 
            text-decoration: none; text-transform: uppercase; letter-spacing: 2px;
            text-shadow: 2px 2px 0 #000;
        }
        
        .menu { display: flex; list-style: none; gap: 20px; margin: 0; padding: 0; align-items: center; }
        
        .menu a {
            color: var(--color-cream, #f8f1e0); text-decoration: none; font-weight: 600;
            font-size: 0.95rem; text-transform: uppercase; transition: color 0.3s;
        }
        
        .menu a:hover { color: var(--color-mustard, #eaa833); }

        .btn-carrito {
            background-color: var(--color-red, #c93b2b); padding: 8px 15px; border-radius: 20px;
            display: flex; align-items: center; gap: 8px; transition: transform 0.2s;
        }
        .btn-carrito:hover { transform: scale(1.05); }
        
        .badge {
            background: white; color: var(--color-red, #c93b2b); 
            padding: 2px 6px; border-radius: 50%; font-size: 0.8em; font-weight: bold;
        }

        /* Estilos para usuario */
        .user-welcome { color: var(--color-mustard, #eaa833) !important; cursor: default; }
        .btn-logout { border: 1px solid var(--color-red); padding: 5px 10px; border-radius: 5px; font-size: 0.8rem !important; }
        .btn-logout:hover { background: var(--color-red); color: white !important; }

        @media (max-width: 768px) {
            .menu { gap: 10px; }
            .ocultar-movil { display: none; }
=======
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
>>>>>>> 996cf9f6a9387727732e77f926ecafa7d50e84e0
        }
    </style>
</head>
<body>

<<<<<<< HEAD
<header>
    <nav class="nav-container">
        <a href="index.php" class="logo">BAR BARA</a>
        <ul class="menu">
            <li><a href="catalogo.php">Carta</a></li>
            
            <li>
                <a href="carrito.php" class="btn-carrito">
                    🛒 <span class="ocultar-movil">Pedido</span>
                    <?php if($cantidad_total > 0): ?>
                        <span class="badge"><?= $cantidad_total ?></span>
                    <?php endif; ?>
                </a>
            </li>

            <?php if ($usuario_conectado): ?>
                <li><span class="user-welcome ocultar-movil">Hola, <?= htmlspecialchars($nombre_usuario) ?></span></li>
                <li><a href="logout.php" class="btn-logout">Salir</a></li>
            <?php else: ?>
                <li><a href="login.php" style="border-bottom: 2px solid var(--color-cream);">👤 Entrar</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
=======
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
>>>>>>> 996cf9f6a9387727732e77f926ecafa7d50e84e0
