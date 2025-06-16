<?php
include 'includes/db.php';
$busqueda = $_GET['q'] ?? '';
$stmt = $conn->prepare("SELECT * FROM cursos WHERE titulo LIKE CONCAT('%', ?, '%')");
$stmt->bind_param("s", $busqueda);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<?php include 'includes/header.php'; ?>
<div class="container">
  <h2>Resultados de búsqueda: "<?= htmlspecialchars($busqueda) ?>"</h2>
  <?php while ($curso = $resultado->fetch_assoc()): ?>
    <div class="card">
      <h3><?= $curso['titulo'] ?></h3>
      <p><?= substr($curso['descripcion'], 0, 100) ?>...</p>
    </div>
  <?php endwhile; ?>
</div>
<?php include 'includes/footer.php'; ?>
