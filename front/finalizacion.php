<?php 
session_start();
include 'inc/cabecera.php';
?>

<main class="container" style="text-align: center; padding: 40px 20px;">
    <div style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;">
        <div style="font-size: 4rem; margin-bottom: 20px;">👨‍🍳</div>
        <h1 style="color: #153e5c;">¡Marchando una de...!</h1>
        [cite_start]<p style="font-size: 1.2rem; color: #555;">Tu comanda ha llegado a la cocina y se está preparando ahora mismo.</p>
        
        <div style="margin-top: 30px; display: flex; flex-direction: column; gap: 15px;">
            <a href="catalogo.php" class="btn-hero btn-carta" style="text-decoration: none; padding: 15px;">Pedir otra ronda 🍻</a>
            <a href="historial.php" class="btn-hero btn-contacto" style="text-decoration: none; padding: 15px; background: #153e5c;">Ver resumen de mi mesa 📝</a>
        </div>
    </div>
</main>

<?php include 'inc/piedepagina.php'; ?>
