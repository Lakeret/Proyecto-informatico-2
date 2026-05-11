<?php require_once 'header.php';
$armas = [];
$result = $mysqli->query('SELECT * FROM armas LIMIT 3');
while ($row = $result->fetch_assoc()) {
    $armas[] = $row;
}
$result->free();

$countArmas = $mysqli->query('SELECT COUNT(*) AS total FROM armas')->fetch_assoc()['total'];
$countUsuarios = $mysqli->query('SELECT COUNT(*) AS total FROM usuarios')->fetch_assoc()['total'];
?>

<div class="py-5 text-center bg-light rounded-3 mb-4">
    <div class="container">
        <h1 class="display-5">Bienvenido a la Tienda de Armas</h1>
        <p class="lead">Compra armas de colección y equipamiento táctico con seguridad. Regístrate o inicia sesión para comenzar.</p>
        <?php if (!is_logged_in()): ?>
            <a href="register.php" class="btn btn-primary btn-lg me-2">Registrarse</a>
            <a href="login.php" class="btn btn-outline-secondary btn-lg">Iniciar sesión</a>
        <?php else: ?>
            <a href="Index.php" class="btn btn-primary btn-lg">Ver más</a>
        <?php endif; ?>
    </div>
</div>

<div id="mainCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner rounded-3 overflow-hidden shadow-sm">
        <div class="carousel-item active">
            <img src="https://via.placeholder.com/1200x450?text=Armas+Premium" class="d-block w-100" alt="Armas Premium">
            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                <h5>Armamento de calidad</h5>
                <p>Explora pistolas, rifles, escopetas y más en nuestro catálogo.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://via.placeholder.com/1200x450?text=Compra+Segura" class="d-block w-100" alt="Compra Segura">
            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                <h5>Compra segura</h5>
                <p>Tu información y pedidos están protegidos en cada paso.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://via.placeholder.com/1200x450?text=Envío+Rápido" class="d-block w-100" alt="Envío Rápido">
            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                <h5>Envío confiable</h5>
                <p>Recibe tus armas y accesorios con seguimiento seguro.</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Variedad de armas</h5>
                <p class="card-text">Pistolas, rifles, escopetas y subfusiles disponibles para clientes registrados.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Pagos rápidos</h5>
                <p class="card-text">Gestión de pagos, historial y estado de compras con un solo clic.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Atención al cliente</h5>
                <p class="card-text">Soporte para clientes y administración disponible para ayudarte.</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="p-4 bg-primary text-white rounded-3 shadow-sm">
            <h3><?= intval($countArmas) ?></h3>
            <p>Armas en catálogo</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-4 bg-success text-white rounded-3 shadow-sm">
            <h3><?= intval($countUsuarios) ?></h3>
            <p>Usuarios registrados</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-4 bg-secondary text-white rounded-3 shadow-sm">
            <h3>3</h3>
            <p>Productos destacados</p>
        </div>
    </div>
</div>

<h2 class="mb-3">Productos destacados</h2>
<div class="row">
    <?php foreach ($armas as $arma): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="https://via.placeholder.com/600x350?text=<?= urlencode($arma['nombre']) ?>" class="card-img-top" alt="<?= htmlspecialchars($arma['nombre']) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($arma['nombre']) ?></h5>
                    <p class="card-text"><strong>Marca:</strong> <?= htmlspecialchars($arma['marca']) ?></p>
                    <p class="card-text"><strong>Categoría:</strong> <?= htmlspecialchars($arma['categoria']) ?></p>
                    <p class="card-text"><?= htmlspecialchars($arma['descripcion']) ?></p>
                </div>
                <div class="card-footer bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-primary fs-5">$<?= number_format($arma['precio'], 2) ?></span>
                        <span class="badge bg-<?= $arma['stock'] > 0 ? 'success' : 'danger' ?>">Stock: <?= intval($arma['stock']) ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once 'footer.php'; ?>
