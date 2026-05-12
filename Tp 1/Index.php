<?php require_once 'header.php'; ?>

<div class="py-5 text-center bg-light rounded-3 mb-4 home-hero">
    <div class="container">
        <h1 class="display-5">Bienvenido a la Tienda de Armas</h1>
        <?php if (!is_logged_in()): ?>
            <p class="lead">Explora nuestro sitio y regístrate o inicia sesión para ver el catálogo completo.</p>
        <?php else: ?>
            <p class="lead">Ya has iniciado sesión. Ahora puedes navegar por el catálogo completo y ver todas las armas disponibles.</p>
        <?php endif; ?>
        <?php if (!is_logged_in()): ?>
            <a href="register.php" class="btn btn-primary btn-lg me-2">Registrarse</a>
            <a href="login.php" class="btn btn-outline-secondary btn-lg">Iniciar sesión</a>
        <?php else: ?>
            <a href="categoria.php?categoria=all" class="btn btn-primary btn-lg">Ver catálogo</a>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'footer.php'; ?>
