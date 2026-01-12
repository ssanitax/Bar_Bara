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
            
            /* Esto es vital para que el logo se posicione respecto a la barra */
            position: relative; 
            z-index: 10;
            border-bottom: 4px solid #eaa833;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        /* --- AQUÍ ESTÁ EL CAMBIO PARA FIJAR EL LOGO --- */
        .logo-superpuesto {
            position: absolute;
            /* Coordenadas Fijas: Siempre estará aquí */
            top: -30px; 
            left: 20px; 
            z-index: 100; 
        }

        .logo-superpuesto img {
            /* TAMAÑO FIJO EN PÍXELES (Ya no cambia 'a lo loco') */
            height: 160px; 
            width: auto;
            display: block;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.5));
            transition: all 0.3s ease; /* Suavidad si cambiamos de tamaño */
        }

        /* --- MODO TELÉFONO (Pantallas pequeñas) --- */
        @media (max-width: 768px) {
            /* En móvil, ajustamos un poco para que no sea gigante, pero se mantiene fijo */
            .logo-superpuesto img {
                height: 120px; 
            }
            .logo-superpuesto {
                top: -15px; /* Lo subimos un poco menos */
                left: 15px; /* Un poco más pegado al borde */
            }
            
            /* Opcional: Si en móvil prefieres el menú más compacto */
            .header-azul {
                padding: 0 15px;
            }
        }
        /* ----------------------------------------------- */

        .menu-lista {
            display: flex;
            list-style: none;
            gap: 25px;
            align-items: center;
            margin: 0; padding: 0; /* Limpieza de estilos por defecto */
        }

        .menu-lista a {
            color: #f8f1e0;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9rem; /* Tamaño legible */
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
        .btn-pedido:hover { transform: scale(1.05); }

        .badge {
            background: white;
            color: #c93b2b;
            padding: 2px 6px;
            border-radius: 50%;
            font-size: 0.85em;
            font-weight: bold;
        }

        .user-welcome { color: #eaa833; font-weight: bold; margin-right: 5px; }
        
        /* Ajuste para que el menú no se rompa en pantallas MUY pequeñas */
        @media (max-width: 600px) {
            .menu-lista { gap: 10px; }
            .ocultar-movil { display: none; } /* Úsalo si quieres ocultar el texto "Hola..." */
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
        <li>
            <a href="carrito.php" class="btn-pedido">
                🛒 <span class="badge"><?php echo $cantidad_total; ?></span>
            </a>
        </li>
        <?php if ($usuario_conectado): ?>
            <li><span class="user-welcome">Hola, <?php echo htmlspecialchars($nombre_usuario); ?></span></li>
            <li><a href="logout.php" style="font-size: 0.8rem; border: 1px solid white; padding: 5px; border-radius: 5px;">Salir</a></li>
        <?php else: ?>
            <li><a href="login.php">👤 Entrar</a></li>
        <?php endif; ?>
    </ul>
</header>

<div style="margin-top: -100px; padding: 20px; min-height: 80vh;">
