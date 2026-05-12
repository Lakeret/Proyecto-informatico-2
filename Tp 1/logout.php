<?php
require_once 'db.php';
session_unset();
session_destroy();
session_start();
set_flash('Has cerrado sesión correctamente.');
header('Location: Index.php');
exit;