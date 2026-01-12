<?php 
session_start();
require_once '../back/inc/conexion_bd.php';
include 'inc/cabecera.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$mensaje = "";

// Lógica para pedir la cuenta desde aquí
if (isset($_POST['pedir_cuenta_total'])) {
    $stmt = $pdo->prepare("UPDATE pedido SET pedir_cuenta = 'SI' WHERE usuario_id = ? AND pedir_cuenta != 'PAGADO'");
    $stmt->execute([$user_id]);
    $mensaje = "🔔 ¡Aviso enviado! El camarero traerá la cuenta en breve.";
}

// Consultamos todos los productos pedidos por el usuario en esta sesión
$query = "SELECT p.id as pedido_id, pr.nombre_producto, cp.cantidad, cp.subtotal, p.pedir_cuenta
          FROM pedido p
          JOIN contenido_pedido cp ON p.id = cp.pedido_id
          JOIN producto pr ON cp.producto_id = pr.id
          WHERE p.usuario_id = ? AND p.pedir_cuenta != 'PAGADO'
          ORDER BY p.id DESC";

$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$items = $stmt->fetchAll();

$total_mesa = 0;
?>

<div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #153e5c; text-align: center;">Resumen de vuestra mesa 📝</h2>

    <?php if ($mensaje): ?>
        <div style="background: #27ae60; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
            <?= $mensaje ?>
        </div>
    <?php endif; ?>

    <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <?php if (empty($items)): ?>
            <p style="text-align: center;">Aún no habéis pedido nada. <a href="catalogo.php">¡Mirad la carta!</a></p>
        <?php else: ?>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee;">
                        <th style="text-align: left; padding: 10px;">Producto</th>
                        <th style="text-align: center; padding: 10px;">Cant.</th>
                        <th style="text-align: right; padding: 10px;">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): 
                        $total_mesa += $item['subtotal'];
                    ?>
                        <tr style="border-bottom: 1px solid #f9f9f9;">
                            <td style="padding: 10px;"><?= htmlspecialchars($item['nombre_producto']) ?></td>
                            <td style="text-align: center; padding: 10px;"><?= $item['cantidad'] ?></td>
                            <td style="text-align: right; padding: 10px;"><?= number_format($item['subtotal'], 2) ?>€</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="font-size: 1.5rem; font-weight: bold; color: #c93b2b;">
                        <td colspan="2" style="padding: 20px 10px;">TOTAL:</td>
                        <td style="text-align: right; padding: 20px 10px;"><?= number_format($total_mesa, 2) ?>€</td>
                    </tr>
                </tfoot>
            </table>

            <form method="POST" style="margin-top: 20px;">
                <button type="submit" name="pedir_cuenta_total" class="btn-hero btn-carrito-hero" 
                        style="width: 100%; border: none; cursor: pointer; padding: 20px; font-size: 1.2rem; animation: pulse 2s infinite;">
                    🔔 PEDIR LA CUENTA FINAL
                </button>
            </form>
        <?php endif; ?>
    </div>
    
    <div style="text-align: center; margin-top: 20px;">
        <a href="catalogo.php" style="color: #153e5c; text-decoration: underline;">Seguir pidiendo</a>
    </div>
</div>

<?php include 'inc/piedepagina.php'; ?>
