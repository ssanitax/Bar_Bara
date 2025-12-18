<?php include 'db.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "INSERT INTO usuario (nombre_usuario, apellidos, correo, contrasea) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['nombre'], $_POST['apellidos'], $_POST['correo'], password_hash($_POST['pass'], PASSWORD_BCRYPT)]);
    header("Location: login.php");
}
?>
<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="apellidos" placeholder="Apellidos" required>
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="pass" placeholder="Contraseña" required>
    <button type="submit">Registrarse</button>
</form>