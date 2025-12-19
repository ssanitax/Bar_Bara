<?php 
include 'inc/cabecera.php'; 

// --- Lógica de procesamiento del formulario ---
$mensaje_estado = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recogemos los datos y los limpiamos para evitar inyecciones de código
    $nombre  = htmlspecialchars($_POST['nombre']);
    $email   = htmlspecialchars($_POST['email']);
    $asunto  = htmlspecialchars($_POST['asunto']);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    // Aquí podrías guardar los mensajes en una tabla 'contacto' de tu BD Bar_Bara
    // O enviar un email. Por ahora, simularemos éxito:
    if (!empty($nombre) && !empty($email) && !empty($mensaje)) {
        $mensaje_estado = "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;'>
            ¡Gracias, <strong>$nombre</strong>! Hemos recibido tu mensaje sobre '$asunto'. Te responderemos pronto a <em>$email</em>.
        </div>";
    } else {
        $mensaje_estado = "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;'>
            Por favor, rellena todos los campos obligatorios.
        </div>";
    }
}
?>

<style>
    .contacto-wrapper { max-width: 900px; margin: 40px auto; padding: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 40px; font-family: sans-serif; }
    .info-bar { background: #2c3e50; color: white; padding: 30px; border-radius: 12px; }
    .info-bar h2 { color: #f1c40f; margin-top: 0; }
    .form-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
    .campo { margin-bottom: 15px; }
    .campo label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
    .campo input, .campo textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
    .btn-enviar { background: #e67e22; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-weight: bold; width: 100%; font-size: 1rem; }
    .btn-enviar:hover { background: #d35400; }
    
    @media (max-width: 768px) { .contacto-wrapper { grid-template-columns: 1fr; } }
</style>

<div class="contacto-wrapper">
    <div class="info-bar">
        <h2>Bar Bara</h2>
        <p>Estaremos encantados de atenderte. Puedes visitarnos o escribirnos directamente.</p>
        <hr style="border: 0; border-top: 1px solid #555; margin: 20px 0;">
        <p><strong>📍 Ubicación:</strong><br>Calle de la Gastronomía, 123<br>28001, Madrid</p>
        <p><strong>📞 Teléfono:</strong><br>+34 912 345 678</p>
        <p><strong>⏰ Horario:</strong><br>Lunes a Domingo<br>12:00h - 00:00h</p>
    </div>

    <div class="form-card">
        <?= $mensaje_estado ?> <form action="contacto.php" method="POST">
            <div class="campo">
                <label>Nombre Completo *</label>
                <input type="text" name="nombre" required placeholder="Ej: Juan Pérez">
            </div>

            <div class="campo">
                <label>Correo Electrónico *</label>
                <input type="email" name="email" required placeholder="tu@email.com">
            </div>

            <div class="campo">
                <label>Asunto</label>
                <input type="text" name="asunto" placeholder="Reserva, sugerencia, queja...">
            </div>

            <div class="campo">
                <label>Mensaje *</label>
                <textarea name="mensaje" rows="5" required placeholder="¿En qué podemos ayudarte?"></textarea>
            </div>

            <button type="submit" class="btn-enviar">ENVIAR AHORA</button>
        </form>
    </div>
</div>

<?php include 'inc/piedepagina.php'; ?>
