<?php
require_once 'db.php';

$action = $_POST['action'] ?? null;
if ($action === 'add' && isset($_POST['id'], $_POST['quantity'])) {
    add_to_cart(intval($_POST['id']), max(1, intval($_POST['quantity'])));
    header('Location: carrito.php');
    exit;
}

if ($action === 'update' && isset($_POST['id'], $_POST['quantity'])) {
    update_cart_item(intval($_POST['id']), max(0, intval($_POST['quantity'])));
    header('Location: carrito.php');
    exit;
}

if ($action === 'remove' && isset($_POST['id'])) {
    remove_cart_item(intval($_POST['id']));
    header('Location: carrito.php');
    exit;
}

if ($action === 'checkout') {
    // Simular compra: vaciar carrito.
    save_cart([]);
    header('Location: carrito.php');
    exit;
}

$items = get_cart_items($mysqli);
$subtotal = get_cart_total($mysqli);
$tax = 0;
$total = $subtotal + $tax;

require_once 'header.php';
?>

<div class="py-5 bg-light rounded-3 mb-4 home-hero">
    <div class="container">
        <div class="cart-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="display-6 mb-1">Carrito de Compras</h1>
                <p class="text-muted mb-0">Revisa los productos que tienes en el carrito antes de finalizar tu compra.</p>
            </div>
            <a href="Index.php" class="cart-close" aria-label="Cerrar carrito">✕</a>
        </div>
    </div>
</div>

<div class="container cart-panel mb-5">
    <?php if (empty($items)): ?>
        <div class="cart-empty text-center py-5">
            <p class="mb-3">No hay productos en el carrito.</p>
            <a href="categoria.php?categoria=all" class="btn btn-primary">Ver más productos</a>
        </div>
    <?php else: ?>
        <div class="cart-items">
            <?php foreach ($items as $item): ?>
                <?php
                $imagePath = 'Assests/Images/Weapons/' . $item['imagen'];
                $hasImage = !empty($item['imagen']) && file_exists(__DIR__ . '/' . $imagePath);
                ?>
                <div class="cart-item">
                    <div class="cart-item-image">
                        <?php if ($hasImage): ?>
                            <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($item['nombre']) ?>">
                        <?php else: ?>
                            <div class="cart-item-image-empty">Imagen</div>
                        <?php endif; ?>
                    </div>
                    <div class="cart-item-details flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h5 class="cart-item-title mb-1"><?= htmlspecialchars($item['nombre']) ?></h5>
                                <p class="cart-item-meta mb-0">Categoría: <?= htmlspecialchars($item['categoria']) ?></p>
                            </div>
                            <form method="post" action="carrito.php" class="ms-3">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="id" value="<?= intval($item['id_arma']) ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">🗑️</button>
                            </form>
                        </div>
                        <p class="mb-2 text-muted"><?= htmlspecialchars($item['descripcion']) ?></p>
                        <div class="cart-item-bottom d-flex flex-wrap align-items-center gap-3">
                            <form method="post" action="carrito.php" class="d-flex align-items-center gap-2">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="id" value="<?= intval($item['id_arma']) ?>">
                                <button type="submit" name="quantity" value="<?= max(1, $item['quantity'] - 1) ?>" class="btn btn-sm btn-outline-secondary">−</button>
                                <span class="cart-qty"><?= intval($item['quantity']) ?></span>
                                <button type="submit" name="quantity" value="<?= $item['quantity'] + 1 ?>" class="btn btn-sm btn-outline-secondary">+</button>
                            </form>
                            <span class="cart-item-price">$<?= number_format($item['precio'], 2) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary-panel mt-4 p-4 rounded-4">
            <div class="cart-summary-row">
                <div class="cart-summary-info">
                    <div class="cart-summary-line">
                        <span>Subtotal:</span>
                        <strong>$<?= number_format($subtotal, 2) ?></strong>
                    </div>
                    <div class="cart-summary-line">
                        <span>Total:</span>
                        <strong class="total-price">$<?= number_format($total, 2) ?></strong>
                    </div>
                </div>
                <div class="cart-summary-action">
                    <form method="post" action="carrito.php" class="h-100">
                        <input type="hidden" name="action" value="checkout">
                        <button type="submit" class="btn btn-add-cart btn-checkout">Iniciar compra</button>
                    </form>
                </div>
            </div>
            <div class="cart-summary-footer mt-3">
                <a href="categoria.php?categoria=all" class="btn btn-outline-secondary w-100">Ver más productos</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>