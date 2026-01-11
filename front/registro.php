<?php 
session_start();
// Usamos la conexión centralizada
require_once '../back/inc/conexion_bd.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $password = $_POST['pass'];

    // CORRECCIÓN AQUÍ: Cambiamos 'contrasea' por 'contrasena'
    $sql = "INSERT INTO usuario (nombre_usuario, apellidos, correo, contrasena) VALUES (?, ?, ?, ?)";
    
    try {
        $stmt = $pdo->prepare($sql);
        // Encriptamos la contraseña
        $pass_encriptada = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt->execute([$nombre, $apellidos, $correo, $pass_encriptada]);

        // 2. AUTO-LOGIN 
        $nuevo_id_usuario = $pdo->lastInsertId();
        
        $_SESSION['user_id'] = $nuevo_id_usuario;
        $_SESSION['nombre'] = $nombre;

        // 3. REDIRECCIÓN INTELIGENTE
        if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
            header("Location: carrito.php");
        } else {
            header("Location: index.php");
        }
        exit;

    } catch (PDOException $e) {
        $error = "Error al registrarse: " . $e->getMessage();
    }
}
?>

<?php include 'inc/cabecera.php'; ?>
<link rel="stylesheet" href="css/estilo.css">

<div class="container" style="max-width: 500px; margin: 50px auto; padding: 20px;">
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="img/logo_home.jpg" alt="Logo" style="width: 80px; border-radius: 50%;">
    </div>

    <h2 style="text-align: center; color: var(--color-navy);">Únete a la Familia</h2>
    <p style="text-align: center; color: #666;">Regístrate para confirmar tu pedido</p>

    <?php if(isset($error)): ?>
        <div style="background: var(--color-red); color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
            ⚠️ <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; color: var(--color-navy);">Nombre</label>
            <input type="text" name="nombre" required placeholder="Ej: Juan" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; color: var(--color-navy);">Apellidos</label>
            <input type="text" name="apellidos" required placeholder="Ej: Pérez" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; color: var(--color-navy);">Correo Electrónico</label>
            <input type="email" name="correo" required placeholder="tu@email.com" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 25px;">
            <label style="font-weight: bold; color: var(--color-navy);">Contraseña</label>
            <input type="password" name="pass" required placeholder="******" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">
        </div>

        <button type="submit" class="btn-hero btn-carta" style="width: 100%; border: none; cursor: pointer; font-size: 1.1rem;">
            Registrarse ➔
        </button>
    </form>
    
    <p style="text-align: center; margin-top: 20px;">
        ¿Ya tienes cuenta? <a href="login.php" style="color: var(--color-red); font-weight: bold;">Inicia sesión aquí</a>
    </p>
</div>

<?php include 'inc/piedepagina.php'; ?>
