<?php
require_once 'header.php';

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Ingrese un email válido.';
    }
    if (!$password) {
        $errors[] = 'Ingrese la contraseña.';
    }

    if (empty($errors)) {
        $stmt = $mysqli->prepare('SELECT id_usuario, nombre, email, `contraseña`, rol FROM usuarios WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        $stmt->close();

        if ($userData) {
            $storedPassword = $userData['contraseña'];
            $validPassword = false;

            if (password_get_info($storedPassword)['algo']) {
                $validPassword = password_verify($password, $storedPassword);
            } else {
                $validPassword = $password === $storedPassword;
                if ($validPassword) {
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $update = $mysqli->prepare('UPDATE usuarios SET `contraseña` = ? WHERE id_usuario = ?');
                    $update->bind_param('si', $newHash, $userData['id_usuario']);
                    $update->execute();
                    $update->close();
                }
            }

            if ($validPassword) {
                $_SESSION['user'] = [
                    'id_usuario' => $userData['id_usuario'],
                    'nombre' => $userData['nombre'],
                    'email' => $userData['email'],
                    'rol' => $userData['rol']
                ];
                set_flash('Has iniciado sesión correctamente.');
                header('Location: Index.php');
                exit;
            }
        }

        $errors[] = 'Email o contraseña incorrectos.';
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
            <h2 class="auth-title">Iniciar Sesión</h2>
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
        <form method="post" action="login.php">
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-control form-control-dark" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control form-control-dark" required>
            </div>
            <button type="submit" class="btn btn-auth w-100 mb-3">Iniciar sesión</button>
            <div class="text-center auth-card-footer">
                <p class="mb-0">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
            </div>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>
