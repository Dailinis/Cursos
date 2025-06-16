<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$curso_id = (int)$_GET['id'];

// Verificar si ya está inscrito
$stmt = $conn->prepare("SELECT * FROM historial WHERE usuario_id = ? AND curso_id = ?");
$stmt->bind_param("ii", $usuario_id, $curso_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    header("Location: dashboard.php?mensaje=ya_inscrito");
    exit;
}

// Insertar inscripción
$stmt = $conn->prepare("INSERT INTO historial (usuario_id, curso_id, fecha) VALUES (?, ?, NOW())");
$stmt->bind_param("ii", $usuario_id, $curso_id);

if ($stmt->execute()) {
    header("Location: dashboard.php?mensaje=inscripcion_exitosa");
} else {
    echo "Error al inscribirse: " . $stmt->error;
}
?>
