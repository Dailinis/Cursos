<?php
session_start();
include 'includes/db.php';

$curso_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT c.*, cat.nombre AS categoria FROM cursos c JOIN categorias cat ON c.categoria_id = cat.id WHERE c.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo "<p>Curso no encontrado.</p>";
  exit;
}
$curso = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($curso['titulo']) ?></title>
  <link rel="stylesheet" href="asset/css/style.css">
  <style>
    .curso-container {
      max-width: 800px;
      margin: 40px auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .curso-container h1 {
      color: #333;
    }
    .curso-container p {
      font-size: 16px;
      line-height: 1.6;
    }
    .boton-inscripcion {
      margin-top: 20px;
      display: inline-block;
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      text-decoration: none;
      color: white;
    }
    .gratis {
      background-color: #28a745;
    }
    .pago {
      background-color: #007bff;
    }
    .pago:hover, .gratis:hover {
      opacity: 0.9;
    }
  </style>
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <div class="curso-container">
    <h1><?= htmlspecialchars($curso['titulo']) ?></h1>
    <p><strong>Categoría:</strong> <?= htmlspecialchars($curso['categoria']) ?></p>
    <p><strong>Precio:</strong> <?= $curso['precio'] == 0 ? 'Gratis' : '$' . number_format($curso['precio'], 2) ?></p>
    <p><?= nl2br(htmlspecialchars($curso['descripcion'])) ?></p>

    <?php if (isset($_SESSION['usuario_id'])): ?>
      <?php if ($curso['precio'] == 0): ?>
        <a class="boton-inscripcion gratis" href="inscribirse.php?curso_id=<?= $curso['id'] ?>">Inscribirse Gratis</a>
      <?php else: ?>
        <form action="pago_paypal.php" method="POST">
          <input type="hidden" name="curso_id" value="<?= $curso['id'] ?>">
          <input type="hidden" name="precio" value="<?= $curso['precio'] ?>">
          <button type="submit" class="boton-inscripcion pago">Pagar con PayPal</button>
        </form>
      <?php endif; ?>
    <?php else: ?>
      <p><a href="login.php">Inicia sesión</a> para inscribirte en este curso.</p>
    <?php endif; ?>
  </div>

  <?php include 'includes/footer.php'; ?>
</body>
</html>
