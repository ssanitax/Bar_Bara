<?php 
// 1. Conexión subiendo un nivel hacia la carpeta back
include '../back/inc/conexion_bd.php'; 

// 2. Cargamos la cabecera del front
include 'inc/cabecera.php'; 
?>

<style>
    .catalogo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        padding: 40px 20px;
        max-width: 1200px;
        margin: 0 auto;
    }
    .producto-card {
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        background: #fff;
        transition: transform 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .producto-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .producto-img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; }
    .btn-detalles { color: #3498db; text-decoration: none; font-weight: bold; font-size: 0.9em; }
    .btn-add { background: #27ae60; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; }
</style>

<h1 style="text-align: center; margin-top: 40px; color: #2c3e50;">Nuestra Carta</h1>

<div class="catalogo-grid">
    <?php
    // 3. Consulta a la base de datos
    $stmt = $pdo->query("SELECT * FROM producto ORDER BY categoria, nombre_producto");
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        
        <div class="producto-card">
            <div>
                <img src="img/<?= $row['imagen'] ?>" alt="<?= htmlspecialchars($row['nombre_producto']) ?>" class="producto-img">
                
                <h3 style="margin: 15px 0 5px 0;"><?= htmlspecialchars($row['nombre_producto']) ?></h3>
                <p style="color: #e67e22; font-size: 0.8em; font-weight: bold; text-transform: uppercase;">
                    <?= htmlspecialchars($row['categoria']) ?>
                </p>
                <p style="color: #666; font-size: 0.9em; min-height: 50px;">
                    <?= htmlspecialchars(substr($row['descripcion'], 0, 80)) ?>...
                </p>
            </div>

            <div style="margin-top: 20px;">
                <p style="font-size: 1.5em; color: #2c3e50; margin-bottom: 15px;">
                    <strong><?= number_format($row['precio'], 2) ?>€</strong>
                </p>
                
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #eee; padding-top: 15px;">
                    <a href="producto.php?id=<?= $row['id'] ?>" class="btn-detalles">Ver detalles</a>
                    
                    <form action="carrito.php" method="POST" style="margin: 0;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="add" class="btn-add">Añadir +</button>
                    </form>
                </div>
            </div>
        </div>

    <?php endwhile; ?>
</div>

<?php 
// 4. Cargamos el pie de página
include 'inc/piedepagina.php'; 
?>
