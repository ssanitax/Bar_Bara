<?php
// Si la sesión no está iniciada, la iniciamos
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lógica del carrito
$cantidad_total = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $producto) {
        $cantidad_total += $producto['cantidad'];
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
        }
    </style>
</head>
<body>

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