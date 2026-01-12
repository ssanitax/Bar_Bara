<?php
// index.php en la raíz del back
require_once 'inc/conexion_bd.php'; 
require_once 'controladores/PedidoControlador.php'; 
require_once 'controladores/ProductoControlador.php'; 

$pedidoCtrl = new PedidoControlador($pdo); 
$productoCtrl = new ProductoControlador($pdo); 

// --- LÓGICA DE ACCIONES ---
if (isset($_POST['entregar_id'])) {
    $pedidoCtrl->marcarComoEntregado($_POST['entregar_id']);
}

try {
    $totalProductos = count($productoCtrl->listarTodo());
    
    // 1. COMANDAS POR SERVIR 
    $pendientes = $pdo->query("SELECT * FROM pedido WHERE pedir_cuenta = 'NO' ORDER BY hora ASC")->fetchAll();
    
    // 2. ALERTAS DE COBRO 
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
    <link rel="stylesheet" href="css/estilo.css"> <meta http-equiv="refresh" content="30"> <style>
        .seccion { margin-bottom: 40px; }
        .titulo-seccion { 
            padding: 10px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            color: white;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">🍴 BAR BARA - PANEL DE CONTROL</div> <div class="header-status">
            <code>PRODUCTOS: <?php echo $totalProductos; ?></code> </div>
    </nav>

    <div class="container">

        <div class="seccion">
            <h2 class="titulo-seccion" style="background: var(--error);">🔔 ALERTAS DE COBRO (<?php echo $conteoAlertas; ?>)</h2> <div class="grid-productos">
                <?php if (empty($alertas)): ?>
                    <div class="card"><h3>No hay mesas solicitando la cuenta.</h3></div> <?php else: ?>
                    <?php foreach($alertas as $a): ?>
                        <div class="card" style="border-left: 10px solid var(--error); text-align: left;"> <h2 style="margin:0">MESA <?php echo $a['numero_mesa']; ?></h2> <p><strong>Total a cobrar: <?php echo $a['total']; ?>€</strong></p> <p>Hora solicitud: <?php echo $a['hora']; ?></p> </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <hr>

        <div class="seccion">
            <h2 class="titulo-seccion" style="background: var(--primario);">📥 COMANDAS POR SERVIR</h2> <div class="grid-productos">
                <?php if (empty($pendientes)): ?>
                    <div class="card"><h3>Cero comandas pendientes.</h3></div>
                <?php else: ?>
                    <?php foreach ($pendientes as $p): ?>
                        <div class="card" style="border-left: 10px solid var(--primario); text-align: left;"> <h2 style="margin:0">MESA <?php echo $p['numero_mesa']; ?></h2> <p>Hora pedido: <?php echo $p['hora']; ?></p>
                            <p>Importe: <?php echo $p['total']; ?>€</p>
                            <form method="POST">
                                <input type="hidden" name="entregar_id" value="<?php echo $p['id']; ?>">
                                <button type="submit" class="button" style="background: var(--exito); width:100%; border:none; cursor:pointer;">
                                    ✅ MARCAR ENTREGADO
                                </button> </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</body>
</html>
