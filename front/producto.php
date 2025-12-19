<?php include '../back/inc/conexion_db.php';
$stmt = $pdo->prepare("SELECT * FROM producto WHERE id = ?");
$stmt->execute([$_GET['id']]);
$p = $stmt->fetch();
?>
<h1><?= $p['nombre_producto'] ?></h1>
<img src="<?= $p['imagen'] ?>" width="200">
<p><?= $p['descripcion'] ?></p>
<p>Precio: <?= $p['precio'] ?>€</p>
<a href="index.php">Volver</a>