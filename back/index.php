<?php
// index.php en la raíz
require_once 'inc/conexion_bd.php';
require_once 'controladores/PedidoControlador.php';
require_once 'controladores/ProductoControlador.php';

try {
    $productoCtrl = new ProductoControlador($pdo);
    $totalProductos = count($productoCtrl->listarTodo());
    $alertasCuenta = $pdo->query("SELECT COUNT(*) FROM pedido WHERE pedir_cuenta = 'SI'")->fetchColumn();
} catch (Exception $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión Bar Bara</title>
    <link rel="stylesheet" href="css/estilo.css">
    <meta http-equiv="refresh" content="30">
</head>
<body>
    <nav>
        <div class="logo">🍴 ADMINISTRACIÓN - BAR BARA</div>
        <div>
            <a href="index.php">Panel Principal</a>
            <a href="admin_pedidos.php">Ver Alertas</a>
        </div>
    </nav>
    <div class="container">
        <div class="header-status">
            <code>ESTADO: Conectado a MySQL (Bar_Bara)</code>
        </div>
        <h1>Estado del Establecimiento</h1>
        <div class="grid-productos">
            <div class="card" style="border-top: 5px solid <?php echo ($alertasCuenta > 0) ? 'var(--error)' : 'var(--exito)'; ?>;">
                <h3>Mesas pidiendo la cuenta</h3>
                <p style="font-size: 3em; color: <?php echo ($alertasCuenta > 0) ? 'var(--error)' : 'var(--oscuro)'; ?>;">
                    <?php echo $alertasCuenta; ?>
                </p>
                <a href="admin_pedidos.php" class="button">Gestionar Llamadas</a>
            </div>
            <div class="card">
                <h3>Productos en Carta</h3>
                <p style="font-size: 3em;"><?php echo $totalProductos; ?></p>
                <p>Datos leídos de la tabla <code>producto</code></p>
                <a href="listar_productos.php" class="button" style="background: var(--oscuro)">Ver JSON</a>
            </div>
        </div>
    </div>
</body>
</html>
