<?php 
// 1. Conexión CENTRALIZADA (Mejor práctica que repetir credenciales)
// Subimos un nivel (..) para buscar la conexión en la carpeta back
require_once '../back/inc/conexion_bd.php';

// 2. Cargamos la cabecera
include 'inc/cabecera.php'; 
?>

<link rel="stylesheet" href="css/estilo.css">

<main class="hero-section">
    
    <img src="img/logo_home.png" alt="Bar Bara Logo" class="hero-logo-img">
    
    <h1 class="hero-title">BAR BARA</h1>
    <p class="hero-subtitle">Comida con Carácter & Tragos Rebeldes</p>

    <div class="action-grid">
        
        <a href="catalogo.php" class="btn-hero btn-carta">
            <span class="icon">🍔</span>
            Ver La Carta
        </a>

        <a href="carrito.php" class="btn-hero btn-carrito-hero">
            <span class="icon">🛒</span>
            Mi Pedido
        </a>

        <a href="contacto.php" class="btn-hero btn-contacto">
            <span class="icon">📍</span>
            Contacto / Reservas
        </a>

    </div>

</main>

<?php 
// 3. Cargamos el pie de página
include 'inc/piedepagina.php'; 
?>