<?php
include 'includes/header.php';
include 'includes/db.php';

$categoria_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$categoria = $conn->query("SELECT nombre FROM categorias WHERE id = $categoria_id")->fetch_assoc();
$cursos = $conn->query("SELECT * FROM cursos WHERE categoria_id = $categoria_id ORDER BY fecha_creado DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cursos de <?= htmlspecialchars($categoria['nombre']) ?></title>
  <link rel="stylesheet" href="asset/css/style.css">
  <style>
    .categoria-cursos {
      padding: 40px;
      background-color: #f5f5f5;
    }
    .categoria-cursos h2 {
      text-align: center;
      color: #333;
      margin-bottom: 30px;
    }
    .curso {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      padding: 20px;
      margin-bottom: 20px;
      transition: transform 0.3s ease;
    }
    .curso:hover {
      transform: scale(1.03);
    }
  </style>
</head>
<body>

<section class="categoria-cursos">
  <h2>Cursos de <?= htmlspecialchars($categoria['nombre']) ?></h2>
  <?php while ($curso = $cursos->fetch_assoc()) { ?>
    <div class="curso">
      <h3><?= htmlspecialchars($curso['titulo']) ?></h3>
      <p><?= substr(htmlspecialchars($curso['descripcion']), 0, 100) ?>...</p>
      <a href="course_view.php?id=<?= $curso['id'] ?>">Ver Curso</a>
    </div>
  <?php } ?>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>
