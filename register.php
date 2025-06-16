<?php
include 'includes/db.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $password);

    if ($stmt->execute()) {
        $msg = "Registro exitoso. <a href='login.php'>Inicia sesión</a>";
    } else {
        $msg = "Error: " . $stmt->error;
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container">
  <h2>Registro de Usuario</h2>
  <form method="POST">
    <input type="text" name="nombre" placeholder="Nombre completo" required>
    <input type="email" name="email" placeholder="Correo electrónico" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button type="submit">Registrarse</button>
  </form>
  <p><?= $msg ?></p>
</div>
<?php include 'includes/footer.php'; ?>
