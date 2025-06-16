<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
include 'includes/db.php';

$curso_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$usuario_id = $_SESSION['usuario_id'];

$stmt = $conn->prepare("SELECT c.titulo, u.nombre, h.fecha FROM historial h JOIN cursos c ON h.curso_id = c.id JOIN usuarios u ON h.usuario_id = u.id WHERE h.usuario_id = ? AND h.curso_id = ?");
$stmt->bind_param("ii", $usuario_id, $curso_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    echo "<p>No tienes acceso a este certificado.</p>";
    exit;
}
$datos = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Certificado</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f9f9f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .certificado {
      background: white;
      padding: 40px;
      width: 900px;
      border: 10px solid #4CAF50;
      text-align: center;
      box-shadow: 0 0 25px rgba(0,0,0,0.15);
      position: relative;
    }
    .certificado img.logo {
      position: absolute;
      top: 30px;
      left: 30px;
      height: 80px;
    }
    .certificado h1 {
      font-size: 36px;
      color: #333;
      margin-top: 20px;
    }
    .certificado p {
      font-size: 20px;
      color: #555;
      margin: 20px 0;
    }
    .boton-imprimir {
      margin-top: 30px;
      padding: 10px 20px;
      background: #4CAF50;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
    }
    .firma {
      margin-top: 60px;
      text-align: right;
      padding-right: 60px;
      font-style: italic;
      color: #666;
    }
  </style>
</head>
<body>
  <div class="certificado">
    <img src="img/logo.png" class="logo" alt="Logo del sitio">
    <h1>Certificado de Finalización</h1>
    <p>Otorgado a <strong><?= $datos['nombre'] ?></strong></p>
    <p>por haber completado satisfactoriamente el curso</p>
    <p><strong><?= $datos['titulo'] ?></strong></p>
    <p>en fecha <strong><?= date("d/m/Y", strtotime($datos['fecha'])) ?></strong></p>
    <div class="firma">
      __________________________<br>
      Dirección Académica<br>
      CursosOnline.com
    </div>
    <button class="boton-imprimir" onclick="window.print()">Imprimir / Guardar PDF</button>
  </div>
</body>
</html>
