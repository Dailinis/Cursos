<?php
$curso_id = $_GET['id'] ?? 0;
include 'includes/db.php';
$curso = $conn->query("SELECT * FROM cursos WHERE id = $curso_id")->fetch_assoc();
if (!$curso) {
    echo "Curso no encontrado";
    exit;
}

// Aquí usarías la API real de PayPal. Esto es solo una simulación:
echo "<h2>Simulando pago de PayPal para el curso: {$curso['titulo']}</h2>";
echo "<p>Precio: $ {$curso['precio']}</p>";
echo "<p><strong>Pago exitoso (simulado)</strong></p>";

// Aquí puedes guardar en la base de datos que el curso fue comprado por el usuario.
?>
