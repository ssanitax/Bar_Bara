<?php 
echo "El usuario que has usado es " . $_POST['usuario']; 
// Conexión a Bar_Bara
try {
    $pdo = new PDO("mysql:host=localhost;dbname=Bar_Bara;charset=utf8", "admin_bara", "BarBara_2025$");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

include 'cabecera.php'; 
?>

<h1 style="text-align: center; margin: 30px 0;">Nuestra Carta</h1>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; padding: 20px; max-width: 1200px; margin: 0 auto;">
    <?php
    // Consultamos los 100 productos
    $stmt = $pdo->query("SELECT * FROM producto ORDER BY categoria, nombre_producto");
    while ($row = $stmt->fetch()): ?>
        
        <div style="border: 1px solid #ddd; border-radius: 12px; padding: 20px; text-align: center; background: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
            
            <div>
                <img src="img/<?= $row['imagen'] ?>" alt="<?= htmlspecialchars($row['nombre_producto']) ?>" style="width: 100%; height: 180px; object-fit: cover; border-radius: 8px;">
                
                <h3 style="margin: 15px 0 5px 0; color: #333;"><?= htmlspecialchars($row['nombre_producto']) ?></h3>
                
                <p style="color: #e67e22; font-size: 0.85em; font-weight: bold; text-transform: uppercase; margin-bottom: 10px;">
                    <?= htmlspecialchars($row['categoria'] ?: 'General') ?>
                </p>
                
                <p style="color: #666; font-size: 0.9em; min-height: 40px; margin-bottom: 15px;">
                    <i><?= htmlspecialchars($row['descripcion']) ?></i>
                </p>
            </div>

            <div>
                <p style="font-size: 1.4em; color: #27ae60; margin-bottom: 15px;"><strong><?= number_format($row['precio'], 2) ?>€</strong></p>
                
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #eee; padding-top: 15px;">
                    <a href="producto.php?id=<?= $row['id'] ?>" style="color: #3498db; text-decoration: none; font-weight: bold;">Detalles</a>
                    
                    <form action="carrito.php" method="POST" style="margin: 0;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="add" style="background: #27ae60; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold;">
                            Añadir +
                        </button>
                    </form>
                </div>
            </div>
        </div>

    <?php endwhile; ?>
</div>

<?php include 'piedepagina.php'; ?>
