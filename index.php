<?php
include 'header.php';
include 'conexion.php'; // Tu archivo de conexión a la base de datos
?>

<!-- Estilos personalizados -->
<style>
    .hero-slider {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        color: white;
        padding: 60px 20px;
        text-align: center;
    }

    .hero-slider h1 {
        font-size: 48px;
        margin-bottom: 10px;
    }

    .hero-slider p {
        font-size: 20px;
        margin-bottom: 20px;
    }

    .course-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 40px 20px;
        justify-content: center;
        background-color: #f4f4f4;
    }

    .course-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        overflow: hidden;
        width: 280px;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
    }

    .course-card:hover {
        transform: scale(1.02);
    }

    .course-card img {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }

    .course-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .course-content h3 {
        margin: 0 0 10px;
        font-size: 20px;
    }

    .course-content p {
        flex: 1;
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
    }

    .btn-inscribirse {
        padding: 10px;
        text-align: center;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s;
    }

    .btn-gratis {
        background-color: #28a745;
        color: white;
    }

    .btn-gratis:hover {
        background-color: #218838;
    }

    .btn-pagar {
        background-color: #ffc107;
        color: black;
    }

    .btn-pagar:hover {
        background-color: #e0a800;
    }
</style>

<!-- Hero/Slider -->
<div class="hero-slider">
    <h1>Explora nuestros cursos</h1>
    <p>Aprende algo nuevo hoy con nuestros cursos gratuitos y pagos</p>
</div>

<!-- Listado de cursos -->
<div class="course-grid">
    <?php
    $sql = "SELECT * FROM cursos ORDER BY id DESC";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo '<div class="course-card">';
        echo '<img src="' . $row['imagen'] . '" alt="Curso">';
        echo '<div class="course-content">';
        echo '<h3>' . htmlspecialchars($row['titulo']) . '</h3>';
        echo '<p>' . substr(strip_tags($row['descripcion']), 0, 100) . '...</p>';
        if ($row['tipo'] == 'gratis') {
            echo '<a href="inscribir_curso.php?id=' . $row['id'] . '" class="btn-inscribirse btn-gratis">Inscribirse gratis</a>';
        } else {
            echo '<a href="pagar_curso.php?id=' . $row['id'] . '" class="btn-inscribirse btn-pagar">Pagar con PayPal</a>';
        }
        echo '</div></div>';
    }
    ?>
</div>

<?php include 'footer.php'; ?>
