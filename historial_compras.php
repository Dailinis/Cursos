<?php
$curso_id = $_GET['id'] ?? 0;
session_start();
include 'includes/db.php';
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$curso = $conn->query("SELECT * FROM cursos WHERE id = $curso_id")->fetch_assoc();
if (!$curso) {
    echo "Curso no encontrado";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$fecha = date('Y-m-d H:i:s');
$conn->query("INSERT INTO historial (usuario_id, curso_id, fecha) VALUES ($usuario_id, $curso_id, '$fecha')");

echo "<h2>Pago de PayPal simulado para el curso: {$curso['titulo']}</h2>";
echo "<p>Precio: $ {$curso['precio']}</p>";
echo "<p><strong>Pago exitoso registrado</strong></p>";
?>
