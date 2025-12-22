<?php
// admin_pedidos.php en la raíz
require_once 'inc/conexion_bd.php';

$alertas = $pdo->query("SELECT numero_mesa, hora, total FROM pedido WHERE pedir_cuenta = 'SI'")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alertas - Bar Bara</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <nav>
        <div class="logo">🔔 ALERTAS DE COBRO</div>
        <a href="index.php">Volver al Panel</a>
    </nav>
    <div class="container">
        <?php if (empty($alertas)): ?>
            <div class="card"><h3>No hay mesas solicitando la cuenta.</h3></div>
        <?php else: ?>
            <div class="grid-productos">
                <?php foreach($alertas as $aviso): ?>
                    <div class="card" style="border-left: 10px solid var(--error); text-align: left;">
                        <h2 style="margin:0">MESA <?php echo $aviso['numero_mesa']; ?></h2>
                        <p>Hora: <?php echo $aviso['hora']; ?></p>
                        <p>Total a cobrar: <strong><?php echo $aviso['total']; ?>€</strong></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
