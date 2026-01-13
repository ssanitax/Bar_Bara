<?php
// index.php en la raíz del back
require_once 'inc/conexion_bd.php';
require_once 'controladores/PedidoControlador.php';
require_once 'controladores/ProductoControlador.php';

$pedidoCtrl = new PedidoControlador($pdo);
$productoCtrl = new ProductoControlador($pdo);

// --- LÓGICA DE ACCIONES ---

// 1. Marcar como entregado (Cocina)
if (isset($_POST['entregar_id'])) {
    $pedidoCtrl->marcarComoEntregado($_POST['entregar_id']);
}

// 2. Marcar como pagado (Barra) y limpiar historial del cliente
if (isset($_POST['cobrar_id'])) {
    $idPedido = $_POST['cobrar_id'];
    // Ejecutamos el cambio a 'PAGADO' directamente o mediante el controlador
    $sql = "UPDATE pedido SET pedir_cuenta = 'PAGADO' WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idPedido]);
}

try {
    $totalProductos = count($productoCtrl->listarTodo());
    
    // COMANDAS POR SERVIR: Solo las que están en estado 'NO'
    $pendientes = $pdo->query("SELECT * FROM pedido WHERE pedir_cuenta = 'NO' ORDER BY hora ASC")->fetchAll();
    
    // ALERTAS DE COBRO: Solo las que están en estado 'SI'
    $alertas = $pdo->query("SELECT * FROM pedido WHERE pedir_cuenta = 'SI' ORDER BY hora ASC")->fetchAll();
    
    $conteoAlertas = count($alertas);
} catch (Exception $e) {
    die("Error en la base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bar Bara - Panel Unificado</title>
    <link rel="stylesheet" href="css/estilo.css">
    <meta http-equiv="refresh" content="30">
    <style>
        .seccion { margin-bottom: 40px; }
        .titulo-seccion { padding: 10px; border-radius: 8px; margin-bottom: 20px; color: white; }
    </style>
</head>
<body>
    <nav>
        <div class="logo">🍴 BAR BARA - PANEL DE CONTROL</div>
        <div class="header-status">
            <code>PRODUCTOS: <?php echo $totalProductos; ?></code>
        </div>
    </nav>

    <div class="container">
        
        <div class="seccion">
            <h2 class="titulo-seccion" style="background: var(--error);">🔔 ALERTAS DE COBRO (<?php echo $conteoAlertas; ?>)</h2>
            <div class="grid-productos">
                <?php if (empty($alertas)): ?>
                    <div class="card"><h3>No hay mesas solicitando la cuenta.</h3></div>
                <?php else: ?>
                    <?php foreach($alertas as $a): ?>
                        <div class="card" style="border-left: 10px solid var(--error); text-align: left;"> 
                            <h2 style="margin:0">MESA <?php echo $a['numero_mesa']; ?></h2>
                            <p><strong>Total a cobrar: <?php echo $a['total']; ?>€</strong></p>
                            <p>Hora solicitud: <?php echo $a['hora']; ?></p>
                            
                            <form method="POST">
                                <input type="hidden" name="cobrar_id" value="<?php echo $a['id']; ?>">
                                <button type="submit" class="button" style="background: var(--exito); width:100%; border:none; cursor:pointer; margin-top:10px;">
                                    💰 MARCAR COMO COBRADO
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <hr>

        <div class="seccion">
            <h2 class="titulo-seccion" style="background: var(--primario);">📥 COMANDAS POR SERVIR</h2>
            <div class="grid-productos">
                <?php if (empty($pendientes)): ?>
                    <div class="card"><h3>Cero comandas pendientes.</h3></div>
                <?php else: ?>
                   <?php foreach ($pendientes as $p): ?>
    <div class="card" style="border-left: 10px solid var(--primario); text-align: left;"> 
        
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 style="margin:0">MESA <?php echo $p['numero_mesa']; ?></h2>
            <span style="background:#eee; padding:5px 10px; border-radius:5px; font-weight:bold;">
                <?php echo date('H:i', strtotime($p['hora'])); ?>
            </span>
        </div>

        <hr style="margin: 10px 0; border: 0; border-top: 1px dashed #ccc;">

        <ul style="padding-left: 20px; margin: 10px 0;">
            <?php 
            // Preparamos la consulta para obtener productos y cantidades de este pedido específico
            // Cruzamos contenido_pedido con producto para sacar el nombre
            $sqlDetalles = "SELECT cp.cantidad, prod.nombre_producto 
                            FROM contenido_pedido cp 
                            JOIN producto prod ON cp.producto_id = prod.id 
                            WHERE cp.pedido_id = ?";
            
            $stmtDetalles = $pdo->prepare($sqlDetalles);
            $stmtDetalles->execute([$p['id']]);
            $detalles = $stmtDetalles->fetchAll();

            foreach($detalles as $d): ?>
                <li style="font-size: 1.1rem; margin-bottom: 5px;">
                    <strong><?php echo $d['cantidad']; ?>x</strong> 
                    <?php echo htmlspecialchars($d['nombre_producto']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <p style="text-align: right; color: #666; font-size: 0.9rem;">Total: <?php echo $p['total']; ?>€</p>
        
        <form method="POST">
            <input type="hidden" name="entregar_id" value="<?php echo $p['id']; ?>">
            <button type="submit" class="button" style="background: var(--exito); width:100%; border:none; cursor:pointer;">
                ✅ MARCAR ENTREGADO
            </button>
        </form>
    </div>
<?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
