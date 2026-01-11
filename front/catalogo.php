<?php 
session_start();
require_once '../back/inc/conexion_bd.php';
include 'inc/cabecera.php';
?>

<style>
    /* Estilos CSS puros - Sin nada de PHP dentro para evitar errores */
    .categorias-nav {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
        padding: 15px;
        position: sticky;
        top: 0px; 
        background: #f4f4f4;
        z-index: 500;
        border-bottom: 2px solid #ddd;
    }

    .cat-link {
        background: #2c3e50;
        color: white;
        padding: 8px 18px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: bold;
        font-size: 0.9em;
    }

    .cat-link:hover { background: #e67e22; }

    .cantidad-control {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .btn-qty {
        background: #2c3e50;
        color: white;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        font-weight: bold;
    }

    .input-qty {
        width: 45px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-weight: bold;
        padding: 5px 0;
    }

    .catalogo-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
        gap: 25px; 
        padding: 20px; 
        max-width: 1200px; 
        margin: 0 auto; 
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

    .btn-add { 
        background: #27ae60; 
        color: white; 
        border: none; 
        padding: 12px; 
        border-radius: 5px; 
        cursor: pointer; 
        font-weight: bold; 
        width: 100%; 
    }

    .categoria-titulo { 
        width: 100%; 
        grid-column: 1 / -1; 
        text-align: left; 
        margin-top: 60px; 
        border-bottom: 3px solid #e67e22; 
        padding-bottom: 10px; 
        color: #2c3e50; 
        scroll-margin-top: 180px; 
    }
</style>

<div class="categorias-nav">
    <?php
    $res_cat = $pdo->query("SELECT DISTINCT categoria FROM producto ORDER BY categoria");
    $lista = $res_cat->fetchAll(PDO::FETCH_COLUMN);
    foreach ($lista as $c) {
        $url = urlencode($c);
        $nombre = htmlspecialchars($c);
        echo "<a href='#$url' class='cat-link'>$nombre</a>";
    }
    ?>
</div>

<div class="catalogo-grid">
    <?php
    $actual_cat = "";
    $stmt = $pdo->query("SELECT * FROM producto ORDER BY categoria, nombre_producto");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($actual_cat != $row['categoria']) {
            $actual_cat = $row['categoria'];
            $id_cat = urlencode($actual_cat);
            $nombre_cat = htmlspecialchars($actual_cat);
            echo "<h2 class='categoria-titulo' id='$id_cat'>$nombre_cat</h2>";
        }
    ?>
        <div class="producto-card">
            <div>
                <img src="img/<?php echo $row['imagen']; ?>" class="producto-img">
                <h3 style="margin: 15px 0 5px 0;"><?php echo htmlspecialchars($row['nombre_producto']); ?></h3>
                <p style="color: #666; font-size: 0.9em;"><?php echo htmlspecialchars(substr($row['descripcion'], 0, 60)); ?>...</p>
            </div>

            <div style="margin-top: 20px;">
                <p style="font-size: 1.4em; color: #2c3e50; margin-bottom: 15px;">
                    <strong><?php echo number_format($row['precio'], 2); ?>€</strong>
                </p>
                
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
    <?php } ?>
</div>

<?php include 'inc/piedepagina.php'; ?>
