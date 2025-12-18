<?php 
include 'db.php';

// ACCIÓN 1: Crear el pedido inicial
if (isset($_POST['confirmar_pedido'])) {
    $user_id = $_SESSION['user_id'] ?? 1; // ID por defecto si no hay login
    $mesa = $_POST['numero_mesa'];
    $total = $_POST['total_pagar'];

    $sql = "INSERT INTO pedido (usuario_id, numero_mesa, fecha, hora, total, pedir_cuenta) 
            VALUES (?, ?, CURDATE(), CURTIME(), ?, 'NO')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $mesa, $total]);
    $pedido_id = $pdo->lastInsertId();

    foreach ($_SESSION['carrito'] as $prod_id => $cant) {
        $stmt = $pdo->prepare("INSERT INTO contenido_pedido (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)");
        $stmt->execute([$pedido_id, $prod_id, $cant]);
    }

    unset($_SESSION['carrito']);
    header("Location: procesar_pedido.php?finalizado=" . $pedido_id);
}

// ACCIÓN 2: El usuario hace clic en "Pedir Cuenta"
if (isset($_POST['llamar_camarero'])) {
    $id_pedido = $_POST['pedido_id'];
    $stmt = $pdo->prepare("UPDATE pedido SET pedir_cuenta = 'SOLICITADA' WHERE id = ?");
    $stmt->execute([$id_pedido]);
    $mensaje = "¡Camarero avisado! En breve te traerán la cuenta a la mesa.";
}
?>

<?php include 'header.php'; ?>

<div style="text-align: center; margin-top: 50px;">
    <?php if(isset($_GET['finalizado']) || isset($mensaje)): ?>
        <div style="background: #d4edda; padding: 20px; border-radius: 10px;">
            <h2><?= $mensaje ?? "¡Pedido Enviado a Cocina!" ?></h2>
            <p>Tu pedido está siendo procesado.</p>
            
            <?php if(!isset($mensaje)): ?>
                <form method="POST">
                    <input type="hidden" name="pedido_id" value="<?= $_GET['finalizado'] ?>">
                    <button type="submit" name="llamar_camarero" style="background: #dc3545; color: white; padding: 15px; font-size: 1.2em; border: none; border-radius: 5px; cursor: pointer;">
                        🔔 PEDIR LA CUENTA (Pagar)
                    </button>
                </form>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <br>
    <a href="index.php">Volver al inicio</a>
</div>