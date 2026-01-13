<?php
session_start();
include '../back/inc/conexion_bd.php';

// 1. LÓGICA: AÑADIR PRODUCTO (Se mantiene para conexión con catálogo)
if (isset($_POST['add'])) {
    $id_producto = $_POST['id'];
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;
    $stmt = $pdo->prepare("SELECT * FROM producto WHERE id = ?");
    $stmt->execute(array($id_producto));
    $producto_bd = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto_bd) {
        if (!isset($_SESSION['carrito'])) { $_SESSION['carrito'] = array(); }
        $ya_existe = false;
        foreach ($_SESSION['carrito'] as $indice => $item) {
            if ($item['id'] == $id_producto) {
                $_SESSION['carrito'][$indice]['cantidad'] = $_SESSION['carrito'][$indice]['cantidad'] + $cantidad;
                $ya_existe = true; break;
            }
        }
        if (!$ya_existe) {
            $_SESSION['carrito'][] = array(
                'id' => $producto_bd['id'],
                'nombre' => $producto_bd['nombre_producto'],
                'precio' => $producto_bd['precio'],
                'imagen' => $producto_bd['imagen'], // Aseguramos que se guarde la imagen [cite: 446]
                'cantidad' => $cantidad
            );
        }
    }
    header("Location: catalogo.php");
    exit;
}

// 2. LÓGICA: ACTUALIZAR CANTIDAD
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

// 3. LÓGICA: ELIMINAR PRODUCTO
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

// 4. CALCULAR TOTAL
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
    .comanda-container { max-width: 900px; margin: 0 auto; padding: 20px; }
    .tabla-bar-bara { width: 100%; border-collapse: separate; border-spacing: 0 15px; }
    .fila-producto { background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 15px; overflow: hidden; }
    .fila-producto td { padding: 15px; vertical-align: middle; }
    
    /* Imagen del producto en el carrito */
    .img-carrito { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; border: 2px solid #eee; } /*  */

    .selector-cantidad { display: flex; align-items: center; background: #f1f1f1; padding: 5px; border-radius: 30px; width: fit-content; }
    .btn-ajuste { background: #153e5c; color: white; border: none; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; font-weight: bold; }
    
    .total-card { background: #ffffff; padding: 25px; border-radius: 15px; border: 3px solid #eaa833; display: flex; justify-content: space-between; align-items: center; margin-top: 20px; }

    /* RESPONSIVO */
    @media (max-width: 600px) {
        .tabla-bar-bara, .tabla-bar-bara tbody, .tabla-bar-bara tr, .tabla-bar-bara td { display: block; width: 100%; }
        .fila-producto { margin-bottom: 20px; text-align: center; }
        .fila-producto td { padding: 10px; }
        .selector-cantidad { margin: 10px auto; }
        .total-card { flex-direction: column; text-align: center; gap: 20px; }
        .total-card form { flex-direction: column; align-items: center; width: 100%; }
    }
</style>

<div class="comanda-container">
    <h2 style="color: #153e5c; text-align: center;">🛒 Nuestra Comanda</h2>

    <?php if (!empty($_SESSION['carrito'])): ?>
        <table class="tabla-bar-bara">
            <tbody>
                <?php foreach ($_SESSION['carrito'] as $p): ?>
                    <tr class="fila-producto">
                        <td width="100">
                            <img src="img/<?php echo $p['imagen']; ?>" class="img-carrito" alt="Foto">
                        </td>
                        <td>
                            <strong style="font-size: 1.1rem;"><?php echo htmlspecialchars($p['nombre']); ?></strong><br>
                            <span style="color: #666;"><?php echo number_format($p['precio'], 2); ?>€</span>
                        </td>
                        <td align="center">
                            <form action="carrito.php" method="POST" class="selector-cantidad">
                                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                <button type="submit" name="actualizar_cantidad" class="btn-ajuste" onclick="this.nextElementSibling.stepDown()">-</button>
                                <input type="number" name="cantidad" value="<?php echo $p['cantidad']; ?>" min="1" readonly style="width: 35px; text-align: center; border: none; background: transparent; font-weight: bold;">
                                <button type="submit" name="actualizar_cantidad" class="btn-ajuste" onclick="this.previousElementSibling.stepUp()">+</button>
                            </form>
                        </td>
                        <td>
                            <span style="font-weight: 800; font-size: 1.2rem; color: #c93b2b;">
                                <?php echo number_format($p['precio'] * $p['cantidad'], 2); ?>€
                            </span>
                        </td>
                        <td align="right">
                            <form action="carrito.php" method="POST" style="margin:0;">
                                <input type="hidden" name="id_eliminar" value="<?php echo $p['id']; ?>">
                                <button type="submit" name="btn_eliminar" style="background:none; border:none; cursor:pointer; font-size: 1.3rem;" title="Eliminar">Eliminar 🗑️</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-card">
            <div>
                <span style="color: #666; font-size: 0.8rem; text-transform: uppercase;">Total Mesa</span>
                <h3 style="margin:0; font-size: 2.2rem; color: #153e5c;"><?php echo number_format($total, 2); ?>€</h3>
            </div>
            
            <form action="procesar_pedido.php" method="POST" style="display: flex; gap: 15px; align-items: flex-end;">
                <div>
                    <label style="display:block; font-weight: bold; margin-bottom: 5px; color: #153e5c;">Nº MESA</label>
                    <input type="number" name="numero_mesa" required placeholder="Ex: 5" style="padding: 12px; border: 1px solid #ccc; border-radius: 8px; width: 80px;">
                </div>
                <input type="hidden" name="total_pagar" value="<?php echo $total; ?>">
                <button type="submit" name="confirmar_pedido" class="btn-hero btn-carrito-hero" style="border:none; cursor:pointer; padding: 15px 25px;">
                    PEDIR AHORA 🚀
                </button>
            </form>
        </div>

    <?php else: ?>
        <div class="empty-cart-container">
            <img src="img/logo_triste.png" style="width: 150px; margin-bottom: 20px;">
            <h2 class="empty-title">¡Vuestra mesa está vacía!</h2>
            <a href="catalogo.php" class="btn-carta-vacio">🍔 Ver la Carta</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'inc/piedepagina.php'; ?>
