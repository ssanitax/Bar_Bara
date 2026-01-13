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

// Lógica para pedir la cuenta
if (isset($_POST['pedir_cuenta_total'])) {
    $sql = "UPDATE pedido 
            SET pedir_cuenta = CASE 
                WHEN pedir_cuenta = 'ENTREGADO' THEN 'SI_ENTREGADO' 
                ELSE 'SI' 
            END 
            WHERE usuario_id = ? AND pedir_cuenta != 'PAGADO'";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($user_id));
    
    $mensaje = "🔔 ¡Aviso enviado! El camarero traerá la cuenta en breve.";
}

// Consultamos productos (usando array() para máxima compatibilidad)
$query = "SELECT p.id as pedido_id, pr.nombre_producto, cp.cantidad, cp.subtotal, p.pedir_cuenta
          FROM pedido p
          JOIN contenido_pedido cp ON p.id = cp.pedido_id
          JOIN producto pr ON cp.producto_id = pr.id
          WHERE p.usuario_id = ? AND p.pedir_cuenta != 'PAGADO'
          ORDER BY p.id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute(array($user_id));
$items = $stmt->fetchAll();

$total_mesa = 0;
?>

<div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #153e5c; text-align: center; margin-bottom: 30px;">Resumen de vuestra mesa 📝</h2>

    <?php if ($mensaje): ?>
        <div style="background: #27ae60; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div style="background: white; padding: 60px 20px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center; border: 2px dashed #ccc;">
            <div style="font-size: 5rem; margin-bottom: 20px;">🍽️</div>
            <h3 style="color: #153e5c; font-size: 1.8rem; margin-bottom: 10px;">¡Vuestra mesa está lista!</h3>
            <p style="color: #666; font-size: 1.1rem; margin-bottom: 30px;">Todavía no habéis marchado ningún plato. ¿Empezamos con unas rondas?</p>
            
            <a href="catalogo.php" class="btn-hero btn-carta" style="display: inline-block; text-decoration: none; padding: 15px 40px; font-size: 1.2rem;">
                📖 Ver la Carta
            </a>
        </div>
    <?php else: ?>
        <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee;">
                        <th style="text-align: left; padding: 10px; color: #153e5c;">Producto</th>
                        <th style="text-align: center; padding: 10px; color: #153e5c;">Cant.</th>
                        <th style="text-align: right; padding: 10px; color: #153e5c;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): 
                        $total_mesa = $total_mesa + $item['subtotal'];
                    ?>
                        <tr style="border-bottom: 1px solid #f9f9f9;">
                            <td style="padding: 15px;"><?php echo htmlspecialchars($item['nombre_producto']); ?></td>
                            <td style="text-align: center; padding: 15px; font-weight: bold;"><?php echo $item['cantidad']; ?></td>
                            <td style="text-align: right; padding: 15px;"><?php echo number_format($item['subtotal'], 2); ?>€</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="font-size: 1.6rem; font-weight: bold; color: #c93b2b;">
                        <td colspan="2" style="padding: 25px 10px;">TOTAL ACUMULADO:</td>
                        <td style="text-align: right; padding: 25px 10px;"><?php echo number_format($total_mesa, 2); ?>€</td>
                    </tr>
                </tfoot>
            </table>

            <form method="POST" style="margin-top: 20px;">
                <button type="submit" name="pedir_cuenta_total" 
                        class="btn-hero btn-carrito-hero" 
                        style="width: 100%; border: none; cursor: pointer; padding: 20px; font-size: 1.2rem;">
                    🔔 PEDIR LA CUENTA FINAL
                </button>
            </form>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="catalogo.php" style="color: #153e5c; font-weight: bold; text-decoration: underline;">¿Algo más? Seguir pidiendo</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'inc/piedepagina.php'; ?>
