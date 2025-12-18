<?php include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE correo = ?");
    $stmt->execute([$_POST['correo']]);
    $user = $stmt->fetch();
    if ($user && password_verify($_POST['pass'], $user['contrasea'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
    } else { echo "Datos incorrectos"; }
}
?>
<form method="POST">
    <input type="email" name="correo" placeholder="Correo">
    <input type="password" name="pass" placeholder="Password">
    <button type="submit">Entrar</button>
</form>