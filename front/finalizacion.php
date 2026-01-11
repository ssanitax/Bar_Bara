<?php 
session_start();

// 1. CORRECCIÓN DE RUTAS: Usamos tus archivos reales
require_once '../back/inc/conexion_bd.php'; // Antes buscaba db.php

// Lógica: El usuario hace clic en "Pedir Cuenta" (Botón rojo)
$mensaje = "";
if (isset($_POST['llamar_camarero'])) {
    $id_pedido = $_POST['pedido_id'];
    
    // Actualizamos el estado en la base de datos
    $sql = "UPDATE pedido SET pedir_cuenta = 'SI' WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_pedido]);
    
    $mensaje = "¡Oído cocina! 🔔 El camarero ya sabe que quieres la cuenta.";
}

// 2. CORRECCIÓN DE CABECERA
include 'inc/cabecera.php'; // Antes buscaba header.php
?>

<link rel="stylesheet" href="css/estilo.css">

<main class="container" style="text-align: center; padding: 40px 20px; max-width: 800px; margin: 0 auto;">

    <?php if(isset($_GET['finalizado']) || isset($_POST['llamar_camarero'])): ?>
        
        <div style="background: white; padding: 40px; border-radius: var(--radius); box-shadow: var(--shadow); border-top: 5px solid var(--color-mustard);">
            
            <div style="font-size: 4rem; margin-bottom: 20px;">✅</div>
            
            <h1 style="color: var(--color-navy); margin-top: 0;">
                <?= $mensaje ? "¡Aviso Enviado!" : "¡Pedido Confirmado!" ?>
            </h1>

            <p style="font-size: 1.2rem; color: #555;">
                <?= $mensaje 
                    ? "En breves instantes nos acercamos a tu mesa." 
                    : "Tu comanda ha llegado a la cocina y se está preparando." 
                ?>
            </p>

            <?php if(!isset($_POST['llamar_camarero'])): ?>
                
                <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">
                
                <p style="margin-bottom: 20px; font-weight: bold; color: var(--color-navy);">
                    ¿Has terminado de comer?
                </p>

                <form method="POST">
                    <input type="hidden" name="pedido_id" value="<?= htmlspecialchars($_GET['finalizado'] ?? '') ?>">
                    
                    <button type="submit" name="llamar_camarero" class="btn-hero btn-carrito-hero" style="width: 100%; border: none; cursor: pointer; animation: pulse 2s infinite;">
                        🔔 PEDIR LA CUENTA
                    </button>
                </form>

            <?php endif; ?>

            <div style="margin-top: 30px;">
                <a href="index.php" style="color: var(--color-navy); text-decoration: underline;">Volver al inicio</a>
            </div>

        </div>

    <?php else: ?>
        <p>No hay ningún pedido activo.</p>
        <a href="index.php" class="btn-hero btn-carta">Ir al Inicio</a>
    <?php endif; ?>

</main>

<style>
    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(201, 59, 43, 0.7); }
        70% { transform: scale(1.02); box-shadow: 0 0 0 10px rgba(201, 59, 43, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(201, 59, 43, 0); }
    }
</style>

<?php include 'inc/piedepagina.php'; ?>