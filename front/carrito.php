<?php include 'header.php'; ?>

<h2>Tu Carrito de Compra</h2>

<?php if (!empty($_SESSION['carrito'])): ?>
    <hr>
    <form action="procesar_pedido.php" method="POST">
        <label>Número de Mesa:</label>
        <input type="number" name="numero_mesa" required placeholder="Ej: 5">
        
        <input type="hidden" name="total_pagar" value="<?= $total ?>">
        <br><br>
        <button type="submit" name="confirmar_pedido" style="background: #28a745; color: white; padding: 10px;">
            Confirmar Pedido y Empezar a Comer
        </button>
    </form>
<?php else: ?>
    <p>El carrito está vacío. <a href="catalogo.php">Ir al catálogo</a></p>
<?php endif; ?>