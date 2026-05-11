<?php
require_once 'header.php';

$errors = [];
$nombre = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (!$nombre) {
        $errors[] = 'El nombre es obligatorio.';
    }
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'El email no es válido.';
    }
    if (strlen($password) < 4) {
        $errors[] = 'La contraseña debe tener al menos 4 caracteres.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Las contraseñas no coinciden.';
    }

    if (empty($errors)) {
        $stmt = $mysqli->prepare('SELECT id_usuario FROM usuarios WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = 'Ya existe una cuenta con este email.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $mysqli->prepare('INSERT INTO usuarios (nombre, email, `contraseña`, rol) VALUES (?, ?, ?, "cliente")');
            $insert->bind_param('sss', $nombre, $email, $hash);
            if ($insert->execute()) {
                set_flash('Registro exitoso. Ahora puedes iniciar sesión.');
                header('Location: login.php');
                exit;
            } else {
                $errors[] = 'Error al crear la cuenta. Intenta nuevamente.';
            }
        }

        $stmt->close();
    }
}
?>
</div>

<div class="auth-page">
    <div class="auth-card">
        <div class="text-center mb-4">
            <div class="page-logo d-inline-flex align-items-center justify-content-center mb-3">
                <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="none">
                    <circle cx="32" cy="32" r="30" fill="#111"/>
                    <path d="M32 32 L50 18 A30 30 0 0 0 14 18 Z" fill="#d92525"/>
                    <path d="M32 32 L46 46 A30 30 0 0 0 18 46 Z" fill="#fff"/>
                    <path d="M32 32 L50 18 A22 22 0 0 1 32 8 Z" fill="#d92525" opacity="0.85"/>
                    <path d="M32 32 L18 46 A22 22 0 0 1 32 56 Z" fill="#d92525" opacity="0.85"/>
                </svg>
            </div>
            <h2 class="auth-title">Crear Cuenta</h2>
        </div>
        <?php if ($errors): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="post" action="register.php">
            <div class="mb-3">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="nombre" class="form-control form-control-dark" value="<?= htmlspecialchars($nombre) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-control form-control-dark" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control form-control-dark" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmar Contraseña</label>
                <input type="password" name="confirm_password" class="form-control form-control-dark" required>
            </div>
            <button type="submit" class="btn btn-auth w-100 mb-3">Crear Cuenta</button>
            <div class="text-center auth-card-footer">
                <p class="mb-0">¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
            </div>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>
