<?php 
// 1. Incluimos la conexión desde la carpeta back
include '../back/inc/conexion_bd.php'; 

// 2. Incluimos la cabecera (diseño superior)
include 'inc/cabecera.php'; 

// 3. Capturamos el ID y verificamos que el producto existe
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM producto WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

// Si el producto no existe (ej. alguien cambia el ID en la URL a mano)
if (!$p) {
    echo "<div style='text-align:center; padding:100px;'><h2>El producto no existe.</h2><a href='catalogo.php'>Volver a la carta</a></div>";
    include 'inc/piedepagina.php';
    exit;
}
?>

<div style="max-width: 900px; margin: 50px auto; padding: 20px; background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; gap: 30px; align-items: center;">
    
    <div style="flex: 1;">
        <img src="img/<?= $p['imagen'] ?>" alt="<?= htmlspecialchars($p['nombre_producto']) ?>" style="width: 100%; border-radius: 10px; object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    </div>

    <div style="flex: 1;">
        <h1 style="color: #2c3e50; margin-bottom: 10px;"><?= htmlspecialchars($p['nombre_producto']) ?></h1>
        <p style="color: #e67e22; font-weight: bold; text-transform: uppercase; font-size: 0.9em;"><?= $p['categoria'] ?></p>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        
        <p style="font-size: 1.1rem; line-height: 1.6; color: #555;">
            <?= htmlspecialchars($p['descripcion']) ?>
        </p>
        
        <p style="font-size: 2rem; color: #27ae60; margin: 20px 0;">
            <strong><?= number_format($p['precio'], 2) ?>€</strong>
        </p>

        <form action="carrito.php" method="POST">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <button type="submit" name="add" style="background: #27ae60; color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-size: 1.1rem; font-weight: bold; width: 100%;">
                Añadir al pedido 🛒
            </button>
        </form>

        <a href="catalogo.php" style="display: block; margin-top: 20px; color: #7f8c8d; text-decoration: none; font-size: 0.9em;">← Volver a la carta</a>
    </div>
</div>

<?php 
// 5. Incluimos el pie de página
include 'inc/piedepagina.php'; 
?>