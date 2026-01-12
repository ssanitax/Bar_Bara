<?php
session_start();

include '../back/inc/conexion_bd.php';

// 1. LÓGICA: AÑADIR PRODUCTO (Viene del Catálogo)
if (isset($_POST['add'])) {
    $id_producto = $_POST['id'];
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1; // Leemos la cantidad del formulario 

    $stmt = $pdo->prepare("SELECT * FROM producto WHERE id = :id");
    $stmt->execute([':id' => $id_producto]);
    $producto_bd = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto_bd) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        $ya_existe = false;
        foreach ($_SESSION['carrito'] as $indice => $item) {
            if ($item['id'] == $id_producto) {
                $_SESSION['carrito'][$indice]['cantidad'] += $cantidad; // Sumamos la cantidad elegida [cite: 108, 331]
                $ya_existe = true;
                break;
            }
        }

        if (!$ya_existe) {
            $_SESSION['carrito'][] = [
                'id' => $producto_bd['id'],
                'nombre' => $producto_bd['nombre_producto'],
                'precio' => $producto_bd['precio'],
                'cantidad' => $cantidad // Guardamos la cantidad seleccionada
            ];
        }
    }
    header("Location: catalogo.php");
    exit;
}

// 2. LÓGICA: ELIMINAR PRODUCTO
if (isset($_POST['btn_eliminar'])) {
    $id_a_borrar = $_POST['id_eliminar'];

    // Recorremos el carrito para encontrar el ID y borrarlo
    foreach ($_SESSION['carrito'] as $indice => $producto) {
        if ($producto['id'] == $id_a_borrar) {
            unset($_SESSION['carrito'][$indice]); // Lo borramos
            // Re-organizamos los índices del array para que no queden huecos
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); 
            break; 
        }
    }
    // Recargamos para ver el cambio
    header("Location: carrito.php");
    exit;
}

// 3. CALCULAR TOTAL
$total = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
}

include 'inc/cabecera.php'; 
?>

<style>
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: left; vertical-align: middle; }
    th { background-color: #f4f4f4; }
    .total-row { font-size: 1.2em; font-weight: bold; text-align: right; }
    
    /* Estilo botón eliminar */
    .btn-borrar {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9em;
    }
    .btn-borrar:hover { background-color: #c82333; }
</style>

<h2>Tu Carrito de Compra</h2>

<?php if (!empty($_SESSION['carrito'])): ?>
    
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cant.</th>
                <th>Subtotal</th>
                <th style="text-align: center;">Acción</th> </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['carrito'] as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= number_format($p['precio'], 2) ?>€</td>
                    <td><?= $p['cantidad'] ?></td>
                    <td><?= number_format($p['precio'] * $p['cantidad'], 2) ?>€</td>
                    
                    <td style="text-align: center;">
                        <form action="carrito.php" method="POST" style="margin:0;">
                            <input type="hidden" name="id_eliminar" value="<?= $p['id'] ?>">
                            <button type="submit" name="btn_eliminar" class="btn-borrar">Eliminar</button>
                        </form>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total-row">
        Total a Pagar: <?= number_format($total, 2) ?>€
    </div>

    <hr>

    <form action="procesar_pedido.php" method="POST">
        <label>Número de Mesa:</label>
        <input type="number" name="numero_mesa" required placeholder="Ej: 5" style="padding: 5px;">
        <input type="hidden" name="total_pagar" value="<?= $total ?>">
        <br><br>
        <button type="submit" name="confirmar_pedido" style="background: #28a745; color: white; padding: 10px; border: none; cursor: pointer;">
            Confirmar Pedido y Empezar a Comer
        </button>
    </form>

<?php else: ?>
    
    <div class="empty-cart-container">
        
        <img src="img/logo_triste.png" alt="Carrito Vacío" class="empty-cart-img">
        
        <h2 class="empty-title">¡Ups! Tu mesa está vacía...</h2>
        
        <p class="empty-text">
            Nuestro barman está llorando porque aún no has pedido nada.<br>
            ¡Anímale pidiendo una ronda de tapas o unas cervezas!
        </p>
        
        <a href="catalogo.php" class="btn-hero btn-carta" style="display: inline-flex; align-items: center; gap: 10px; padding: 15px 30px;">
            <span>🍔</span> Ir a la Carta y Solucionarlo
        </a>

    </div>

<?php endif; ?>

<?php include 'inc/piedepagina.php'; ?>

<?php include 'inc/piedepagina.php'; ?>
