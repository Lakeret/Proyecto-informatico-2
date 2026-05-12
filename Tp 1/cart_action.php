<?php
require_once 'db.php';

$action = $_POST['action'] ?? '';
$id = intval($_POST['id'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 1);
$redirect = $_POST['redirect'] ?? ($_SERVER['HTTP_REFERER'] ?? 'Index.php');

if ($action === 'add' && $id > 0) {
    add_to_cart($id, max(1, $quantity));
}

if ($action === 'update' && $id > 0) {
    update_cart_item($id, max(0, $quantity));
}

if ($action === 'remove' && $id > 0) {
    remove_cart_item($id);
}

if ($action === 'checkout') {
    // Aquí puedes agregar lógica de pago o confirmación antes de vaciar el carrito.
    // Por ahora simplemente dejamos intacto el carrito y redirigimos de vuelta.
}

$redirect = filter_var($redirect, FILTER_SANITIZE_URL);
header('Location: ' . $redirect);
exit;
