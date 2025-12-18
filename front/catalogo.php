<?php include 'header.php'; ?>

<h1>Nuestra Carta</h1>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
    <?php
    $stmt = $pdo->query("SELECT * FROM producto");
    while ($row = $stmt->fetch()): ?>
        <div style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; text-align: center;">
            <img src="img/<?= $row['imagen'] ?>" alt="<?= $row['nombre_producto'] ?>" style="width: 100%; height: 150px; object-fit: cover;">
            <h3><?= $row['nombre_producto'] ?></h3>
            <p style="color: #666;"><?= $row['categoria'] ?></p>
            <p><strong><?= $row['precio'] ?>€</strong></p>
            
            <div style="display: flex; justify-content: space-around;">
                <a href="producto.php?id=<?= $row['id'] ?>" style="color: blue;">Detalles</a>
                <form action="carrito.php" method="POST">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" name="add" style="background: green; color: white; border: none; cursor: pointer;">
                        Añadir +
                    </button>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include 'footer.php'; ?>