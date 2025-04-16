<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Menú Peruano</title>
</head>
<body class="bg-dark text-light">

<?php
if (file_exists('./xml/carta.xml')) {
    $menu = simplexml_load_file('./xml/carta.xml');
} else {
    exit('Error al abrir el archivo de datos');
}
$tipoSeleccionado = isset($_GET['tipo']) ? $_GET['tipo'] : '';

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Tipos de Platos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                $tipos = [];
                foreach ($menu->plato as $plato) {
                    $tipo = (string)$plato['tipo'];
                    if (!in_array($tipo, $tipos)) {
                        echo '<li class="nav-item">';
                        if ($tipoSeleccionado === $tipo) {
                            echo '<a class="nav-link active" href="?tipo=' . $tipo . '">' . ucfirst($tipo) . '</a>';
                        } else {
                            echo '<a class="nav-link" href="?tipo=' . $tipo . '">' . ucfirst($tipo) . '</a>';
                        }
                        echo '</li>';
                        $tipos[] = $tipo;
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h1 class="text-center mb-4 text-danger">Menú Peruano</h1>
    <?php if ($tipoSeleccionado !== ''): ?>
        <p class="text-center text-light">Estás viendo los platos del tipo: <strong><?php echo ucfirst($tipoSeleccionado); ?></strong></p>
    <?php else: ?>
        <p class="text-center text-light">Estás viendo todos los platos disponibles.</p>
    <?php endif; ?>
    <div class="row">
    <?php
    foreach ($menu->plato as $plato) {
        if ($tipoSeleccionado === '' || $tipoSeleccionado === (string)$plato['tipo']) {
            echo '<div class="col-lg-4 col-md-6 mb-4">';
            echo '<div class="menu-item mb-3">';
            // Mostrar la imagen del plato
            if (!empty($plato->imagen)) {
                echo '<img src="' . $plato->imagen . '" class="img-fluid mb-3" alt="' . $plato->nombre . '">';
            } else {
                echo '<img src="img/default.jpg" class="img-fluid mb-3" alt="Imagen no disponible">';
            }
            echo '<h5 class="text-danger">' . $plato->nombre . '</h5>';
            echo '<p>' . $plato->descripcion . '</p>';
            echo '<p><strong>Precio:</strong> ' . $plato->precio . '€</p>';
            echo '<p><strong>Calorías:</strong> ' . $plato->calorias . ' kcal</p>';
            echo '<p><strong>Ingredientes:</strong> ';
            foreach ($plato->ingredientes->categoria as $ingrediente) {
                echo '<span class="badge bg-secondary me-1">' . $ingrediente . '</span>';
            }
            echo '</p>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>