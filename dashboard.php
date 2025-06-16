<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
include 'includes/db.php';

$usuario_id = $_SESSION['usuario_id'];
$usuario = $conn->query("SELECT * FROM usuarios WHERE id = $usuario_id")->fetch_assoc();

$cursos = $conn->query("SELECT c.* FROM cursos c 
    JOIN inscripciones i ON c.id = i.curso_id 
    WHERE i.usuario_id = $usuario_id");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Usuario</title>
  <link rel="stylesheet" href="asset/css/style.css">
  <style>
    body {
      display: flex;
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f4f6f9;
    }
    .sidebar {
      width: 250px;
      background-color: #2c3e50;
      color: white;
      height: 100vh;
      padding: 20px;
      box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }
    .sidebar h2 {
      font-size: 20px;
      margin-bottom: 20px;
    }
    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      margin: 10px 0;
      padding: 10px;
      border-radius: 5px;
      transition: background 0.3s;
    }
    .sidebar a:hover {
      background-color: #34495e;
    }
    .main-content {
      flex: 1;
      padding: 30px;
    }
    .perfil {
      background: white;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 30px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .perfil h2 {
      margin-top: 0;
    }
    .cursos {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .curso {
      border-bottom: 1px solid #ddd;
      padding: 10px 0;
    }
    .curso:last-child {
      border-bottom: none;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <h2>Mi Cuenta</h2>
  <a href="dashboard.php">Inicio</a>
  <a href="perfil_usuario.php">Mi Perfil</a>
  <a href="historial_compras.php">Historial Cursos</a>
  <a href="logout.php">Cerrar Sesión</a>
</div>

<div class="main-content">
  <div class="perfil">
    <h2>Bienvenido, <?= htmlspecialchars($usuario['nombre']) ?></h2>
    <p><strong>Correo:</strong> <?= htmlspecialchars($usuario['correo']) ?></p>
    <p><strong>Tipo:</strong> <?= htmlspecialchars($usuario['tipo']) ?></p>
  </div>

  <div class="cursos">
    <h3>Mis Cursos Inscritos</h3>
    <?php if ($cursos->num_rows > 0): ?>
      <?php while ($curso = $cursos->fetch_assoc()): ?>
        <div class="curso">
          <h4><?= htmlspecialchars($curso['titulo']) ?></h4>
          <p><?= substr(htmlspecialchars($curso['descripcion']), 0, 100) ?>...</p>
          <a href="course_view.php?id=<?= $curso['id'] ?>">Ver Curso</a>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No estás inscrito en ningún curso.</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
