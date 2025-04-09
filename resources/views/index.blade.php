<?php

$missatges = [];

include(base_path() . '/resources/views/navbar.blade.php');
require(base_path() . '/app/models/paginationModel.php');

use App\Models\paginationModel;


$articulosPorPagina = $_POST['post_per_page'] ?? ($_COOKIE['post_per_page'] ?? 10); // Default 10
$orderBy = $_POST['orderBy'] ?? ($_COOKIE['orderBy'] ?? 'dateAsc'); // Default 'dateAsc'

// Guardar las opciones en cookies
if ($orderBy) {
    setcookie('orderBy', $orderBy, time() + (86400 * 30), "/");
}
if ($articulosPorPagina) {
    setcookie('post_per_page', $articulosPorPagina, time() + (86400 * 30), "/");
}

// Determinar la página actual
$pagina = isset($_GET['page']) && $_GET['page'] > 0 ? intval($_GET['page']) : 1;

// Calcular el inicio para la paginación
$start = ($pagina - 1) * $articulosPorPagina;
try {
    if (!isset($_SESSION['usuari'])) {
        // Usuario no autenticado
        $total = paginationModel::obtenerTotalArticulos();
        $pages = ceil($total / $articulosPorPagina);
        $fetch = paginationModel::obtenerArticulos($start, $articulosPorPagina, $orderBy);
    } else {
        // Usuario autenticado
        $total = paginationModel::obtenerTotalArticulosPorUsuario($_SESSION['correu']);
        $pages = ceil($total / $articulosPorPagina);
        $fetch = paginationModel::obtenerArticulosPorUsuario($start, $articulosPorPagina, $_SESSION['correu'], $orderBy);
    }

    // Mostrar los artículos
    $query = $_POST['search-input'] ?? null;

    $resultados = paginationModel::searchBar($query);
    if (!empty($resultados)) {
        echo "<div class='card-container'>";
        foreach ($resultados as $entrada) {
            if (isset($_SESSION['usuari'])) {
                echo "<div class='card' id='card-{$entrada['id']}'>
                        <h3>ID: {$entrada['id']}</h3>
                        <hr>
                        <p>Modelo: {$entrada['model']}</p>
                        <p>Nombre: {$entrada['nom']}</p>
                        <p>Precio: {$entrada['preu']}€</p>
                        <p>Correo: {$entrada['correu']}</p>
                        <hr>
                        <div class='card-actions'>
                            <form action='controlador/controlador-cards.php' method='post' class='cards-form'>
                                <input type='hidden' name='id' value='{$entrada['id']}'>
                                <button type='button' data-bs-toggle='modal' data-bs-target='#eliminarArticle'>
                                    <img src='imagenes/icones/trash.svg'>
                                </button>

                                <div class='modal fade' id='eliminarArticle'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>

                                            <div class='modal-header'>
                                                <h3 class='modal-title'>Esborrar article</h3>
                                            </div>

                                            <div class='modal-body'>
                                                Estas segur que vols eliminar l'article?
                                            </div>

                                            <div class='modal-footer'>
                                            <button type='submit' data-bs-dismiss='modal' name='article-button' value='delete'>Si</button>
                                            <button type='button' data-bs-dismiss='modal'>No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action='vista/modificar.php' method='post' class='cards-form'>
                                <input type='hidden' name='id' value='{$entrada['id']}'>
                                    <button name='article-button' value='edit'>
                                        <img src='imagenes/icones/edit.svg'>
                                    </button>
                            </form>
                            <form action='controlador/controlador-qr.php' method='get' class='cards-form'>
                                <input type='hidden' name='id' value='{$entrada['id']}'>
                                <input type='hidden' name='model' value='{$entrada['model']}'>
                                <input type='hidden' name='nom' value='{$entrada['nom']}'>
                                <input type='hidden' name='preu' value='{$entrada['preu']}'>
                                <input type='hidden' name='correu' value='{$entrada['correu']}'>
                                    <button name='article-button' value='qr'>
                                        <img src='imagenes/icones/icons8-código-qr-24.png'>
                                    </button>
                            </form>
                            </div>
                        </div>";
            } else {
                echo "<div class='card' id='card-{$entrada['id']}'>
                <h3>ID: {$entrada['id']}</h3>
                <hr>
                <p>Modelo: {$entrada['model']}</p>
                <p>Nombre: {$entrada['nom']}</p>
                <p>Precio: {$entrada['preu']}€</p>
                <p>Correo: {$entrada['correu']}</p>
                <hr>
                </div>";
            }
            echo "</div>";
        }
    } else {
        if ($fetch) {
            echo "<div class='card-container'>";
            foreach ($fetch as $entrada) {
                if (isset($_SESSION['usuari'])) {
                    echo "<div class='card' id='card-{$entrada['id']}'>
                        <h3>ID: {$entrada['id']}</h3>
                        <hr>
                        <p>Modelo: {$entrada['model']}</p>
                        <p>Nombre: {$entrada['nom']}</p>
                        <p>Precio: {$entrada['preu']}€</p>
                        <p>Correo: {$entrada['correu']}</p>
                        <hr>
                        <div class='card-actions'>
                            <form action='controlador/controlador-cards.php' method='post' class='cards-form'>
                                <input type='hidden' name='id' value='{$entrada['id']}'>
                                <button type='button' data-bs-toggle='modal' data-bs-target='#eliminarArticle'>
                                    <img src='imagenes/icones/trash.svg'>
                                </button>

                                <div class='modal fade' id='eliminarArticle'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>

                                            <div class='modal-header'>
                                                <h3 class='modal-title'>Esborrar article</h3>
                                            </div>

                                            <div class='modal-body'>
                                                Estas segur que vols eliminar l'article?
                                            </div>

                                            <div class='modal-footer'>
                                            <button type='submit' data-bs-dismiss='modal' name='article-button' value='delete'>Si</button>
                                            <button type='button' data-bs-dismiss='modal'>No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action='vista/modificar.php' method='post' class='cards-form'>
                                <input type='hidden' name='id' value='{$entrada['id']}'>
                                    <button name='article-button' value='edit'>
                                        <img src='imagenes/icones/edit.svg'>
                                    </button>
                            </form>
                            <form action='controlador/controlador-qr.php' method='get' class='cards-form'>
                                <input type='hidden' name='id' value='{$entrada['id']}'>
                                <input type='hidden' name='model' value='{$entrada['model']}'>
                                <input type='hidden' name='nom' value='{$entrada['nom']}'>
                                <input type='hidden' name='preu' value='{$entrada['preu']}'>
                                <input type='hidden' name='correu' value='{$entrada['correu']}'>
                                    <button name='article-button' value='qr'>
                                        <img src='imagenes/icones/icons8-código-qr-24.png'>
                                    </button>
                            </form>
                            </div>
                        </div>";
                } else {
                    echo "<div class='card' id='card-{$entrada['id']}'>
                        <h3>ID: {$entrada['id']}</h3>
                        <hr>
                        <p>Modelo: {$entrada['model']}</p>
                        <p>Nombre: {$entrada['nom']}</p>
                        <p>Precio: {$entrada['preu']}€</p>
                        <p>Correo: {$entrada['correu']}</p>
                        <hr>
                        </div>";
                }
            }
            echo "</div>";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<div class="pagination">
    <?php if ($pages > 1): ?>
        <!-- Flecha anterior -->
        <?php if ($pagina > 1): ?>
            <a href="?page=<?= $pagina - 1; ?>" class="arrow">&laquo;</a>
        <?php endif; ?>

        <!-- Mostrar solo 3 botones en función de la página actual -->
        <?php
        $start = max(1, $pagina - 1); // Calcula el inicio del rango
        $end = min($pages, $start + 2); // Calcula el fin del rango
        for ($i = $start; $i <= $end; $i++): ?>
            <a href="?page=<?= htmlspecialchars($i); ?>"
                class="<?= $i === $pagina ? 'active' : ''; ?>">
                <?= htmlspecialchars($i); ?>
            </a>
        <?php endfor; ?>

        <!-- Flecha siguiente -->
        <?php if ($pagina < $pages): ?>
            <a href="?page=<?= $pagina + 1; ?>" class="arrow">&raquo;</a>
        <?php endif; ?>
    <?php endif; ?>
</div>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</head>

<body>
    <form action="#" method="post">
        <label for="orderBy"><strong>Order by || Post Per Page<strong></label>
        <select name="orderBy" id="orderBy">
            <option value="dateAsc" <?= $orderBy === 'dateAsc' ? 'selected' : '' ?>>Date (Asc)</option>
            <option value="dateDesc" <?= $orderBy === 'dateDesc' ? 'selected' : '' ?>>Date (Desc)</option>
            <option value="AlphabeticallyAsc" <?= $orderBy === 'AlphabeticallyAsc' ? 'selected' : '' ?>>Alphabetically (Asc)</option>
            <option value="AlphabeticallyDesc" <?= $orderBy === 'AlphabeticallyDesc' ? 'selected' : '' ?>>Alphabetically (Desc)</option>
        </select>

        <label for="post_per_page" aria-label="post per page">
            <select name=" post_per_page" id="post_per_page">
                <option value="5" <?= $articulosPorPagina == 5 ? 'selected' : '' ?>>5</option>
                <option value="10" <?= $articulosPorPagina == 10 ? 'selected' : '' ?>>10</option>
                <option value="15" <?= $articulosPorPagina == 15 ? 'selected' : '' ?>>15</option>
                <option value="20" <?= $articulosPorPagina == 20 ? 'selected' : '' ?>>20</option>
            </select>
        </label>

        <br><br>

        <input type="submit" name="OrderBy" value="Enviar">
    </form>

    <form method="POST">
        <label for="post_per_page" aria-label="search-input"></label>
        <input type="text" name="search-input" placeholder="Cercar articles per nom">
        <label for="post_per_page" aria-label="search-button"></label>
        <input type="submit" name="search-button" value="Search">
    </form>
</body>

</html>