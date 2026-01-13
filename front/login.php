<?php 
session_start();

// 1. Conexión
require_once '../back/inc/conexion_bd.php'; 

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];

    // Buscamos el usuario
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE correo = ?");
    $stmt->execute([$correo]);
    $user = $stmt->fetch();

    // Verificamos contraseña
    if ($user && password_verify($pass, $user['contrasena'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nombre']  = $user['nombre_usuario']; 
        header("Location: carrito.php");
        exit;
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<?php include 'inc/cabecera.php'; ?>
<link rel="stylesheet" href="css/estilo.css">

<div class="container" style="max-width: 450px; margin: -200px auto; padding: 20px;">
    
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="img/logo_home.png" alt="Logo" style="width: 180px;">
        <h2 style="color: var(--color-navy); margin-top: 10px; font-size: 1.5rem;">Bienvenido de nuevo</h2>
    </div>

    <?php if(!empty($error)): ?>
        <div style="background: var(--color-red); color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
            ⚠️ <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; color: var(--color-navy); display: block; margin-bottom: 5px;">Correo Electrónico</label>
            <input type="email" name="correo" required placeholder="tu@email.com" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 25px;">
            <label style="font-weight: bold; color: var(--color-navy); display: block; margin-bottom: 5px;">Contraseña</label>
            <input type="password" name="pass" required placeholder="******" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
        </div>

        <button type="submit" class="btn-hero btn-contacto" style="width: 100%; border: none; cursor: pointer; padding: 15px; font-size: 1.1rem;">
            Entrar al Bar 🍺
        </button>
    </form>

    <div style="text-align: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #ddd;">
        <p style="color: #666; margin-bottom: 10px;">¿Es tu primera vez aquí?</p>
        <a href="registro.php" class="btn-hero btn-carta" style="display: inline-block; padding: 10px 20px; font-size: 1rem; text-decoration: none;">
            Crear Cuenta Gratis
        </a>
    </div>
</div>

<?php include 'inc/piedepagina.php'; ?>