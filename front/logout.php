<?php
// front/logout.php
session_start();

// Destruimos todas las variables de sesión (nombre, id, carrito...)
session_destroy();

// Redirigimos al usuario a la portada
header("Location: index.php");
exit;
?>