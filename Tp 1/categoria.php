<?php
require_once 'header.php';

$category = trim($_GET['categoria'] ?? '');
$categoryLabels = [
    'all' => 'Catálogo Completo',
    'Pistola' => 'Pistolas',
    'Rifle' => 'Rifles',
    'Escopeta' => 'Escopetas',
    'Ametralladora' => 'Ametralladoras',
    'Subfusil' => 'Subfusiles'
];

if (!$category || !array_key_exists($category, $categoryLabels)) {
    header('Location: Index.php');
    exit;
}

if ($category === 'all') {
    $stmt = $mysqli->prepare('SELECT * FROM armas');
} else {
    $stmt = $mysqli->prepare('SELECT * FROM armas WHERE categoria = ?');
    $stmt->bind_param('s', $category);
}
$stmt->execute();
$result = $stmt->get_result();
$armas = [];
while ($row = $result->fetch_assoc()) {
    $armas[] = $row;
}
$stmt->close();
?>

<div class="py-5 text-center bg-light rounded-3 mb-4 home-hero">
    <div class="container">
        <h1 class="display-5">Categoría: <?= htmlspecialchars($categoryLabels[$category]) ?></h1>
        <p class="lead">Explora las armas disponibles en esta categoría.</p>
        <a href="Index.php" class="btn btn-outline-secondary btn-lg mt-3">Volver al inicio</a>
    </div>
</div>

<div class="row g-4">
    <?php if (empty($armas)): ?>
        <div class="col-12">
            <div class="alert alert-warning text-center" role="alert">
                No hay armas disponibles en esta categoría por el momento.
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($armas as $arma): ?>
            <?php
            $imagePath = 'Assests/Images/Weapons/' . $arma['imagen'];
            $imageSrc = '';
            if (!empty($arma['imagen']) && file_exists(__DIR__ . '/' . $imagePath)) {
                $imageSrc = $imagePath;
            }
            ?>
            <div class="col-12">
                <div class="weapon-row p-4 mb-4 rounded-4 shadow-sm">
                    <?php if ($imageSrc): ?>
                        <div class="weapon-image me-4">
                            <img src="<?= htmlspecialchars($imageSrc) ?>" alt="<?= htmlspecialchars($arma['nombre']) ?>">
                        </div>
                    <?php endif; ?>
                    <div class="weapon-details">
                        <h4 class="weapon-name mb-2"><a href="arma.php?id=<?= intval($arma['id_arma']) ?>" class="weapon-link"><?= htmlspecialchars($arma['nombre']) ?></a></h4>
                        <p class="mb-1"><strong>Marca:</strong> <?= htmlspecialchars($arma['marca']) ?></p>
                        <p class="mb-1"><strong>Categoría:</strong> <?= htmlspecialchars($arma['categoria']) ?></p>
                        <p class="mb-2"><?= htmlspecialchars($arma['descripcion']) ?></p>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <span class="weapon-price">$<?= number_format($arma['precio'], 2) ?></span>
                            <span class="badge bg-<?= $arma['stock'] > 0 ? 'success' : 'danger' ?>">Stock: <?= intval($arma['stock']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>
