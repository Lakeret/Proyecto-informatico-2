<?php
require_once 'db.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: Index.php');
    exit;
}

$stmt = $mysqli->prepare('SELECT * FROM armas WHERE id_arma = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$arma = $result->fetch_assoc();
$stmt->close();

if (!$arma) {
    header('Location: Index.php');
    exit;
}

$categoryName = htmlspecialchars($arma['categoria']);
$weaponName = htmlspecialchars($arma['nombre']);
$description = htmlspecialchars($arma['descripcion']);
$price = number_format($arma['precio'], 2);
$stock = intval($arma['stock']);
$brand = htmlspecialchars($arma['marca']);

$pageBreadcrumb = '<div class="page-breadcrumb">
    <a href="Index.php">Inicio</a>
    <span class="breadcrumb-sep">›</span>
    <a href="categoria.php?categoria=all">Armas</a>
    <span class="breadcrumb-sep">›</span>
    <a href="categoria.php?categoria=' . urlencode($arma['categoria']) . '">' . $categoryName . '</a>
    <span class="breadcrumb-sep">›</span>
    <span class="breadcrumb-current">' . $weaponName . '</span>
</div>';

require_once 'header.php';
?>

<div class="py-5 text-center bg-light rounded-3 mb-4 home-hero">
    <div class="container">
        <h1 class="display-5"><?= $weaponName ?></h1>
        <p class="lead">Información detallada del arma seleccionada.</p>
    </div>
</div>

<div class="arma-detail container">
    <div class="arma-image-placeholder">
        <span>Espacio reservado para imágenes del arma</span>
    </div>

    <div class="arma-details-panel">
        <h2 class="arma-title"><?= $weaponName ?></h2>
        <div class="arma-meta">
            <div class="arma-meta-item">Categoría: <?= $categoryName ?></div>
            <div class="arma-meta-item">Marca: <?= $brand ?></div>
            <div class="arma-meta-item">Referencia: <?= intval($arma['id_arma']) ?></div>
        </div>

        <p class="arma-description"><?= $description ?></p>

        <div class="arma-price-row">
            <div class="arma-price">$<?= $price ?></div>
            <form method="post" action="cart_action.php" class="arma-add-cart-form">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="id" value="<?= intval($arma['id_arma']) ?>">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <button type="submit" class="btn btn-add-cart">Agregar al carrito</button>
            </form>
        </div>
        <div class="arma-stock">
            <span><?= $stock > 0 ? 'En stock: ' . $stock : 'Sin stock' ?></span>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>