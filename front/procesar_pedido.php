<?php
session_start();

// Conectamos saliendo una carpeta hacia atrás (del front al back)
include '../back/inc/conexion_bd.php';

// Verificamos que se haya pulsado el botón
if (isset($_POST['confirmar_pedido'])) {

    // 1. Recoger datos básicos del formulario y sesión
    $numero_mesa = $_POST['numero_mesa'];
    $total = $_POST['total_pagar'];
    $fecha = date('Y-m-d H:i:s'); // Fecha y hora actual
    $estado = 'pendiente'; // Estado inicial por defecto

    // 2. Insertar el PEDIDO GENERAL en la base de datos
    // Nota: Ajusta los nombres de columnas si son diferentes en tu BD
    $sql_pedido = "INSERT INTO pedidos (numero_mesa, fecha, total, estado) 
                   VALUES ('$numero_mesa', '$fecha', '$total', '$estado')";
    
    $resultado = mysqli_query($conexion, $sql_pedido);

    if ($resultado) {
        // Si se guardó el pedido, obtenemos el ID que la BD le acaba de dar
        $id_pedido = mysqli_insert_id($conexion);

        // 3. Recorrer el carrito para guardar cada producto en DETALLES_PEDIDO
        foreach ($_SESSION['carrito'] as $producto) {
            $id_producto = $producto['id']; 
            $cantidad = $producto['cantidad'];
            $precio = $producto['precio'];

            $sql_detalle = "INSERT INTO detalles_pedido (id_pedido, id_producto, cantidad, precio) 
                            VALUES ('$id_pedido', '$id_producto', '$cantidad', '$precio')";
            
            mysqli_query($conexion, $sql_detalle);
        }

        // 4. Vaciar el carrito porque ya se compró
        unset($_SESSION['carrito']);

        // 5. Redirigir a la página de "Gracias por su compra"
        header("Location: finalizacion.php");
        exit;

    } else {
        // Error simple si falla la consulta
        echo "Error al guardar el pedido: " . mysqli_error($conexion);
    }

} else {
    // Si intentan entrar a esta página sin enviar el formulario, los mandamos al inicio
    header("Location: index.php");
}
?>