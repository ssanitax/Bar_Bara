<?php 
session_start();

// 1. CORRECCIÓN: Conectamos con el archivo que SÍ existe
require_once '../back/inc/conexion_bd.php'; 

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];

    // Buscamos el usuario por correo
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE correo = ?");
    $stmt->execute([$correo]);
    $user = $stmt->fetch();

    // Verificamos contraseña
    // NOTA: Si tu base de datos usa 'contrasena', déjalo así. 
    // Si usa 'contraseña' (con ñ), cámbialo aquí abajo.
    if ($user && password_verify($pass, $user['contrasena'])) {
        
        // Login correcto: Guardamos sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nombre']  = $user['nombre_usuario']; 
        
        // Redirigimos al inicio
        header("Location: index.php");
        exit;
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<?php include 'inc/cabecera.php'; ?>
<link rel="stylesheet" href="css/estilo.css">

<div class="container" style="max-width: 450px; margin: 60px auto; padding: 20px;">
    
    <div style="text-align: center; margin-bottom: 30px;">
        <img src="img/logo_home.jpg" alt="Logo" style="width: 100px; border-radius: 50%; border: 3px solid var(--color-mustard);">
        <h2 style="color: var(--color-navy); margin-top: 15px;">Bienvenido de nuevo</h2>
    </div>

    <?php if(!empty($error)): ?>
        <div style="background: var(--color-red); color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
            ⚠️ <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        
        <div style="margin-bottom: 20px;">
            <label style="font-weight: bold; color: var(--color-navy); display: block; margin-bottom: 5px;">Correo Electrónico</label>
            <input type="email" name="correo" required placeholder="tu@email.com" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 30px;">
            <label style="font-weight: bold; color: var(--color-navy); display: block; margin-bottom: 5px;">Contraseña</label>
            <input type="password" name="pass" required placeholder="******" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
        </div>

        <button type="submit" class="btn-hero btn-contacto" style="width: 100%; border: none; cursor: pointer; padding: 15px; font-size: 1.1rem;">
            Entrar al Bar 🍺
        </button>
    </form>

    <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
        <p style="color: #666;">¿Es tu primera vez aquí?</p>
        <a href="registro.php" class="btn-hero btn-carta" style="display: inline-block; padding: 10px 20px; font-size: 1rem; text-decoration: none;">
            Crear Cuenta Gratis
        </a>
    </div>
</div>

<?php include 'inc/piedepagina.php'; ?>