<?php
session_start();
include '../back/inc/conexion_bd.php';

// 1. LÓGICA: ACTUALIZAR CANTIDAD
if (isset($_POST['actualizar_cantidad'])) {
    $id_producto = $_POST['id'];
    $nueva_cantidad = (int)$_POST['cantidad'];

    if (isset($_SESSION['carrito']) && $nueva_cantidad > 0) {
        foreach ($_SESSION['carrito'] as $indice => $item) {
            if ($item['id'] == $id_producto) {
                $_SESSION['carrito'][$indice]['cantidad'] = $nueva_cantidad;
                break;
            }
        }
    }
    header("Location: carrito.php");
    exit;
}

// 2. LÓGICA: ELIMINAR PRODUCTO
if (isset($_POST['btn_eliminar'])) {
    $id_a_borrar = $_POST['id_eliminar'];
    foreach ($_SESSION['carrito'] as $indice => $producto) {
        if ($producto['id'] == $id_a_borrar) {
            unset($_SESSION['carrito'][$indice]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']);
            break; 
        }
    }
    header("Location: carrito.php");
    exit;
}

// 3. CALCULAR TOTAL
$total = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $total = $total + ($item['precio'] * $item['cantidad']);
    }
}

include 'inc/cabecera.php'; 
?>
<link rel="stylesheet" href="css/estilo.css">
<style>
    .comanda-container { max-width: 800px; margin: 0 auto; padding: 20px; }
    .tabla-bar-bara { width: 100%; border-collapse: separate; border-spacing: 0 15px; }
    .fila-producto { background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 15px; }
    .fila-producto td { padding: 20px; vertical-align: middle; }
    .fila-producto td:first-child { border-radius: 15px 0 0 15px; }
    .fila-producto td:last-child { border-radius: 0 15px 15px 0; text-align: right; }
    
    .selector-cantidad { 
        display: flex; 
        align-items: center; 
        background: #f1f1f1; 
        padding: 5px; 
        border-radius: 30px; 
        width: fit-content;
    }
    .btn-ajuste { 
        background: #153e5c; 
        color: white; 
        border: none; 
        width: 30px; 
        height: 30px; 
        border-radius: 50%; 
        cursor: pointer; 
        font-weight: bold;
    }
    .input-cant { 
        width: 40px; 
        text-align: center; 
        border: none; 
        background: transparent; 
        font-weight: bold; 
        color: #153e5c;
    }
    .total-card { 
        background: #ffffff; 
        padding: 25px; 
        border-radius: 15px; 
        border: 3px solid #eaa833; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-top: 20px;
    }
</style>

<div class="comanda-container">
    <h2 style="color: #153e5c; text-align: center; margin-bottom: 30px;">📋 Nuestra Comanda</h2>

    <?php if (!empty($_SESSION['carrito'])): ?>
        <table class="tabla-bar-bara">
            <tbody>
                <?php foreach ($_SESSION['carrito'] as $p): ?>
                    <tr class="fila-producto">
                        <td>
                            <strong style="font-size: 1.1rem;"><?php echo htmlspecialchars($p['nombre']); ?></strong><br>
                            <span style="color: #666;"><?php echo number_format($p['precio'], 2); ?>€ / unidad</span>
                        </td>
                        <td align="center">
                            <form action="carrito.php" method="POST" class="selector-cantidad">
                                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                <button type="submit" name="actualizar_cantidad" class="btn-ajuste" onclick="this.nextElementSibling.stepDown()">-</button>
                                <input type="number" name="cantidad" class="input-cant" value="<?php echo $p['cantidad']; ?>" min="1" readonly>
                                <button type="submit" name="actualizar_cantidad" class="btn-ajuste" onclick="this.previousElementSibling.stepUp()">+</button>
                            </form>
                        </td>
                        <td>
                            <span style="font-weight: 800; font-size: 1.2rem; color: #c93b2b;">
                                <?php echo number_format($p['precio'] * $p['cantidad'], 2); ?>€
                            </span>
                        </td>
                        <td>
                            <form action="carrito.php" method="POST" style="margin:0;">
                                <input type="hidden" name="id_eliminar" value="<?php echo $p['id']; ?>">
                                <button type="submit" name="btn_eliminar" style="background:none; border:none; cursor:pointer; font-size: 1.3rem;">🗑️</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-card">
            <div>
                <span style="text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; color: #666;">Total a pagar</span>
                <h3 style="margin:0; font-size: 2.2rem; color: #153e5c;"><?php echo number_format($total, 2); ?>€</h3>
            </div>
            
            <form action="procesar_pedido.php" method="POST" style="display: flex; gap: 15px; align-items: flex-end;">
                <div>
                    <label style="display:block; font-weight: bold; margin-bottom: 5px; color: #153e5c;">Nº MESA</label>
                    <input type="number" name="numero_mesa" required placeholder="Ex: 5" style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; width: 80px;">
                </div>
                <input type="hidden" name="total_pagar" value="<?php echo $total; ?>">
                <button type="submit" name="confirmar_pedido" class="btn-hero btn-carrito-hero" style="border:none; cursor:pointer; padding: 15px 25px;">
                    ENVIAR A COCINA 👨‍🍳
                </button>
            </form>
        </div>

    <?php else: ?>
        <div class="empty-cart-container" style="text-align: center; background: white; padding: 50px; border-radius: 15px; border: 2px dashed #ccc;">
            <h2 class="empty-title">¡Vuestra mesa está vacía!</h2>
            <p class="empty-text">Parece que aún no habéis pedido nada de la carta.</p>
            <a href="catalogo.php" class="btn-carta-vacio" style="display: inline-block; margin-top: 20px;">🍔 Ver la Carta</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'inc/piedepagina.php'; ?>
