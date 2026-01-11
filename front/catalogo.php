<?php 
session_start();
require_once '../back/inc/conexion_bd.php'; 
include 'inc/cabecera.php'; 

// Preparamos los datos antes de mostrar el HTML
$res_cat = $pdo->query("SELECT DISTINCT categoria FROM producto ORDER BY categoria");
$categorias = $res_cat->fetchAll(PDO::FETCH_COLUMN);

$stmt = $pdo->query("SELECT * FROM producto ORDER BY categoria, nombre_producto");
?>

<style>
    .categorias-nav {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
        padding: 30px;
        background: #f4f4f4;
        border-bottom: 2px solid #ddd;
        margin-bottom: 30px;
        border-radius: 12px;
        margin-top: -220px;
        position: sticky;
        top: 0px;                
        z-index: 900;
    }

    .cat-link {
        background: #153e5c; 
        color: white;
        padding: 10px 20px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
    }

    .cat-link:hover { background: #eaa833; }

    .catalogo-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
        gap: 25px; 
    }

    .producto-card { 
        border: 1px solid #ddd; 
        border-radius: 12px; 
        padding: 20px; 
        text-align: center; 
        background: #fff; 
        display: flex; 
        flex-direction: column; 
        justify-content: space-between; 
    }

    .producto-img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; }

    .cantidad-control { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 15px; }

    .btn-qty { background: #153e5c; color: white; border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; }

    .input-qty { width: 45px; text-align: center; border: 1px solid #ddd; border-radius: 5px; font-weight: bold; }

    .btn-add { background: #27ae60; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-weight: bold; }

    .categoria-titulo { grid-column: 1 / -1; text-align: left; margin-top: 50px; border-bottom: 3px solid #eaa833; color: #153e5c; }
</style>

<div class="categorias-nav">
    <?php foreach ($categorias as $c): ?>
        <a href="#<?php echo urlencode($c); ?>" class="cat-link"><?php echo htmlspecialchars($c); ?></a>
    <?php endforeach; ?>
</div>

<div class="catalogo-grid">
    <?php
    $actual_cat = "";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
        if ($actual_cat != $row['categoria']):
            $actual_cat = $row['categoria']; ?>
            <h2 class="categoria-titulo" id="<?php echo urlencode($actual_cat); ?>"><?php echo htmlspecialchars($actual_cat); ?></h2>
        <?php endif; ?>
        
        <div class="producto-card">
            <div>
                <img src="img/<?php echo $row['imagen']; ?>" class="producto-img">
                <h3 style="margin: 15px 0 5px 0;"><?php echo htmlspecialchars($row['nombre_producto']); ?></h3>
            </div>

            <div style="margin-top: 20px;">
                <p style="font-size: 1.4em; color: #153e5c; margin-bottom: 15px;"><strong><?php echo number_format($row['precio'], 2); ?>€</strong></p>
                
                <form action="carrito.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="cantidad-control">
                        <button type="button" class="btn-qty" onclick="this.nextElementSibling.stepDown()">-</button>
                        <input type="number" name="cantidad" class="input-qty" value="1" min="1" readonly>
                        <button type="button" class="btn-qty" onclick="this.previousElementSibling.stepUp()">+</button>
                    </div>
                    <button type="submit" name="add" class="btn-add">Añadir al pedido</button>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include 'inc/piedepagina.php'; ?>
