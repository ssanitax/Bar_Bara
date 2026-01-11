<?php 
require_once '../back/inc/conexion_bd.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Usamos 'contrasena' (sin ñ) como en vuestra tabla SQL
    $sql = "INSERT INTO usuario (nombre_usuario, apellidos, correo, contrasena) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nombre'], 
        $_POST['apellidos'], 
        $_POST['correo'], 
        password_hash($_POST['pass'], PASSWORD_BCRYPT)
    ]);
    header("Location: login.php");
    exit;
}
include 'inc/cabecera.php'; 
?>
<h2>Crea tu cuenta en Bar Bara</h2>
<form method="POST" style="max-width: 400px; margin: 20px auto; display: flex; flex-direction: column; gap: 10px;">
    <input type="text" name="nombre" placeholder="Nombre" required style="padding: 10px;">
    <input type="text" name="apellidos" placeholder="Apellidos" required style="padding: 10px;">
    <input type="email" name="correo" placeholder="Correo electrónico" required style="padding: 10px;">
    <input type="password" name="pass" placeholder="Contraseña" required style="padding: 10px;">
    <button type="submit" style="background: #e67e22; color: white; padding: 10px; border: none; cursor: pointer;">Registrarse</button>
</form>
<?php include 'inc/piedepagina.php'; ?>
