<?php
require_once 'db.php';
$user = current_user();
$flash = flash_message();
$bodyClass = strtolower(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Umbrella Corporation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-IuuyQ5zNqcM8IRLz3hTjN4wFUmRbFYoURHoOH25V+rYpFr7mY7L2Xx04wVlTAk8kw" crossorigin="anonymous">
    <link href="Assests/css/Styles.css" rel="stylesheet">
</head>
<body class="<?= htmlspecialchars($bodyClass) ?>">
<nav class="navbar navbar-expand-lg navbar-dark umbrella-nav">
    <div class="container nav-center-container">
        <a class="navbar-brand centered-brand d-flex align-items-center gap-2" href="Index.php">
            <span class="umbrella-logo" aria-hidden="true">
                <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="none">
                    <circle cx="32" cy="32" r="30" fill="#111"/>
                    <path d="M32 32 L50 18 A30 30 0 0 0 14 18 Z" fill="#d92525"/>
                    <path d="M32 32 L46 46 A30 30 0 0 0 18 46 Z" fill="#fff"/>
                    <path d="M32 32 L50 18 A22 22 0 0 1 32 8 Z" fill="#d92525" opacity="0.85"/>
                    <path d="M32 32 L18 46 A22 22 0 0 1 32 56 Z" fill="#d92525" opacity="0.85"/>
                </svg>
            </span>
            Umbrella Corporation
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="Index.php">Home</a></li>
                <?php if (!$user): ?>
                    <li class="nav-item"><a class="nav-link" href="register.php">Registro</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                <?php endif; ?>
            </ul>
            <?php if ($user): ?>
                <span class="navbar-text text-white">Bienvenido, <?= htmlspecialchars($user['nombre']) ?></span>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <?php if ($flash): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($flash) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
