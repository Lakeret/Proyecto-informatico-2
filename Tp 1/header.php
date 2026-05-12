<?php
require_once 'db.php';
$user = current_user();
$bodyClass = strtolower(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME));
$cartItems = get_cart_items($mysqli);
$cartSubtotal = get_cart_total($mysqli);
$cartTotalQuantity = array_sum(array_column($cartItems, 'quantity')) ?: 0;
$currentUrl = htmlspecialchars($_SERVER['REQUEST_URI']);
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Umbrella Corporation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-IuuyQ5zNqcM8IRLz3hTjN4wFUmRbFYoURHoOH25V+rYpFr7mY7L2Xx04wVlTAk8kw" crossorigin="anonymous">
    <link href="Assests/css/Styles.css" rel="stylesheet">
</head>
<body class="<?= htmlspecialchars($bodyClass) ?>">
<header class="site-header">
    <div class="top-strip py-2">
        <div class="container-fluid d-flex justify-content-end align-items-center gap-3">
            <?php if (!$user): ?>
                <a href="login.php" class="top-link">Iniciar sesión</a>
                <a href="register.php" class="top-link">Registrarse</a>
            <?php else: ?>
                <span class="top-username"><?= htmlspecialchars($user['nombre']) ?></span>
                <a href="logout.php" class="top-link">Cerrar sesión</a>
            <?php endif; ?>
            <button type="button" class="top-cart" id="cartToggle" aria-label="Abrir carrito">
                🛒
                <?php if ($cartTotalQuantity > 0): ?>
                    <span class="cart-badge"><?= $cartTotalQuantity ?></span>
                <?php endif; ?>
            </button>
        </div>
    </div>
    <div class="brand-strip py-4">
        <div class="container d-flex flex-column align-items-center gap-3 text-center">
            <a class="brand d-flex align-items-center gap-3" href="Index.php">
                <span class="umbrella-logo" aria-hidden="true">
                    <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="none">
                        <circle cx="32" cy="32" r="30" fill="#111"/>
                        <path d="M32 32 L50 18 A30 30 0 0 0 14 18 Z" fill="#d92525"/>
                        <path d="M32 32 L46 46 A30 30 0 0 0 18 46 Z" fill="#fff"/>
                        <path d="M32 32 L50 18 A22 22 0 0 1 32 8 Z" fill="#d92525" opacity="0.85"/>
                        <path d="M32 32 L18 46 A22 22 0 0 1 32 56 Z" fill="#d92525" opacity="0.85"/>
                    </svg>
                </span>
                <div>
                    <div class="brand-name">Umbrella Corporation</div>
                    <div class="brand-subtitle">Tienda de armas y equipamiento</div>
                </div>
            </a>
            <form class="search-form d-flex" action="#" method="get">
                <input type="search" name="q" class="form-control search-input" placeholder="Buscar en toda la tienda..." aria-label="Buscar">
                <button type="submit" class="btn btn-search">Buscar</button>
            </form>
        </div>
    </div>

    <?php if (!empty($pageBreadcrumb)): ?>
        <div class="breadcrumb-row container">
            <?= $pageBreadcrumb ?>
        </div>
    <?php endif; ?>
</header>
<nav class="navbar navbar-expand-lg navbar-dark umbrella-nav py-0">
    <div class="container-fluid">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="weaponsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Armas
                </a>
                <div class="dropdown-menu megamenu" aria-labelledby="weaponsDropdown">
                    <div class="megamenu-content">
                        <div class="megamenu-column">
                            <h6 class="megamenu-title">Rifles</h6>
                            <a class="dropdown-item" href="categoria.php?categoria=Rifle">Ver Rifles</a>
                        </div>
                        <div class="megamenu-column">
                            <h6 class="megamenu-title">Pistolas</h6>
                            <a class="dropdown-item" href="categoria.php?categoria=Pistola">Ver Pistolas</a>
                        </div>
                        <div class="megamenu-column">
                            <h6 class="megamenu-title">Escopetas</h6>
                            <a class="dropdown-item" href="categoria.php?categoria=Escopeta">Ver Escopetas</a>
                        </div>
                        <div class="megamenu-column">
                            <h6 class="megamenu-title">Ametralladoras</h6>
                            <a class="dropdown-item" href="categoria.php?categoria=Ametralladora">Ver Ametralladoras</a>
                        </div>
                        <div class="megamenu-column">
                            <h6 class="megamenu-title">Subfusiles</h6>
                            <a class="dropdown-item" href="categoria.php?categoria=Subfusil">Ver Subfusiles</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="cart-drawer-backdrop" id="cartBackdrop"></div>
<div class="cart-drawer" id="cartDrawer">
    <div class="cart-drawer-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Carrito de Compras</h2>
            <p class="mb-0 text-muted">Puedes seguir viendo el catálogo mientras lo revisas.</p>
        </div>
        <button type="button" class="cart-drawer-close" id="cartClose" aria-label="Cerrar carrito">✕</button>
    </div>
    <div class="cart-drawer-body">
        <?php if (empty($cartItems)): ?>
            <div class="cart-empty-state">
                <p>No hay productos en el carrito.</p>
                <a href="categoria.php?categoria=all" class="btn btn-outline-secondary btn-sm">Ver más productos</a>
            </div>
        <?php else: ?>
            <?php foreach ($cartItems as $item): ?>
                <?php
                $imagePath = 'Assests/Images/Weapons/' . $item['imagen'];
                $hasImage = !empty($item['imagen']) && file_exists(__DIR__ . '/' . $imagePath);
                ?>
                <div class="cart-drawer-item d-flex gap-3 align-items-start">
                    <div class="cart-drawer-thumb">
                        <?php if ($hasImage): ?>
                            <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($item['nombre']) ?>">
                        <?php else: ?>
                            <span>Imagen</span>
                        <?php endif; ?>
                    </div>
                    <div class="cart-drawer-info flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <h5 class="mb-1"><?= htmlspecialchars($item['nombre']) ?></h5>
                                <p class="mb-1 text-muted">Categoría: <?= htmlspecialchars($item['categoria']) ?></p>
                            </div>
                            <form method="post" action="cart_action.php" class="cart-remove-form">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="id" value="<?= intval($item['id_arma']) ?>">
                                <input type="hidden" name="redirect" value="<?= $currentUrl ?>">
                                <button type="submit" class="cart-remove-btn" aria-label="Eliminar producto">🗑️</button>
                            </form>
                        </div>
                        <div class="d-flex gap-2 align-items-center cart-qty-row">
                            <form method="post" action="cart_action.php" class="cart-qty-form d-flex align-items-center gap-2">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="id" value="<?= intval($item['id_arma']) ?>">
                                <input type="hidden" name="redirect" value="<?= $currentUrl ?>">
                                <button type="submit" name="quantity" value="<?= max(1, $item['quantity'] - 1) ?>" class="qty-control">−</button>
                                <span class="qty-value"><?= intval($item['quantity']) ?></span>
                                <button type="submit" name="quantity" value="<?= $item['quantity'] + 1 ?>" class="qty-control">+</button>
                            </form>
                            <span class="cart-item-price">$<?= number_format($item['precio'], 2) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="cart-drawer-footer">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span>Subtotal</span>
            <strong>$<?= number_format($cartSubtotal, 2) ?></strong>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span>Total</span>
            <strong class="cart-total-price">$<?= number_format($cartSubtotal, 2) ?></strong>
        </div>
        <div class="d-grid gap-2">
            <form method="post" action="cart_action.php">
                <input type="hidden" name="action" value="checkout">
                <input type="hidden" name="redirect" value="<?= $currentUrl ?>">
                <button type="submit" class="btn btn-primary">Iniciar compra</button>
            </form>
            <a href="categoria.php?categoria=all" class="btn btn-outline-secondary">Ver más productos</a>
        </div>
    </div>
</div>
<div class="container mt-4">
