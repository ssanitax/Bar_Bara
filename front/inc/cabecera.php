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

$usuario_conectado = isset($_SESSION['user_id']);
$nombre_usuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Cliente';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bar Bara</title>
    <style>
        body { margin: 0; font-family: sans-serif; background-color: #f8f1e0; }
        
        .header-azul {
            background-color: #153e5c;
            height: 90px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: flex-end; 
            padding: 0 5%;
            position: relative;
            z-index: 10;
            border-bottom: 4px solid #eaa833;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .logo-superpuesto {
            position: absolute;
            top: -30px; 
            left: 20px;
            z-index: 100; 
        }

        .logo-superpuesto img {
            height: 160px;
            width: auto;
            display: block;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.5));
            transition: all 0.3s ease;
        }

        .menu-lista {
            display: flex;
            list-style: none;
            gap: 20px;
            align-items: center;
            margin: 0; padding: 0;
        }

        .menu-lista a {
            color: #f8f1e0;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .btn-pedido {
            background-color: #c93b2b;
            padding: 8px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: white !important;
            transition: transform 0.2s;
        }

        .badge {
            background: white;
            color: #c93b2b;
            padding: 2px 6px;
            border-radius: 50%;
            font-size: 0.85em;
            font-weight: bold;
        }

        .user-welcome { color: #eaa833; font-weight: bold; margin-right: 5px; }
        
        @media (max-width: 768px) {
            .logo-superpuesto img { height: 110px; }
            .logo-superpuesto { top: -15px; left: 10px; }
            .menu-lista { gap: 12px; }
            .ocultar-movil { display: none; }
        }
    </style>
</head>
<body>

<header class="header-azul">
    <div class="logo-superpuesto">
        <a href="index.php">
            <img src="img/ChatGPT_Image_11_ene_2026__17_05_50-removebg-preview.png" alt="Logo Bar Bara">
        </a>
    </div>

    <ul class="menu-lista">
        <li><a href="catalogo.php">Carta</a></li>
        
        <?php if ($usuario_conectado): ?>
            <li><a href="historial.php">Historial</a></li>
            <li><span class="user-welcome ocultar-movil">Hola, <?php echo htmlspecialchars($nombre_usuario); ?></span></li>
        <?php endif; ?>

        <li>
            <a href="carrito.php" class="btn-pedido">
                🛒 <span class="badge"><?php echo $cantidad_total; ?></span>
            </a>
        </li>

        <?php if ($usuario_conectado): ?>
            <li><a href="logout.php" style="font-size: 0.75rem; border: 1px solid white; padding: 4px; border-radius: 5px;">Salir</a></li>
        <?php else: ?>
            <li><a href="login.php">👤 Entrar</a></li>
        <?php endif; ?>
    </ul>
</header>

<div style="margin-top: 50px; padding: 20px; min-height: 80vh;">
