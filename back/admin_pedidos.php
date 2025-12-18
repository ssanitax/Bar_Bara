// Consulta para el camarero
$alertas = $pdo->query("SELECT numero_mesa FROM pedido WHERE pedir_cuenta = 'SOLICITADA'")->fetchAll();

foreach($alertas as $aviso) {
    echo "<div class='alerta'>¡MESA {$aviso['numero_mesa']} PIDE LA CUENTA!</div>";
}