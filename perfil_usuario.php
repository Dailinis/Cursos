<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
include 'includes/db.php';
include 'includes/header.php';

$usuario_id = $_SESSION['usuario_id'];
$usuario = $conn->query("SELECT * FROM usuarios WHERE id = $usuario_id")->fetch_assoc();
$cursos = $conn->query("SELECT c.id, c.titulo, c.precio, h.fecha FROM historial h JOIN cursos c ON h.curso_id = c.id WHERE h.usuario_id = $usuario_id ORDER BY h.fecha DESC");
?>
<style>
.container {
    max-width: 900px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}
.profile-box {
    text-align: center;
    margin-bottom: 30px;
}
.profile-box h2 {
    font-size: 28px;
    color: #333;
    margin-bottom: 10px;
}
.profile-box p {
    font-size: 18px;
    color: #666;
    margin: 5px 0;
}
.logout-btn {
    margin-top: 20px;
    display: inline-block;
    background: #dc3545;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
}
.logout-btn:hover {
    background: #bd2130;
}
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
}
.table th, .table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}
.table th {
    background: #f4f4f4;
}
.btn-curso, .btn-cert {
    display: inline-block;
    margin: 4px;
    padding: 6px 12px;
    font-size: 14px;
    border-radius: 6px;
    text-decoration: none;
}
.btn-curso {
    background: #007bff;
    color: white;
}
.btn-cert {
    background: #28a745;
    color: white;
}
</style>
<div class="container">
  <div class="profile-box">
    <h2>Perfil del Usuario</h2>
    <p><strong>Nombre:</strong> <?= $usuario['nombre'] ?></p>
    <p><strong>Correo:</strong> <?= $usuario['correo'] ?></p>
    <p><strong>Tipo:</strong> <?= $usuario['tipo'] ?></p>
    <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
  </div>

  <h3>Mis Cursos</h3>
  <table class="table">
    <tr><th>Curso</th><th>Precio</th><th>Fecha</th><th>Acciones</th></tr>
    <?php while($row = $cursos->fetch_assoc()): ?>
    <tr>
        <td><?= $row['titulo'] ?></td>
        <td>$<?= $row['precio'] ?></td>
        <td><?= $row['fecha'] ?></td>
        <td>
          <a href="course_view.php?id=<?= $row['id'] ?>" class="btn-curso">Ver Curso</a>
          <a href="certificado.php?id=<?= $row['id'] ?>" class="btn-cert">Descargar Certificado</a>
        </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
<?php include 'includes/footer.php'; ?>
