<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tienda_armas');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');

function is_logged_in() {
    return !empty($_SESSION['user']);
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function flash_message() {
    if (!empty($_SESSION['flash'])) {
        $message = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $message;
    }
    return null;
}

function set_flash($message) {
    $_SESSION['flash'] = $message;
}

function get_cart() {
    return $_SESSION['cart'] ?? [];
}

function save_cart(array $cart) {
    $_SESSION['cart'] = $cart;
}

function add_to_cart(int $id, int $quantity = 1) {
    $cart = get_cart();
    if (isset($cart[$id])) {
        $cart[$id] += $quantity;
    } else {
        $cart[$id] = $quantity;
    }
    if ($cart[$id] < 1) {
        unset($cart[$id]);
    }
    save_cart($cart);
}

function update_cart_item(int $id, int $quantity) {
    $cart = get_cart();
    if ($quantity < 1) {
        unset($cart[$id]);
    } else {
        $cart[$id] = $quantity;
    }
    save_cart($cart);
}

function remove_cart_item(int $id) {
    $cart = get_cart();
    if (isset($cart[$id])) {
        unset($cart[$id]);
    }
    save_cart($cart);
}

function get_cart_items(mysqli $mysqli) {
    $cart = get_cart();
    if (empty($cart)) {
        return [];
    }

    $ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids));
    $stmt = $mysqli->prepare("SELECT * FROM armas WHERE id_arma IN ($placeholders)");
    if (!$stmt) {
        return [];
    }
    $stmt->bind_param($types, ...$ids);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $row['quantity'] = $cart[$row['id_arma']] ?? 1;
        $items[] = $row;
    }
    $stmt->close();
    return $items;
}

function get_cart_total(mysqli $mysqli) {
    $items = get_cart_items($mysqli);
    $subtotal = 0;
    foreach ($items as $item) {
        $subtotal += floatval($item['precio']) * intval($item['quantity']);
    }
    return $subtotal;
}
