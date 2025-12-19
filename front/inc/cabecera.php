<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bar Bara - Nuestra Carta</title>
    <style>
        body { margin: 0; font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f4f4; }
        
        /* Estilos del Header */
        header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        
        .logo { font-size: 1.8rem; font-weight: bold; color: #f1c40f; text-decoration: none; }
        
        .menu { display: flex; list-style: none; gap: 20px; margin: 0; padding: 0; }
        
        .menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .menu a:hover { color: #f1c40f; }

        .btn-carrito {
            background-color: #e67e22;
            padding: 8px 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>
<body>

<header>
    <nav class="nav-container">
        <a href="index.php" class="logo">🍸 BAR BARA</a>
        <ul class="menu">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="catalogo.php">Carta</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            <li>
                <a href="carrito.php" class="btn-carrito">
                    🛒 Mi Pedido
                </a>
            </li>
        </ul>
    </nav>
</header>
