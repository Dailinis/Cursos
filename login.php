<?php
session_start();
include 'includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['contrasena'];

    $stmt = $conn->prepare("SELECT id, nombre, contrasena, tipo FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $nombre, $hash, $tipo);
        $stmt->fetch();

        if (password_verify($pass, $hash)) {
            $_SESSION['usuario_id'] = $id;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['tipo'] = $tipo;
            header("Location: " . ($tipo === 'admin' ? 'admin/index.php' : 'dashboard.php'));
            exit;
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="asset/css/style.css">
</head>
<?php include 'includes/header.php'; ?>
<div class="container">
  <h2>Iniciar Sesión</h2>
  <form method="POST">
    <input type="email" name="email" placeholder="Correo electrónico" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button type="submit">Entrar</button>
  </form>
  <p style="color:red"><?= $error ?></p>
</div>
<?php include 'includes/footer.php'; ?>
